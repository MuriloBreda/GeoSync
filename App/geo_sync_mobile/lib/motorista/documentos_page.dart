import 'dart:io';

import 'package:flutter/material.dart';
import 'package:lucide_icons_flutter/lucide_icons.dart';
import 'package:image_picker/image_picker.dart';
import 'package:path/path.dart' as path;
import 'package:path_provider/path_provider.dart';
import 'package:mobile/app_session.dart';
import 'package:mobile/services/api_exception.dart';
import 'package:mobile/services/api_service.dart';
import 'package:mobile/sync/location_point.dart' show gerarIdLocal;
import 'package:mobile/sync/pending_queue.dart';
import 'package:mobile/sync/sync_engine.dart';
import 'package:mobile/widgets/app_gradient_header.dart';
import 'package:mobile/widgets/responsive_content.dart';

class DocumentosMotoristaPage extends StatefulWidget {
  const DocumentosMotoristaPage({super.key});
  @override
  State<DocumentosMotoristaPage> createState() =>
      _DocumentosMotoristaPageState();
}

class _DocumentosMotoristaPageState extends State<DocumentosMotoristaPage> {
  static const primary = Color(0xFF0C46FF);
  bool _enviando = false;
  bool _carregando = true;
  List<Map<String, dynamic>> _documentosApi = [];
  Map<String, dynamic> _perfilApi = {};
  List<PendingAction> _acoesOffline = [];
  final Map<String, int> _tamanhosPendentes = {};
  String? _removendoId;
  String? _erro;

  @override
  void initState() {
    super.initState();
    SyncEngine.instance.estado.addListener(_atualizarPendencias);
    _atualizarPendencias();
    _carregarDocumentos();
  }

  @override
  void dispose() {
    SyncEngine.instance.estado.removeListener(_atualizarPendencias);
    super.dispose();
  }

  Future<void> _atualizarPendencias() async {
    final anteriores = _acoesOffline;
    final atuais = (await PendingQueue.instance.listar())
        .where(
          (acao) =>
              acao.tipo == TipoAcao.documentoCnh ||
              acao.tipo == TipoAcao.documentoCrlv,
        )
        .toList();
    final tamanhos = <String, int>{};
    for (final acao in atuais) {
      final arquivo = acao.corpo?['caminho_arquivo'];
      if (arquivo is! String) continue;
      try {
        tamanhos[acao.id] = await File(arquivo).length();
      } on FileSystemException {
        // Um arquivo ausente fica visível como erro abaixo, sem ocultar a ação.
      }
    }
    if (!mounted) return;
    setState(() {
      _acoesOffline = atuais;
      _tamanhosPendentes
        ..clear()
        ..addAll(tamanhos);
    });
    final removida = anteriores.any(
      (anterior) => !atuais.any((atual) => atual.id == anterior.id),
    );
    if (removida) await _carregarDocumentos();
  }

