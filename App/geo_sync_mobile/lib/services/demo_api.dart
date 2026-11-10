import 'package:flutter/foundation.dart';
import 'package:mobile/app_session.dart';
import 'package:mobile/services/api_exception.dart';
import 'package:shared_preferences/shared_preferences.dart';

/// Modo demonstração: responde às chamadas da API com dados embutidos no
/// próprio app, sem acessar a rede. Serve para apresentar o aplicativo quando
/// o servidor não está disponível.
///
/// As respostas seguem o mesmo formato da API Laravel (`success`, `data`,
/// `meta`), então nenhuma tela precisa saber que está em demonstração.
/// Alterações (aceitar remessa, mudar status, criar alerta…) ficam apenas em
/// memória e voltam ao estado inicial quando o app é reiniciado.
///
/// Login: qualquer senha. E-mails que contenham "motorista" entram na área do
/// motorista; os demais entram na área do cliente.
class DemoApi {
  DemoApi._();

  static const _preferenciaKey = 'geosync_modo_demonstracao';
  static const emailCliente = 'cliente@demo.com';
  static const emailMotorista = 'motorista@demo.com';

  /// Indica se o modo demonstração está ligado.
  static final ativo = ValueNotifier<bool>(false);

  static Future<void> restaurar() async {
    final prefs = await SharedPreferences.getInstance();
    ativo.value = prefs.getBool(_preferenciaKey) ?? false;
  }