  Future<void> _removerDocumentoPendente(PendingAction acao) async {
    final confirmar = await showDialog<bool>(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Remover envio pendente?'),
        content: const Text(
          'A foto salva neste aparelho e a tentativa de envio serão removidas.',
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context, false),
            child: const Text('Manter'),
          ),
          FilledButton(
            onPressed: () => Navigator.pop(context, true),
            child: const Text('Remover'),
          ),
        ],
      ),
    );
    if (confirmar != true || !mounted) return;
    setState(() => _removendoId = acao.id);
    try {
      final arquivo = acao.corpo?['caminho_arquivo'];
      await SyncEngine.instance.removerAcaoPendente(acao.id);
      if (arquivo is String) {
        try {
          await File(arquivo).delete();
        } on FileSystemException {
          // A fila foi removida; arquivo já ausente não precisa de ação adicional.
        }
      }
      final documentos = AppSession.documentosMotorista.value;
      AppSession.salvarDocumentos(
        acao.tipo == TipoAcao.documentoCnh
            ? documentos.copyWith(cnhEnviada: false)
            : documentos.copyWith(crlvEnviado: false),
      );
      await _atualizarPendencias();
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Envio pendente removido do aparelho.')),
        );
      }
    } finally {
      if (mounted) setState(() => _removendoId = null);
    }
  }

  String _formatarTamanho(int? bytes) {
    if (bytes == null) return 'Arquivo não encontrado';
    if (bytes < 1024) return '$bytes B';
    if (bytes < 1024 * 1024) return '${(bytes / 1024).toStringAsFixed(1)} KB';
    return '${(bytes / (1024 * 1024)).toStringAsFixed(2)} MB';
  }

  Future<void> _tentarDocumento(String tipo) async {
    final acao = _acoesOffline
        .where((item) => item.tipo == _tipoAcaoDocumento(tipo))
        .firstOrNull;
    if (acao == null) return;
    try {
      await SyncEngine.instance.tentarAcaoNovamente(acao.id);
    } on ApiException catch (error) {
      if (mounted) {
        ScaffoldMessenger.of(
          context,
        ).showSnackBar(SnackBar(content: Text(error.message)));
      }
    }
    await _atualizarPendencias();
  }

  Future<void> _carregarDocumentos() async {
    if (mounted) {
      setState(() {
        _carregando = true;
        _erro = null;
      });
    }
    try {
      final resposta = await ApiService.instance.documentosMotorista();
      if (mounted) {
        setState(() {
          _documentosApi = resposta
              .whereType<Map>()
              .map((item) => Map<String, dynamic>.from(item))
              .toList();
        });
      }
    } on ApiException catch (error) {
      if (error.statusCode != 404) _erro = error.message;
      // A tela permanece disponível quando a consulta estiver offline.
    } catch (error) {
      _erro = error.toString();
    }
    try {
      final usuario = ApiService.instance.authUser(
        await ApiService.instance.me(),
      );
      final motorista = usuario['motorista'] ?? usuario['driver'];
      if (mounted) {
        setState(() {
          _perfilApi = motorista is Map
              ? Map<String, dynamic>.from(motorista)
              : usuario;
          if (_documentosApi.isEmpty) {
            final documentos =
                _perfilApi['documentos'] ??
                _perfilApi['documents'] ??
                _perfilApi['documentos_motorista'] ??
                _perfilApi['driver_documents'];
            if (documentos is List) {
              _documentosApi = documentos
                  .whereType<Map>()
                  .map((item) => Map<String, dynamic>.from(item))
                  .toList();
            }
          }
        });
      }
    } on ApiException catch (error) {
      if (mounted && _erro == null) setState(() => _erro = error.message);
    } finally {
      if (mounted) setState(() => _carregando = false);
    }
  }

  String _status(String tipo, bool enviado) {
    final acaoOffline = _acoesOffline
        .where((acao) => acao.tipo == _tipoAcaoDocumento(tipo))
        .firstOrNull;
    if (acaoOffline != null) {
      return acaoOffline.requerIntervencao
          ? 'review_required'
          : 'aguardando_sync';
    }
    Map<String, dynamic>? documento;
    for (final item in _documentosApi) {
      final tipoApi =
          '${item['tipo'] ?? item['tipo_documento'] ?? item['document_type']}'
              .toLowerCase();
      if (tipoApi == tipo || tipoApi.contains(tipo)) {
        documento = item;
        break;
      }
    }
    final perfilDocumento = _perfilApi[tipo];
    final status =
        documento?['status'] ??
        documento?['situacao'] ??
        documento?['status_documento'] ??
        (perfilDocumento is Map
            ? perfilDocumento['status'] ?? perfilDocumento['situacao']
            : null) ??
        _perfilApi['${tipo}_status'] ??
        _perfilApi['status_$tipo'];
    final validade = _validade(tipo);
    final dataValidade = DateTime.tryParse(validade) ?? _dataBr(validade);
    if (dataValidade != null &&
        DateTime(
          dataValidade.year,
          dataValidade.month,
          dataValidade.day,
        ).isBefore(DateTime.now())) {
      return 'expired';
    }
    if (status != null && '$status'.trim().isNotEmpty) return '$status';
    return enviado ? 'pendente' : 'não informado';
  }

  String _tipoAcaoDocumento(String tipo) =>
      tipo == 'cnh' ? TipoAcao.documentoCnh : TipoAcao.documentoCrlv;

  DateTime? _dataBr(String valor) {
    final partes = valor.split(RegExp(r'[/.-]'));
    if (partes.length != 3) return null;
    final dia = int.tryParse(partes[0]);
    final mes = int.tryParse(partes[1]);
    final ano = int.tryParse(partes[2]);
    if (dia == null || mes == null || ano == null || ano < 1000) return null;
    return DateTime(ano, mes, dia);
  }

  String _validade(String tipo) {
    final registro = _documentosApi
        .where(
          (item) =>
              '${item['tipo'] ?? item['tipo_documento'] ?? item['document_type']}'
                  .toLowerCase()
                  .contains(tipo),
        )
        .firstOrNull;
    final perfilDocumento = _perfilApi[tipo];
    final fontes = <Map>[
      if (registro case final Map registroEncontrado) registroEncontrado,
      if (perfilDocumento is Map) perfilDocumento,
      _perfilApi,
    ];
    final chaves = tipo == 'cnh'
        ? ['validade', 'validade_cnh', 'cnh_validade', 'data_validade_cnh']
        : ['validade', 'validade_crlv', 'crlv_validade', 'data_validade_crlv'];
    for (final fonte in fontes) {
      for (final chave in chaves) {
        final valor = fonte[chave];
        if (valor != null && '$valor'.trim().isNotEmpty) return '$valor';
      }
    }
    return '';
  }

  String _detalheDocumento(String tipo, String status) {
    final validade = _validade(tipo);
    final registro = _documentosApi
        .where(
          (item) =>
              '${item['tipo'] ?? item['tipo_documento'] ?? item['document_type']}'
                  .toLowerCase()
                  .contains(tipo),
        )
        .firstOrNull;
    final motivo =
        registro?['motivo_reprovacao'] ??
        registro?['motivo'] ??
        registro?['observacao'] ??
        registro?['mensagem_rejeicao'] ??
        registro?['rejection_reason'];
    final dados = <String>[
      'Status: ${_rotuloStatus(status)}',
      'Validade: ${validade.isEmpty ? 'não informada pela API' : validade}',
    ];
    if (motivo != null && '$motivo'.trim().isNotEmpty) {
      dados.add('Correção: $motivo');
    } else if ({'rejected', 'recusado'}.contains(status.toLowerCase())) {
      dados.add('Envie uma imagem legível e atualizada para nova análise.');
    } else if ({
      'expired',
      'vencido',
      'expirado',
    }.contains(status.toLowerCase())) {
      dados.add('Atualize o documento vencido.');
    }
    return dados.join(' • ');
  }

  String _rotuloStatus(String status) {
    final normalizado = status
        .trim()
        .toLowerCase()
        .replaceAll('á', 'a')
        .replaceAll('ã', 'a')
        .replaceAll('ç', 'c');
    switch (normalizado) {
      case 'approved':
      case 'aprovado':
      case 'valid':
      case 'valido':
        return 'Aprovado';
      case 'rejected':
      case 'recusado':
        return 'Recusado';
      case 'pending':
      case 'pendente':
        return 'Pendente para an\u00e1lise';
      case 'aguardando_sync':
        return 'Aguardando sincroniza\u00e7\u00e3o';
      case 'review_required':
        return 'Precisa de revis\u00e3o';
      case 'expired':
      case 'vencido':
      case 'expirado':
        return 'Vencido';
      case 'nao informado':
        return 'N\u00e3o informado pela API';
      default:
        return status;
    }
  }

  String _campoCnh(List<String> chaves) {
    final cnh = _perfilApi['cnh'];
    final fontes = <Map>[
      if (cnh is Map) cnh,
      _perfilApi,
      ..._documentosApi.where((item) {
        final tipo =
            '${item['tipo'] ?? item['tipo_documento'] ?? item['document_type']}'
                .toLowerCase();
        return tipo.contains('cnh');
      }),
    ];
    for (final fonte in fontes) {
      for (final chave in chaves) {
        final valor = fonte[chave];
        if (valor != null && '$valor'.trim().isNotEmpty) {
          return '$valor'.trim();
        }
      }
    }
    return '';
  }

  Future<void> _enviar(bool cnh) async {
    String? caminhoImagem;
    try {
      final imagem = await ImagePicker().pickImage(
        source: ImageSource.gallery,
        maxWidth: 1600,
        imageQuality: 80,
      );
      if (imagem == null || !mounted) return;
      caminhoImagem = imagem.path;
      setState(() => _enviando = true);
      await ApiService.instance.enviarDocumentoMotorista(
        tipo: cnh ? 'cnh' : 'crlv',
        caminhoArquivo: imagem.path,
      );
      if (!mounted) return;
      final docs = AppSession.documentosMotorista.value;
      AppSession.salvarDocumentos(
        cnh
            ? docs.copyWith(cnhEnviada: true)
            : docs.copyWith(crlvEnviado: true),
      );
      await _carregarDocumentos();
      if (!mounted) return;
      setState(() {});
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('${cnh ? 'CNH' : 'CRLV'} enviado para análise.'),
          behavior: SnackBarBehavior.floating,
        ),
      );
    } on ApiException catch (error) {
      if ((error.statusCode == null ||
              error.statusCode == 429 ||
              error.statusCode! >= 500) &&
          mounted &&
          caminhoImagem != null) {
        final tipo = cnh ? 'cnh' : 'crlv';
        final diretorio = await getApplicationDocumentsDirectory();
        final pasta = Directory(
          path.join(diretorio.path, 'documentos_pendentes'),
        );
        await pasta.create(recursive: true);
        final id = gerarIdLocal();
        final extensao = path.extension(caminhoImagem).isEmpty
            ? '.jpg'
            : path.extension(caminhoImagem);
        final copia = await File(
          caminhoImagem,
        ).copy(path.join(pasta.path, '$id$extensao'));
        final tipoAcao = _tipoAcaoDocumento(tipo);
        final substituidas = (await PendingQueue.instance.listar())
            .where((acao) => acao.tipo == tipoAcao)
            .toList();
        await SyncEngine.instance.registrarRequisicaoOffline(
          tipo: tipoAcao,
          metodo: 'POST',
          caminho: 'motorista/documentos/$tipo',
          corpo: {'caminho_arquivo': copia.path},
        );
        for (final antiga in substituidas) {
          final caminhoAntigo = antiga.corpo?['caminho_arquivo'];
          if (caminhoAntigo is String && caminhoAntigo != copia.path) {
            try {
              await File(caminhoAntigo).delete();
            } catch (_) {
              // A pendência nova já está salva; limpeza é apenas auxiliar.
            }
          }
        }
        AppSession.salvarDocumentos(
          cnh
              ? AppSession.documentosMotorista.value.copyWith(cnhEnviada: true)
              : AppSession.documentosMotorista.value.copyWith(
                  crlvEnviado: true,
                ),
        );
        await _atualizarPendencias();
        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(
              content: Text(
                '${tipo.toUpperCase()} guardado no aparelho. O envio ser\u00e1 tentado quando a conex\u00e3o voltar.',
              ),
            ),
          );
        }
        return;
      }
      if (!mounted) return;
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text(error.message)));
    } catch (_) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Não foi possível abrir a galeria.')),
      );
    } finally {
      if (mounted) setState(() => _enviando = false);
    }
  }

  void _escolherDocumento() => showModalBottomSheet(
    context: context,
    builder: (context) => SafeArea(
      child: Wrap(
        children: [
          ListTile(
            leading: const Icon(LucideIcons.idCard),
            title: const Text('Atualizar CNH'),
            onTap: () {
              Navigator.pop(context);
              _enviar(true);
            },
          ),
          ListTile(
            leading: const Icon(LucideIcons.fileText),
            title: const Text('Atualizar CRLV'),
            onTap: () {
              Navigator.pop(context);
              _enviar(false);
            },
          ),
        ],
      ),
    ),
  );
  @override
  Widget build(BuildContext context) {
    final docs = AppSession.documentosMotorista.value;
    final cnhStatus = _status('cnh', docs.cnhEnviada);
    final crlvStatus = _status('crlv', docs.crlvEnviado);
    String normalizar(String valor) => valor
        .trim()
        .toLowerCase()
        .replaceAll('á', 'a')
        .replaceAll('ã', 'a')
        .replaceAll('ç', 'c');
    final cnhNormalizada = normalizar(cnhStatus);
    final crlvNormalizada = normalizar(crlvStatus);
    final pendente =
        {
          'pendente',
          'pending',
          'aguardando_sync',
          'review_required',
        }.contains(cnhNormalizada) ||
        {
          'pendente',
          'pending',
          'aguardando_sync',
          'review_required',
        }.contains(crlvNormalizada);
    final aprovados = {'aprovado', 'approved', 'valid', 'valido'};
    final regularizada =
        aprovados.contains(cnhNormalizada) &&
        aprovados.contains(crlvNormalizada);
    final numeroCnh = _campoCnh([
      'numero',
      'numero_cnh',
      'cnh_numero',
      'registro_cnh',
    ]);
    final categoriaCnh = _campoCnh([
      'categoria',
      'categoria_cnh',
      'cnh_categoria',
    ]);
    final validadeCnh = _validade('cnh');
    final validadeCrlv = _validade('crlv');
    return Scaffold(
      body: SafeArea(
        bottom: false,
        child: Column(
          children: [
            const AppGradientHeader(
              title: 'Documentos',
              subtitle: 'CNH e CRLV do motorista',
              icon: LucideIcons.idCard,
            ),
            Expanded(
              child: ResponsiveContent(
                child: ListView(
                  padding: const EdgeInsets.all(16),
                  children: [
                    Container(
                      padding: const EdgeInsets.all(18),
                      decoration: BoxDecoration(
                        gradient: const LinearGradient(
                          colors: [Color(0xFF0B2A4A), primary],
                        ),
                        borderRadius: BorderRadius.circular(22),
                      ),
                      child: Row(
                        children: [
                          const CircleAvatar(
                            radius: 25,
                            backgroundColor: Colors.white24,
                            child: Icon(
                              LucideIcons.badgeCheck,
                              color: Colors.white,
                            ),
                          ),
                          const SizedBox(width: 14),
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  pendente
                                      ? 'Documentos em análise'
                                      : regularizada
                                      ? 'Documentação regularizada'
                                      : 'Documentação incompleta',
                                  style: const TextStyle(
                                    color: Colors.white,
                                    fontSize: 16,
                                    fontWeight: FontWeight.w800,
                                  ),
                                ),
                                const SizedBox(height: 4),
                                Text(
                                  pendente
                                      ? 'Você receberá um aviso após a validação.'
                                      : regularizada
                                      ? 'CNH e CRLV aprovados pela API.'
                                      : 'Confira os status e envie os documentos que faltam.',
                                  style: const TextStyle(
                                    color: Colors.white70,
                                    fontSize: 11,
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                    ),
                    const SizedBox(height: 22),
                    const Text(
                      'Documentos pessoais',
                      style: TextStyle(
                        fontSize: 18,
                        fontWeight: FontWeight.w800,
                      ),
                    ),
                    const SizedBox(height: 12),
                    if (_carregando) const LinearProgressIndicator(),
                    if (_erro != null) ...[
                      const SizedBox(height: 8),
                      Text(
                        'Não foi possível atualizar os documentos: $_erro',
                        style: TextStyle(
                          color: Theme.of(context).colorScheme.error,
                        ),
                      ),
                    ],
                    _documento(
                      'cnh',
                      LucideIcons.idCard,
                      'CNH',
                      AppSession.nome.isEmpty ? 'Motorista' : AppSession.nome,
                      _detalheDocumento('cnh', cnhStatus),
                      cnhStatus,
                      () => _enviar(true),
                    ),
                    _documento(
                      'crlv',
                      LucideIcons.fileText,
                      'Documento do veículo',
                      'CRLV',
                      _detalheDocumento('crlv', crlvStatus),
                      crlvStatus,
                      () => _enviar(false),
                    ),
                    if (_acoesOffline.isNotEmpty) ...[
                      const SizedBox(height: 12),
                      _cartaoPendencias(),
                    ],
                    const SizedBox(height: 24),
                    const Text(
                      'Dados da habilitação',
                      style: TextStyle(
                        fontSize: 18,
                        fontWeight: FontWeight.w800,
                      ),
                    ),
                    const SizedBox(height: 12),
                    if (numeroCnh.isNotEmpty)
                      _info(LucideIcons.creditCard, 'Número da CNH', numeroCnh),
                    if (categoriaCnh.isNotEmpty)
                      _info(LucideIcons.layoutGrid, 'Categoria', categoriaCnh),
                    if (validadeCnh.isNotEmpty)
                      _info(LucideIcons.calendarDays, 'Validade', validadeCnh),
                    if (validadeCrlv.isNotEmpty)
                      _info(
                        LucideIcons.calendarDays,
                        'Validade do CRLV',
                        validadeCrlv,
                      ),
                    if (numeroCnh.isEmpty &&
                        categoriaCnh.isEmpty &&
                        validadeCnh.isEmpty &&
                        validadeCrlv.isEmpty)
                      const Text(
                        'Dados da habilitação ainda não disponíveis na API.',
                      ),
                    const SizedBox(height: 20),
                    ElevatedButton.icon(
                      onPressed: _enviando ? null : _escolherDocumento,
                      icon: _enviando
                          ? const SizedBox(
                              width: 18,
                              height: 18,
                              child: CircularProgressIndicator(strokeWidth: 2),
                            )
                          : const Icon(LucideIcons.fileUp),
                      label: Text(
                        _enviando ? 'Enviando...' : 'Atualizar documentos',
                      ),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: primary,
                        foregroundColor: Colors.white,
                        padding: const EdgeInsets.symmetric(vertical: 15),
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _documento(
    String tipo,
    IconData icon,
    String titulo,
    String subtitulo,
    String detalhe,
    String status,
    VoidCallback tap,
  ) {
    final normalizado = status.toLowerCase();
    final revisar = normalizado == 'review_required';
    final aprovado = {
      'approved',
      'aprovado',
      'valid',
      'válido',
    }.contains(normalizado);
    final pendente = {
      'pending',
      'pendente',
      'aguardando_sync',
      'review_required',
    }.contains(normalizado);
    final rejeitado = {
      'rejected',
      'recusado',
      'expired',
      'vencido',
      'expirado',
    }.contains(normalizado);
    final cor = revisar
        ? Colors.red
        : aprovado
        ? Colors.green
        : pendente
        ? Colors.orange
        : rejeitado
        ? Colors.red
        : Colors.grey;
    final statusIcone = revisar
        ? LucideIcons.circleAlert
        : aprovado
        ? LucideIcons.circleCheckBig
        : pendente
        ? LucideIcons.hourglass
        : rejeitado
        ? LucideIcons.circleAlert
        : LucideIcons.circleHelp;
    return Card(
      child: ListTile(
        onTap: tap,
        leading: Icon(icon, color: primary),
        title: Text(
          titulo,
          style: const TextStyle(fontWeight: FontWeight.w800),
        ),
        subtitle: Text('$subtitulo\n$detalhe'),
        isThreeLine: true,
        trailing:
            _acoesOffline.any((acao) => acao.tipo == _tipoAcaoDocumento(tipo))
            ? IconButton(
                tooltip: 'Tentar sincronizar $tipo novamente',
                onPressed: () => _tentarDocumento(tipo),
                icon: Icon(statusIcone, color: cor),
              )
            : Icon(statusIcone, color: cor),
      ),
    );
  }

  Widget _cartaoPendencias() {
    final sincronizando = SyncEngine.instance.estado.value.sincronizando;
    return Card(
      child: Padding(
        padding: const EdgeInsets.fromLTRB(16, 14, 8, 8),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Arquivos aguardando envio',
              style: TextStyle(fontWeight: FontWeight.w800),
            ),
            const SizedBox(height: 4),
            const Text('Os arquivos ficam no armazenamento privado do app.'),
            for (final acao in _acoesOffline)
              ListTile(
                contentPadding: EdgeInsets.zero,
                leading: Icon(
                  acao.requerIntervencao
                      ? LucideIcons.circleAlert
                      : sincronizando &&
                            SyncEngine.instance.estado.value.acaoAtualId ==
                                acao.id
                      ? LucideIcons.loaderCircle
                      : LucideIcons.clock3,
                  color: acao.requerIntervencao ? Colors.deepOrange : primary,
                ),
                title: Text(
                  acao.tipo == TipoAcao.documentoCnh ? 'CNH' : 'CRLV',
                ),
                subtitle: Text(
                  '${_formatarTamanho(_tamanhosPendentes[acao.id])} • '
                  '${acao.requerIntervencao
                      ? 'Requer revisão'
                      : sincronizando
                      ? 'Sincronizando ou na fila'
                      : 'Pendente de sincronização'}'
                  '${acao.ultimoErro == null ? '' : '\n${acao.ultimoErro}'}',
                ),
                isThreeLine: acao.ultimoErro != null,
                trailing: IconButton(
                  tooltip:
                      'Remover ${acao.tipo == TipoAcao.documentoCnh ? 'CNH' : 'CRLV'} pendente',
                  onPressed: sincronizando || _removendoId != null
                      ? null
                      : () => _removerDocumentoPendente(acao),
                  icon: _removendoId == acao.id
                      ? const SizedBox.square(
                          dimension: 20,
                          child: CircularProgressIndicator(strokeWidth: 2),
                        )
                      : const Icon(LucideIcons.trash2),
                ),
              ),
          ],
        ),
      ),
    );
  }

  Widget _info(IconData icon, String titulo, String valor) => Card(
    child: ListTile(
      leading: Icon(icon, color: primary),
      title: Text(titulo),
      subtitle: Text(
        valor,
        style: const TextStyle(fontWeight: FontWeight.w700),
      ),
    ),
  );
}