  static Future<void> definir(bool valor) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setBool(_preferenciaKey, valor);
    ativo.value = valor;
    _estado = null; // recomeça com os dados originais
  }

  // ============================================================
  // ROTEADOR
  // ============================================================

  static Future<dynamic> responder(
    String method,
    String path, {
    Map<String, dynamic>? body,
    Map<String, dynamic>? query,
  }) async {
    // Pequena espera para que os indicadores de carregamento apareçam.
    await Future<void>.delayed(const Duration(milliseconds: 250));
    final metodo = method.toUpperCase();
    final s = path
        .split('/')
        .where((segmento) => segmento.isNotEmpty)
        .toList();
    final dados = _dados;
    debugPrint('[Demo] $metodo ${s.join('/')}');

    if (s.isEmpty) return _ok(null);
    switch (s.first) {
      case 'auth':
        return _auth(metodo, s, body);
      case 'perfil':
        return _ok(_usuarioAtual());
      case 'contatos':
        return _ok({'id': 1, ...?body}, mensagem: 'Mensagem enviada.');
      case 'remessas':
        return _remessas(metodo, s, body, dados);
      case 'alertas':
        return _alertas(metodo, s, body, dados);
      case 'motorista':
        return _ok(dados.documentos);
      case 'pagamentos':
        if (metodo == 'POST') {
          final novo = {
            'id': dados.pagamentos.length + 1,
            'user_id': _usuarioAtual()['id'],
            'valor': body?['valor'] ?? 0,
            'status': 'Aprovado',
            'created_at': _agora(),
          };
          dados.pagamentos.insert(0, novo);
          return _ok(novo, mensagem: 'Pagamento registrado.');
        }
        if (s.length > 1) return _ok(_buscar(dados.pagamentos, s[1]));
        return _ok(_paginado(dados.pagamentos));
      case 'avaliacoes':
        if (s.length > 1 && s[1] == 'resumo') {
          final notas = dados.avaliacoes.map((a) => a['nota'] as int).toList();
          final media = notas.reduce((a, b) => a + b) / notas.length;
          return _ok({
            'media': double.parse(media.toStringAsFixed(2)),
            'total': notas.length,
            'percentual_satisfacao':
                (notas.where((n) => n >= 4).length / notas.length * 100)
                    .round(),
          });
        }
        if (metodo == 'POST') {
          final nova = {
            'id': dados.avaliacoes.length + 1,
            'nome_exibicao': AppSession.nome,
            ...?body,
            'created_at': _agora(),
          };
          dados.avaliacoes.insert(0, nova);
          return _ok(nova, mensagem: 'Avaliação enviada.');
        }
        return _ok(_paginado(dados.avaliacoes));
      case 'localizacao':
        if (s.length >= 3 && s[1] == 'remessa') {
          final pontos = dados.trajetoDe(s[2]);
          if (s.length > 3 && s[3] == 'ultima') {
            return _ok(pontos.isEmpty ? null : pontos.last);
          }
          return _ok(pontos);
        }
        return _ok(<dynamic>[]);
    }
    return _ok(<dynamic>[]);
  }

  // ============================================================
  // ROTAS
  // ============================================================

  static Map<String, dynamic> _auth(
    String metodo,
    List<String> s,
    Map<String, dynamic>? body,
  ) {
    final acao = s.length > 1 ? s[1] : '';
    switch (acao) {
      case 'login':
      case 'register':
        final email = '${body?['email'] ?? ''}'.trim().toLowerCase();
        if (email.isEmpty) {
          throw const ApiException('Informe o e-mail.', statusCode: 422);
        }
        final motorista = email.contains('motorista');
        final usuario = motorista ? _motorista(email) : _cliente(email);
        return {
          'success': true,
          'message': 'Autenticação realizada com sucesso (demonstração).',
          'token': 'demo-token',
          'token_type': 'Bearer',
          'data': usuario,
        };
      case 'me':
        return _ok(_usuarioAtual());
      default:
        return _ok(null, mensagem: 'Operação concluída (demonstração).');
    }
  }

  static dynamic _remessas(
    String metodo,
    List<String> s,
    Map<String, dynamic>? body,
    _DadosDemo dados,
  ) {
    final motorista = AppSession.tipoUsuario == 'Motorista';
    if (s.length == 1) {
      if (metodo == 'POST') {
        final nova = dados.novaRemessa(body ?? {});
        return _ok(nova, mensagem: 'Remessa criada.');
      }
      return _paginado(dados.minhas(motorista: motorista));
    }
    final alvo = s[1];
    if (alvo == 'minhas') return _paginado(dados.minhas(motorista: motorista));
    if (alvo == 'disponiveis') return _paginado(dados.disponiveis());

    final remessa = _buscar(dados.remessas, alvo);
    if (remessa == null) {
      throw const ApiException('Remessa não encontrada.', statusCode: 404);
    }
    final acao = s.length > 2 ? s[2] : '';
    switch (acao) {
      case 'aceitar':
        remessa
          ..['motorista_id'] = _DadosDemo.motoristaId
          ..['motorista'] = _DadosDemo.motoristaResumo
          ..['status'] = 'Em Rota';
        dados.registrarHistorico(remessa, 'Em Rota', 'Remessa aceita');
        return _ok(remessa, mensagem: 'Remessa aceita.');
      case 'status':
        final status = '${body?['status'] ?? remessa['status']}';
        remessa['status'] = status;
        dados.registrarHistorico(remessa, status, 'Status atualizado');
        return _ok(remessa, mensagem: 'Status atualizado.');
      case 'historico':
        return _ok(dados.historicoDe(remessa));
      case 'ocorrencias':
        final alerta = dados.novoAlerta({
          'remessa_id': remessa['id'],
          'tipo': body?['categoria'] ?? 'Ocorrência',
          'mensagem': body?['descricao'] ?? 'Ocorrência registrada',
        });
        return _ok(alerta, mensagem: 'Ocorrência registrada.');
      case 'comprovante':
        remessa['status'] = 'Entregue';
        dados.registrarHistorico(remessa, 'Entregue', 'Comprovante enviado');
        return _ok(remessa, mensagem: 'Entrega confirmada.');
    }
    if (metodo == 'PUT' || metodo == 'PATCH') {
      remessa.addAll({...?body, 'updated_at': _agora()});
      return _ok(remessa, mensagem: 'Remessa atualizada.');
    }
    if (metodo == 'DELETE') {
      dados.remessas.remove(remessa);
      return _ok(null, mensagem: 'Remessa excluída.');
    }
    return _ok(remessa);
  }

  static dynamic _alertas(
    String metodo,
    List<String> s,
    Map<String, dynamic>? body,
    _DadosDemo dados,
  ) {
    if (s.length == 1) {
      if (metodo == 'POST') {
        return _ok(dados.novoAlerta(body ?? {}), mensagem: 'Alerta criado.');
      }
      return _ok(_paginado(dados.alertas));
    }
    final alerta = _buscar(dados.alertas, s[1]);
    if (alerta == null) {
      throw const ApiException('Alerta não encontrado.', statusCode: 404);
    }
    if (metodo == 'DELETE') {
      dados.alertas.remove(alerta);
      return _ok(null, mensagem: 'Alerta excluído.');
    }
    if (metodo == 'PUT' || metodo == 'PATCH') {
      alerta.addAll({...?body, 'updated_at': _agora()});
    }
    return _ok(alerta);
  }

  // ============================================================
  // AUXILIARES
  // ============================================================

  static _DadosDemo? _estado;
  static _DadosDemo get _dados => _estado ??= _DadosDemo();

  static Map<String, dynamic> _ok(Object? data, {String? mensagem}) => {
    'success': true,
    'message': ?mensagem,
    'data': data,
  };

  static Map<String, dynamic> _paginado(List<Map<String, dynamic>> itens) => {
    'success': true,
    'data': itens,
    'meta': {
      'current_page': 1,
      'last_page': 1,
      'per_page': 100,
      'total': itens.length,
    },
  };

  static Map<String, dynamic>? _buscar(
    List<Map<String, dynamic>> itens,
    String id,
  ) {
    for (final item in itens) {
      if ('${item['id']}' == id || '${item['codigo_rastreio']}' == id) {
        return item;
      }
    }
    return null;
  }

  static String _agora() => DateTime.now().toUtc().toIso8601String();

  static Map<String, dynamic> _usuarioAtual() =>
      AppSession.tipoUsuario == 'Motorista'
      ? _motorista(AppSession.email)
      : _cliente(AppSession.email);

  static Map<String, dynamic> _cliente(String email) => {
    'id': _DadosDemo.clienteId,
    'name': 'Cliente Demonstração',
    'email': email.isEmpty ? emailCliente : email,
    'tipo': 'cliente',
    'telefone': '(11) 90000-0001',
    'foto': null,
  };

  static Map<String, dynamic> _motorista(String email) => {
    'id': _DadosDemo.motoristaId,
    'name': 'Motorista Demonstração',
    'email': email.isEmpty ? emailMotorista : email,
    'tipo': 'motorista',
    'status': 'ativo',
    'telefone': '(11) 90000-0002',
    'foto': null,
    'veiculo': {
      'modelo': 'Fiat Fiorino',
      'placa': 'DEM-0A12',
      'renavam': '00123456789',
      'ano': '2023',
      'capacidade': '650',
    },
  };
}

/// Dados embutidos usados pelo modo demonstração.
class _DadosDemo {
  _DadosDemo() {
    final hoje = DateTime.now();
    String dia(int deslocamento) => hoje
        .add(Duration(days: deslocamento))
        .toIso8601String()
        .substring(0, 10);
    String momento(int horasAtras) => hoje
        .subtract(Duration(hours: horasAtras))
        .toUtc()
        .toIso8601String();

    Map<String, dynamic> remessa({
      required int id,
      required String origem,
      required String destino,
      required String cidade,
      required double lat,
      required double lng,
      required String carga,
      required String peso,
      required int prazo,
      required String status,
      required int horasAtras,
      bool comMotorista = true,
    }) => {
      'id': id,
      'codigo_rastreio':
          'GS-${dia(0).replaceAll('-', '')}-${(1000 + id * 137) % 9000 + 1000}',
      'origem': origem,
      'destino': destino,
      'destino_cidade': cidade,
      'destino_estado': 'SP',
      'latitude_destino': lat,
      'longitude_destino': lng,
      'tipo_carga': carga,
      'peso': peso,
      'previsao_entrega': dia(prazo),
      'status': status,
      'cliente_id': clienteId,
      'motorista_id': comMotorista ? motoristaId : null,
      'created_at': momento(horasAtras + 24),
      'updated_at': momento(horasAtras),
      'cliente': clienteResumo,
      'motorista': comMotorista ? motoristaResumo : null,
    };

    remessas.addAll([
      remessa(id: 1, origem: 'São Paulo', destino: 'Av. Paulista, 1578 - Bela Vista - São Paulo - SP', cidade: 'São Paulo', lat: -23.5614, lng: -46.6559, carga: 'Eletrônico', peso: '12.50', prazo: 0, status: 'Em Rota', horasAtras: 1),
      remessa(id: 2, origem: 'Campinas', destino: 'Rua Barão de Jaguara, 900 - Centro - Campinas - SP', cidade: 'Campinas', lat: -22.9056, lng: -47.0608, carga: 'Eletrodoméstico', peso: '55.00', prazo: 1, status: 'Em Rota', horasAtras: 3),
      remessa(id: 3, origem: 'Jundiaí', destino: 'Av. Nove de Julho, 1200 - Anhangabaú - Jundiaí - SP', cidade: 'Jundiaí', lat: -23.1857, lng: -46.8978, carga: 'Móveis', peso: '80.00', prazo: -1, status: 'Atrasado', horasAtras: 5),
      remessa(id: 4, origem: 'Sorocaba', destino: 'Rua XV de Novembro, 300 - Centro - Sorocaba - SP', cidade: 'Sorocaba', lat: -23.5015, lng: -47.4526, carga: 'Documentos', peso: '1.20', prazo: -2, status: 'Entregue', horasAtras: 20),
      remessa(id: 5, origem: 'São Paulo', destino: 'Rua Augusta, 2100 - Jardins - São Paulo - SP', cidade: 'São Paulo', lat: -23.5617, lng: -46.6640, carga: 'Vestuário', peso: '8.00', prazo: -3, status: 'Entregue', horasAtras: 48),
      remessa(id: 6, origem: 'Santos', destino: 'Av. Ana Costa, 400 - Gonzaga - Santos - SP', cidade: 'Santos', lat: -23.9659, lng: -46.3336, carga: 'Alimentos', peso: '30.00', prazo: 2, status: 'Em Rota', horasAtras: 2),
      remessa(id: 7, origem: 'Ribeirão Preto', destino: 'Av. Presidente Vargas, 2001 - Jardim América - Ribeirão Preto - SP', cidade: 'Ribeirão Preto', lat: -21.1990, lng: -47.8110, carga: 'Peças automotivas', peso: '45.00', prazo: 3, status: 'Pendente', horasAtras: 4, comMotorista: false),
      remessa(id: 8, origem: 'Guarulhos', destino: 'Rua Dom Pedro II, 150 - Centro - Guarulhos - SP', cidade: 'Guarulhos', lat: -23.4628, lng: -46.5333, carga: 'Eletrônico', peso: '15.00', prazo: 2, status: 'Pendente', horasAtras: 6, comMotorista: false),
    ]);

    alertas.addAll([
      {
        'id': 1,
        'tipo': 'Trânsito intenso',
        'titulo': 'Trânsito intenso',
        'mensagem': 'Congestionamento na Rodovia dos Bandeirantes, km 45.',
        'remessa_id': 3,
        'created_at': momento(2),
        'updated_at': momento(2),
        'remessa': _resumoRemessa(remessas[2]),
      },
      {
        'id': 2,
        'tipo': 'Condições climáticas ruins',
        'titulo': 'Condições climáticas ruins',
        'mensagem': 'Chuva forte prevista para a região de Santos.',
        'remessa_id': 6,
        'created_at': momento(6),
        'updated_at': momento(6),
        'remessa': _resumoRemessa(remessas[5]),
      },
    ]);

    pagamentos.addAll([
      {'id': 1, 'user_id': clienteId, 'valor': '349.90', 'status': 'Aprovado', 'created_at': momento(30)},
      {'id': 2, 'user_id': clienteId, 'valor': '189.50', 'status': 'Aprovado', 'created_at': momento(72)},
      {'id': 3, 'user_id': clienteId, 'valor': '420.00', 'status': 'Aprovado', 'created_at': momento(120)},
    ]);

    const comentarios = [
      (5, 'Ana Souza', 'Entrega rápida e bem embalada.'),
      (4, 'Carlos Lima', 'Bom acompanhamento pelo mapa.'),
      (5, 'Juliana Alves', 'Motorista muito atencioso.'),
      (3, 'Pedro Rocha', 'Chegou um pouco depois do previsto.'),
      (5, 'Mariana Costa', 'Recomendo, tudo certo.'),
      (4, 'Rafael Nunes', 'Atualizações em tempo real ajudaram.'),
    ];
    for (var i = 0; i < comentarios.length; i++) {
      final (nota, nome, texto) = comentarios[i];
      avaliacoes.add({
        'id': i + 1,
        'nota': nota,
        'nome_exibicao': nome,
        'comentario': texto,
        'created_at': momento(24 * (i + 1)),
      });
    }

    documentos.addAll([
      {'id': 1, 'tipo': 'cnh', 'status': 'aprovado', 'validade': dia(400)},
      {'id': 2, 'tipo': 'crlv', 'status': 'aprovado', 'validade': dia(200)},
    ]);
  }

  static const clienteId = 1;
  static const motoristaId = 2;
  static const clienteResumo = {
    'id': clienteId,
    'name': 'Cliente Demonstração',
    'email': DemoApi.emailCliente,
  };
  static const motoristaResumo = {
    'id': motoristaId,
    'name': 'Motorista Demonstração',
    'email': DemoApi.emailMotorista,
  };

  /// Ponto de partida dos trajetos simulados (centro de São Paulo).
  static const _origem = (-23.5505, -46.6333);

  final remessas = <Map<String, dynamic>>[];
  final alertas = <Map<String, dynamic>>[];
  final pagamentos = <Map<String, dynamic>>[];
  final avaliacoes = <Map<String, dynamic>>[];
  final documentos = <Map<String, dynamic>>[];
  final _historico = <String, List<Map<String, dynamic>>>{};

  List<Map<String, dynamic>> minhas({required bool motorista}) => remessas
      .where(
        (r) => motorista
            ? r['motorista_id'] == motoristaId
            : r['cliente_id'] == clienteId,
      )
      .toList();

  List<Map<String, dynamic>> disponiveis() => remessas
      .where((r) => r['motorista_id'] == null && r['status'] == 'Pendente')
      .toList();

  Map<String, dynamic> novaRemessa(Map<String, dynamic> dados) {
    final id = remessas.length + 1;
    final agora = DateTime.now().toUtc().toIso8601String();
    final nova = <String, dynamic>{
      'id': id,
      'codigo_rastreio': 'GS-DEMO-${1000 + id}',
      'status': 'Pendente',
      'cliente_id': clienteId,
      'motorista_id': null,
      'cliente': clienteResumo,
      'created_at': agora,
      'updated_at': agora,
      ...dados,
    };
    remessas.insert(0, nova);
    return nova;
  }

  Map<String, dynamic> novoAlerta(Map<String, dynamic> dados) {
    final agora = DateTime.now().toUtc().toIso8601String();
    final remessa = remessas
        .where((r) => '${r['id']}' == '${dados['remessa_id']}')
        .firstOrNull;
    final alerta = <String, dynamic>{
      'id': alertas.length + 1,
      'tipo': dados['tipo'] ?? 'Ocorrência',
      'titulo': dados['tipo'] ?? 'Ocorrência',
      'mensagem': dados['mensagem'] ?? '',
      'remessa_id': dados['remessa_id'],
      'created_at': agora,
      'updated_at': agora,
      if (remessa != null) 'remessa': _resumoRemessa(remessa),
    };
    alertas.insert(0, alerta);
    return alerta;
  }

  void registrarHistorico(
    Map<String, dynamic> remessa,
    String status,
    String descricao,
  ) {
    final agora = DateTime.now().toUtc().toIso8601String();
    remessa['updated_at'] = agora;
    historicoDe(remessa).add({
      'status': status,
      'descricao': descricao,
      'created_at': agora,
    });
  }

  List<Map<String, dynamic>> historicoDe(Map<String, dynamic> remessa) =>
      _historico.putIfAbsent('${remessa['id']}', () {
        final criada = '${remessa['created_at']}';
        return [
          {'status': 'Pendente', 'descricao': 'Remessa criada', 'created_at': criada},
          if (remessa['status'] != 'Pendente')
            {
              'status': 'Em Rota',
              'descricao': 'Saiu para entrega',
              'created_at': remessa['updated_at'],
            },
          if (remessa['status'] == 'Entregue' ||
              remessa['status'] == 'Atrasado')
            {
              'status': remessa['status'],
              'descricao': remessa['status'] == 'Entregue'
                  ? 'Entrega concluída'
                  : 'Entrega atrasada',
              'created_at': remessa['updated_at'],
            },
        ];
      });

  /// Trajeto simulado do centro de São Paulo até o destino da remessa.
  List<Map<String, dynamic>> trajetoDe(String id) {
    final remessa = remessas
        .where((r) => '${r['id']}' == id || r['codigo_rastreio'] == id)
        .firstOrNull;
    if (remessa == null || remessa['motorista_id'] == null) return [];
    final destinoLat = remessa['latitude_destino'] as double;
    final destinoLng = remessa['longitude_destino'] as double;
    final progresso = switch (remessa['status']) {
      'Entregue' => 1.0,
      'Atrasado' => 0.45,
      _ => 0.7,
    };
    const passos = 8;
    final agora = DateTime.now();
    return [
      for (var i = 0; i <= passos; i++)
        {
          'id': i + 1,
          'remessa_id': remessa['id'],
          'latitude':
              _origem.$1 + (destinoLat - _origem.$1) * progresso * i / passos,
          'longitude':
              _origem.$2 + (destinoLng - _origem.$2) * progresso * i / passos,
          'fonte': 'demo',
          'created_at': agora
              .subtract(Duration(minutes: (passos - i) * 10))
              .toUtc()
              .toIso8601String(),
        },
    ];
  }

  static Map<String, dynamic> _resumoRemessa(Map<String, dynamic> r) => {
    'id': r['id'],
    'codigo_rastreio': r['codigo_rastreio'],
    'cliente_id': r['cliente_id'],
    'motorista_id': r['motorista_id'],
  };
}
