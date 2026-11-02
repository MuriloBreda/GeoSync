import 'dart:convert';
import 'dart:io';

import 'package:flutter/material.dart';
import 'package:lucide_icons_flutter/lucide_icons.dart';
import 'package:latlong2/latlong.dart' as latlong2;
import 'package:image_picker/image_picker.dart';
import 'package:mobile/services/api_exception.dart';
import 'package:mobile/services/api_service.dart';
import 'package:mobile/services/eta_service.dart';
import 'package:mobile/app_session.dart';
import 'package:mobile/sync/location_point.dart';
import 'package:mobile/sync/local_store.dart';
import 'package:mobile/sync/pending_queue.dart';
import 'package:mobile/sync/sync_engine.dart';
import 'package:mobile/widgets/signature_pad.dart';
import 'package:mobile/widgets/data_state_widgets.dart';
import 'package:mobile/suporte_page.dart';
import 'package:url_launcher/url_launcher.dart';

import 'package:mobile/motorista/avisos_motorista_page.dart';
import 'package:mobile/motorista/mapa_motorista_page.dart';
import 'package:mobile/motorista/motorista_dashboard.dart';
import 'package:mobile/motorista/qr_page.dart';

class RemessasPage extends StatefulWidget {
  const RemessasPage({super.key, this.mostrarDisponiveis = false});

  final bool mostrarDisponiveis;

  @override
  State<RemessasPage> createState() => _RemessasPageState();
}

class _RemessasPageState extends State<RemessasPage> {
  final TextEditingController _searchController = TextEditingController();

  String filtroSelecionado = "Todas";
  final int _currentIndex = 1;

  // ============================================================
  // CORES
  // ============================================================

  static const Color azul = Color(0xFF0C46FF);
  static const Color azulEscuro = Color(0xFF0B2A4A);
  static const Color textoSecundario = Color(0xFF718096);

  // Cores que acompanham o tema claro/escuro.
  Color get corTexto => Theme.of(context).colorScheme.onSurface;
  Color get corBorda => Theme.of(context).colorScheme.outlineVariant;
  Color get corCard => Theme.of(context).colorScheme.surface;

  String _normalizarStatus(Object? valor) => '$valor'
      .trim()
      .toLowerCase()
      .replaceAll('á', 'a')
      .replaceAll('ã', 'a')
      .replaceAll('â', 'a')
      .replaceAll('é', 'e')
      .replaceAll('ê', 'e')
      .replaceAll('í', 'i')
      .replaceAll('ó', 'o')
      .replaceAll('ô', 'o')
      .replaceAll('õ', 'o')
      .replaceAll('ú', 'u')
      .replaceAll('ç', 'c')
      .replaceAll('_', ' ')
      .replaceAll('-', ' ');

  bool _statusTransito(Object? status) => {
    'em rota',
    'em transito',
    'em deslocamento',
    'saiu para entrega',
    'in transit',
    'in progress',
    'out for delivery',
  }.contains(_normalizarStatus(status));

  bool _statusPendente(Object? status) => {
    'aguardando coleta',
    'aguardando retirada',
    'pending',
    'pending pickup',
    'assigned',
    'pendente',
    'pendentes',
  }.contains(_normalizarStatus(status));

  bool _statusEntregue(Object? status) => {
    'entregue',
    'delivered',
    'concluida',
    'completed',
  }.contains(_normalizarStatus(status));

  bool _statusOcorrencia(Object? status) => {
    'alerta',
    'atrasado',
    'atrasada',
    'problema',
    'ocorrencia',
    'com ocorrencia',
    'incident',
    'issue',
  }.contains(_normalizarStatus(status));

  bool _correspondeFiltro(Remessa remessa, String filtro) {
    switch (_normalizarStatus(filtro)) {
      case 'transito':
      case 'em transito':
        return _statusTransito(remessa.status);
      case 'pendente':
      case 'pendentes':
        return _statusPendente(remessa.status);
      case 'entregue':
        return _statusEntregue(remessa.status);
      case 'alerta':
      case 'ocorrencia':
        return _statusOcorrencia(remessa.status) || remessa.comOcorrencia;
      default:
        return true;
    }
  }

  // ============================================================
  // DADOS
  // ============================================================

  final List<Remessa> remessas = [];
  final List<Remessa> disponiveis = [];
  bool _modoDisponiveis = false;
  bool _carregando = true;
  String? _erroRemessas;
  String? _erroDisponiveis;
  bool _apiDisponivel = false;
  bool _dadosDesatualizados = false;
  String? get _erroAtual => _modoDisponiveis ? _erroDisponiveis : _erroRemessas;
  List<Remessa> get _listaAtual => _modoDisponiveis ? disponiveis : remessas;

  // ============================================================
  // FILTRO
  // ============================================================

  List<Remessa> get remessasFiltradas {
    final pesquisa = _searchController.text.toLowerCase().trim();

    final fonte = _modoDisponiveis ? disponiveis : remessas;
    final resultado =
        fonte.where((remessa) {
          final correspondeFiltro = _correspondeFiltro(
            remessa,
            filtroSelecionado,
          );

          final correspondeBusca =
              pesquisa.isEmpty ||
              remessa.codigo.toLowerCase().contains(pesquisa) ||
              remessa.origem.toLowerCase().contains(pesquisa) ||
              remessa.destino.toLowerCase().contains(pesquisa) ||
              remessa.tipo.toLowerCase().contains(pesquisa);

          return correspondeFiltro && correspondeBusca;
        }).toList()..sort((a, b) {
          final aUrgencia = _scorePrioridade(a);
          final bUrgencia = _scorePrioridade(b);
          if (aUrgencia != bUrgencia) return aUrgencia.compareTo(bUrgencia);
          final aPrazo = a.prazoEntrega;
          final bPrazo = b.prazoEntrega;
          if (aPrazo == null) return bPrazo == null ? 0 : 1;
          if (bPrazo == null) return -1;
          return aPrazo.compareTo(bPrazo);
        });
    return resultado;
  }

  int _scorePrioridade(Remessa remessa) {
    if (_statusOcorrencia(remessa.status) || remessa.comOcorrencia) return 0;
    if (remessa.prazoEntrega?.isBefore(DateTime.now()) ?? false) return 1;
    final prioridade = _normalizarStatus(remessa.prioridade);
    if (prioridade.contains('urgente') || prioridade.contains('critica')) {
      return 2;
    }
    if (prioridade.contains('alta') || prioridade.contains('high')) return 3;
    if (_statusTransito(remessa.status)) return 4;
    if (prioridade.contains('media') || prioridade.contains('medium')) return 5;
    return 6;
  }

  // ============================================================
  // INIT
  // ============================================================

  @override
  void initState() {
    super.initState();
    _modoDisponiveis = widget.mostrarDisponiveis;
    if (widget.mostrarDisponiveis) filtroSelecionado = 'Disponíveis';

    _searchController.addListener(() {
      setState(() {});
    });
    _carregarRemessas(forceRefresh: true);
  }

  Future<void> _carregarRemessas({bool forceRefresh = true}) async {
    if (mounted) {
      setState(() => _carregando = remessas.isEmpty && disponiveis.isEmpty);
    }
    List<Remessa>? dados;
    List<Remessa>? vagas;
    String? erroRemessas;
    String? erroDisponiveis;

    try {
      dados = (await ApiService.instance.minhasRemessas(
        forceRefresh: forceRefresh,
      )).whereType<Map>().map(_remessaFromApi).toList();
    } on ApiException catch (error) {
      erroRemessas = error.message;
    } catch (_) {
      erroRemessas = 'N\u00e3o foi poss\u00edvel carregar suas remessas.';
    }

    try {
      vagas = (await ApiService.instance.remessasDisponiveis())
          .whereType<Map>()
          .map((item) => _remessaFromApi(item, disponivel: true))
          .toList();
    } on ApiException catch (error) {
      erroDisponiveis = error.message;
    } catch (_) {
      erroDisponiveis =
          'N\u00e3o foi poss\u00edvel carregar entregas dispon\u00edveis.';
    }

    if (!mounted) return;
    setState(() {
      if (dados != null) {
        remessas
          ..clear()
          ..addAll(dados);
      }
      if (vagas != null) {
        disponiveis
          ..clear()
          ..addAll(vagas);
      }
      _erroRemessas = erroRemessas;
      _erroDisponiveis = erroDisponiveis;
      _apiDisponivel = dados != null || vagas != null;
      _dadosDesatualizados =
          SyncEngine.instance.estado.value.erro != null ||
          (_erroAtual != null && _listaAtual.isNotEmpty);
      _carregando = false;
    });
  }

  Remessa _remessaFromApi(Map value, {bool disponivel = false}) {
    Object? campo(List<String> chaves) {
      for (final chave in chaves) {
        final valor = value[chave];
        if (valor == null) continue;
        if (valor is Map) {
          final aninhado =
              valor['nome'] ??
              valor['name'] ??
              valor['label'] ??
              valor['endereco'] ??
              valor['address'] ??
              valor['cidade'] ??
              valor['city'] ??
              valor['status'];
          if (aninhado != null) return aninhado;
        } else {
          return valor;
        }
      }
      return null;
    }

    final rawProgress = campo(['progresso', 'progress', 'percentual']) ?? 0;
    final progress = rawProgress is num
        ? rawProgress.toDouble()
        : double.tryParse(
                '$rawProgress'.replaceAll('%', '').replaceAll(',', '.'),
              ) ??
              0;
    final normalizedProgress = progress > 1 ? progress / 100 : progress;
    return Remessa(
      codigo: '${campo(['codigo', 'code', 'tracking_code', 'id']) ?? '-'}',
      status:
          '${campo(['status', 'situacao', 'status_name']) ?? 'Status não informado'}',
      origem:
          '${campo(['origem', 'origin', 'remetente_endereco', 'pickup_address']) ?? '-'}',
      destino:
          '${campo(['destino', 'destination', 'destinatario_endereco', 'delivery_address']) ?? '-'}',
      tipo: '${campo(['tipo', 'tipo_carga', 'cargo_type', 'cargo']) ?? '-'}',
      peso: '${campo(['peso', 'weight']) ?? '-'}',
      eta:
          '${campo(['eta', 'previsao_entrega', 'estimated_delivery', 'data_prevista_entrega', 'delivery_date']) ?? '-'}',
      prioridade:
          '${campo(['prioridade', 'priority', 'nivel_prioridade']) ?? 'Normal'}',
      prazoEntrega: _parsePrazo(
        campo([
          'prazo_entrega',
          'previsao_entrega',
          'data_prevista_entrega',
          'eta',
          'estimated_delivery',
          'delivery_date',
        ]),
      ),
      progresso: normalizedProgress.clamp(0.0, 1.0).toDouble(),
      destinoLatitude: _parseCoordenada(
        campo([
          'destino_latitude',
          'delivery_latitude',
          'latitude_destino',
          'latitude',
          'lat',
        ]),
      ),
      destinoLongitude: _parseCoordenada(
        campo([
          'destino_longitude',
          'delivery_longitude',
          'longitude_destino',
          'longitude',
          'lng',
          'lon',
        ]),
      ),
      id: campo([
        'id',
        'remessa_id',
        'shipment_id',
        'uuid',
        'codigo',
        'code',
        'tracking_code',
      ]),
      comOcorrencia:
          value['com_ocorrencia'] == true ||
          value['tem_ocorrencia'] == true ||
          value['has_occurrence'] == true ||
          value['has_incident'] == true ||
          _statusOcorrencia(campo(['status', 'situacao', 'status_name'])),
      comprovanteEnviado:
          value['comprovante_enviado'] == true ||
              value['proof_sent'] == true ||
              value['comprovante_status'] == 'enviado' ||
              (value['comprovante'] is Map &&
                  (value['comprovante']['enviado'] == true ||
                      value['comprovante']['status'] == 'enviado'))
          ? true
          : value.containsKey('comprovante_enviado') ||
                value.containsKey('proof_sent') ||
                value.containsKey('comprovante_status') ||
                value.containsKey('comprovante')
          ? false
          : null,
      disponivel: disponivel,
    );
  }

  double? _parseCoordenada(Object? value) {
    final numero = value is num
        ? value.toDouble()
        : double.tryParse('${value ?? ''}');
    return numero != null && numero.isFinite ? numero : null;
  }

  DateTime? _parsePrazo(Object? value) {
    if (value == null) return null;
    final texto = '$value'.trim();
    final iso = DateTime.tryParse(texto);
    if (iso != null) return iso;
    final partes = texto.split(RegExp(r'[/.-]'));
    if (partes.length < 3) return null;
    final dia = int.tryParse(partes[0]);
    final mes = int.tryParse(partes[1]);
    final ano = int.tryParse(partes[2]);
    if (dia == null || mes == null || ano == null || ano < 1000) return null;
    return DateTime(ano, mes, dia);
  }

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  // ============================================================
  // QUANTIDADE
  // ============================================================

  int quantidadePorStatus(String status) {
    final fonte = _modoDisponiveis ? disponiveis : remessas;
    if (status == "Todas") {
      return fonte.length;
    }

    return fonte.where((r) => _correspondeFiltro(r, status)).length;
  }

  // ============================================================
  // BUSCA
  // ============================================================

  void limparBusca() {
    _searchController.clear();
    FocusScope.of(context).unfocus();
  }

  // ============================================================
  // DETALHES
  // ============================================================

  Future<void> abrirDetalhes(Remessa remessa) async {
    final novoStatus = await showModalBottomSheet<String>(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (_) {
        return DetalhesRemessa(remessa: remessa);
      },
    );
    if (!mounted || novoStatus == null) return;
    if (novoStatus == 'accepted') {
      await _carregarRemessas(forceRefresh: true);
      return;
    }
    setState(() {
      remessa.status = novoStatus;
      remessa.progresso = novoStatus == 'Entregue' ? 1 : remessa.progresso;
    });
  }

  // ============================================================
  // BUILD
  // ============================================================

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      // Cabeçalho e lista rolam juntos: em telas baixas (ou com fonte
      // ampliada) o cabeçalho não "empurra" a lista para fora da tela.
      body: SafeArea(
        child: CustomScrollView(
          physics: const BouncingScrollPhysics(
            parent: AlwaysScrollableScrollPhysics(),
          ),
          slivers: [
            SliverToBoxAdapter(child: _buildHeader()),
            if (_carregando && _listaAtual.isEmpty && _erroAtual == null)
              const SliverFillRemaining(
                hasScrollBody: false,
                child: Center(child: CircularProgressIndicator()),
              )
            else if (_erroAtual != null && _listaAtual.isEmpty)
              SliverFillRemaining(hasScrollBody: false, child: _buildErro())
            else
              ..._buildConteudo(),
          ],
        ),
      ),
      bottomNavigationBar: _buildBottomNavigation(),
    );
  }

  Widget _buildErro() => Center(
    child: DataStatePanel(
      kind: DataStateKind.error,
      title: 'Não foi possível carregar as entregas',
      message: _erroAtual ?? 'Confira sua conexão e tente novamente.',
      onRetry: () => _carregarRemessas(forceRefresh: true),
    ),
  );

  // ============================================================
  // HEADER
  // ============================================================

  Widget _buildHeader() {
    final statusApiCor = _carregando
        ? const Color(0xFFF59E0B)
        : _dadosDesatualizados
        ? const Color(0xFFB7791F)
        : _apiDisponivel
        ? const Color(0xFF15803D)
        : const Color(0xFFDC2626);
    return Padding(
      padding: const EdgeInsets.fromLTRB(18, 14, 18, 0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              _buildLogo(),
              const SizedBox(width: 12),

              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      "GeoSync",
                      style: TextStyle(
                        color: corTexto,
                        fontSize: 18,
                        fontWeight: FontWeight.w800,
                        letterSpacing: -0.3,
                      ),
                    ),
                    SizedBox(height: 2),
                    Text(
                      "Gestão de entregas",
                      style: TextStyle(
                        color: textoSecundario,
                        fontSize: 11,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                  ],
                ),
              ),

              IconButton(
                tooltip: 'Atualizar entregas',
                onPressed: _carregando
                    ? null
                    : () => _carregarRemessas(forceRefresh: true),
                icon: const Icon(LucideIcons.refreshCw),
              ),

              const SizedBox(width: 4),

              _buildNotificationButton(),

              const SizedBox(width: 9),

              _buildProfileButton(),
            ],
          ),

          const SizedBox(height: 24),

          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    "Minhas entregas",
                    style: TextStyle(
                      color: corTexto,
                      fontSize: 27,
                      fontWeight: FontWeight.w800,
                      letterSpacing: -0.9,
                    ),
                  ),
                  SizedBox(height: 5),
                  Text(
                    "Acompanhe suas cargas em tempo real.",
                    style: TextStyle(color: textoSecundario, fontSize: 12),
                  ),
                ],
              ),

              const SizedBox(height: 8),

              Container(
                padding: const EdgeInsets.symmetric(
                  horizontal: 10,
                  vertical: 7,
                ),
                decoration: BoxDecoration(
                  color: statusApiCor.withValues(alpha: 0.10),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Row(
                  children: [
                    Icon(Icons.circle, size: 7, color: statusApiCor),
                    const SizedBox(width: 6),
                    Flexible(
                      child: Text(
                        _carregando
                            ? 'Conectando...'
                            : _dadosDesatualizados
                            ? 'Dados desatualizados'
                            : _apiDisponivel
                            ? 'Dados carregados'
                            : 'Sem conexão',
                        style: TextStyle(
                          color: statusApiCor,
                          fontSize: 10,
                          fontWeight: FontWeight.w700,
                        ),
                        maxLines: 1,
                        overflow: TextOverflow.ellipsis,
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),

          const SizedBox(height: 18),

          _buildSearch(),

          const SizedBox(height: 16),

          _buildResumoRapido(),
          const SizedBox(height: 12),
          SizedBox(
            width: double.infinity,
            height: 48,
            child: OutlinedButton.icon(
              onPressed: () => Navigator.of(
                context,
              ).push(MaterialPageRoute(builder: (_) => const QrRemessaPage())),
              icon: const Icon(LucideIcons.qrCode),
              label: const Text('Escanear QR ou abrir código da remessa'),
            ),
          ),
        ],
      ),
    );
  }

  // ============================================================
  // LOGO
  // ============================================================

  Widget _buildLogo() {
    return Container(
      width: 46,
      height: 46,
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          colors: [azulEscuro, azul],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
        borderRadius: BorderRadius.circular(15),
        boxShadow: [
          BoxShadow(
            color: azul.withValues(alpha: 0.20),
            blurRadius: 14,
            offset: const Offset(0, 5),
          ),
        ],
      ),
      child: const Icon(LucideIcons.truck, color: Colors.white, size: 23),
    );
  }

  // ============================================================
  // NOTIFICAÇÃO
  // ============================================================

  Widget _buildNotificationButton() {
    return GestureDetector(
      onTap: () {
        Navigator.of(
          context,
        ).push(MaterialPageRoute(builder: (_) => const AvisosMotoristaPage()));
      },
      child: Container(
        width: 46,
        height: 46,
        decoration: BoxDecoration(
          color: Theme.of(context).colorScheme.surface,
          borderRadius: BorderRadius.circular(15),
          border: Border.all(color: corBorda),
        ),
        child: Stack(
          children: [
            const Center(
              child: Icon(LucideIcons.bell, color: Color(0xFF475569), size: 23),
            ),
            Positioned(
              top: 8,
              right: 8,
              child: Container(
                width: 8,
                height: 8,
                decoration: BoxDecoration(
                  color: Colors.redAccent,
                  shape: BoxShape.circle,
                  border: Border.all(color: Colors.white, width: 1.5),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  // ============================================================
  // PERFIL
  // ============================================================

  Widget _buildProfileButton() {
    return GestureDetector(
      onTap: () => _abrirDashboard(2),
      child: Container(
        width: 46,
        height: 46,
        decoration: BoxDecoration(
          color: const Color(0xFFE8EEFF),
          borderRadius: BorderRadius.circular(15),
        ),
        child: Center(
          child: Text(
            AppSession.inicialNome,
            style: const TextStyle(
              color: azul,
              fontSize: 18,
              fontWeight: FontWeight.w800,
            ),
          ),
        ),
      ),
    );
  }

  // ============================================================
  // BUSCA
  // ============================================================

  Widget _buildSearch() {
    return Container(
      height: 52,
      decoration: BoxDecoration(
        color: Theme.of(context).colorScheme.surface,
        borderRadius: BorderRadius.circular(17),
        border: Border.all(color: corBorda),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.025),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: TextField(
        controller: _searchController,
        textInputAction: TextInputAction.search,
        style: TextStyle(
          color: corTexto,
          fontSize: 13,
          fontWeight: FontWeight.w500,
        ),
        decoration: InputDecoration(
          hintText: "Buscar por código, origem ou destino",
          hintStyle: const TextStyle(color: textoSecundario, fontSize: 12),
          prefixIcon: Container(
            margin: const EdgeInsets.all(8),
            decoration: BoxDecoration(
              color: azul.withValues(alpha: 0.08),
              borderRadius: BorderRadius.circular(11),
            ),
            child: const Icon(LucideIcons.search, color: azul, size: 20),
          ),
          suffixIcon: _searchController.text.isNotEmpty
              ? IconButton(
                  onPressed: limparBusca,
                  icon: const Icon(
                    LucideIcons.x,
                    size: 19,
                    color: textoSecundario,
                  ),
                )
              : null,
          border: InputBorder.none,
          contentPadding: const EdgeInsets.symmetric(vertical: 15),
        ),
      ),
    );
  }

  // ============================================================
  // RESUMO RÁPIDO
  // ============================================================

  Widget _buildResumoRapido() {
    final emRota = remessas.where((r) => _statusTransito(r.status)).length;
    final aguardando = remessas.where((r) {
      return {
        'aguardando coleta',
        'aguardando retirada',
        'pending',
        'pending pickup',
        'assigned',
      }.contains(_normalizarStatus(r.status));
    }).length;
    final entregues = remessas.where((r) => _statusEntregue(r.status)).length;
    final indisponivel =
        _carregando || (_erroAtual != null && remessas.isEmpty);

    return Row(
      children: [
        Expanded(
          child: _miniIndicador(
            valor: indisponivel ? '—' : '$emRota',
            titulo: "Em rota",
            icon: LucideIcons.navigation,
            cor: azul,
          ),
        ),
        const SizedBox(width: 9),
        Expanded(
          child: _miniIndicador(
            valor: indisponivel ? '—' : '$aguardando',
            titulo: "Aguardando",
            icon: LucideIcons.clock,
            cor: const Color(0xFFF59E0B),
          ),
        ),
        const SizedBox(width: 9),
        Expanded(
          child: _miniIndicador(
            valor: indisponivel ? '—' : '$entregues',
            titulo: "Entregues",
            icon: LucideIcons.circleCheckBig,
            cor: const Color(0xFF16A34A),
          ),
        ),
      ],
    );
  }

  Widget _miniIndicador({
    required String valor,
    required String titulo,
    required IconData icon,
    required Color cor,
  }) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 11, vertical: 11),
      decoration: BoxDecoration(
        color: corCard,
        borderRadius: BorderRadius.circular(15),
        border: Border.all(color: corBorda),
      ),
      child: Row(
        children: [
          Container(
            width: 32,
            height: 32,
            decoration: BoxDecoration(
              color: cor.withValues(alpha: 0.09),
              borderRadius: BorderRadius.circular(10),
            ),
            child: Icon(icon, color: cor, size: 17),
          ),
          const SizedBox(width: 8),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  valor,
                  style: TextStyle(
                    color: corTexto,
                    fontSize: 16,
                    fontWeight: FontWeight.w800,
                  ),
                ),
                Text(
                  titulo,
                  overflow: TextOverflow.ellipsis,
                  style: const TextStyle(
                    color: textoSecundario,
                    fontSize: 9,
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  // ============================================================
  // CONTEÚDO
  // ============================================================

  List<Widget> _buildConteudo() {
    return [
      if (_dadosDesatualizados || _erroAtual != null)
        SliverToBoxAdapter(
          child: Padding(
            padding: const EdgeInsets.fromLTRB(18, 12, 18, 0),
            child: DataFreshnessBanner(
              message: _erroAtual != null
                  ? 'Falha na atualização. Mostrando os últimos dados disponíveis.'
                  : 'A lista usa o cache local e pode estar desatualizada.',
              onRetry: _carregando
                  ? null
                  : () => _carregarRemessas(forceRefresh: true),
            ),
          ),
        ),
      SliverToBoxAdapter(
        child: Column(
          children: [
            const SizedBox(height: 18),

            _buildFiltros(),

            const SizedBox(height: 15),

            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 20),
              child: Row(
                children: [
                  Text(
                    "${remessasFiltradas.length} entregas",
                    style: TextStyle(
                      color: corTexto,
                      fontSize: 13,
                      fontWeight: FontWeight.w800,
                    ),
                  ),
                  const Spacer(),
                  if (filtroSelecionado != "Todas")
                    GestureDetector(
                      onTap: () {
                        setState(() {
                          filtroSelecionado = "Todas";
                        });
                      },
                      child: const Text(
                        "Limpar filtro",
                        style: TextStyle(
                          color: azul,
                          fontSize: 11,
                          fontWeight: FontWeight.w700,
                        ),
                      ),
                    ),
                ],
              ),
            ),

            const SizedBox(height: 10),
          ],
        ),
      ),
      if (remessasFiltradas.isEmpty)
        const SliverFillRemaining(hasScrollBody: false, child: _EstadoVazio())
      else
        SliverPadding(
          padding: const EdgeInsets.fromLTRB(20, 0, 20, 20),
          sliver: SliverList.builder(
            itemCount: remessasFiltradas.length,
            itemBuilder: (context, index) {
              final remessa = remessasFiltradas[index];
              return Padding(
                padding: const EdgeInsets.only(bottom: 13),
                child: _RemessaCard(
                  remessa: remessa,
                  onTap: () => abrirDetalhes(remessa),
                ),
              );
            },
          ),
        ),
    ];
  }

  // ============================================================
  // FILTROS
  // ============================================================

  Widget _buildFiltros() {
    return SizedBox(
      height: 48,
      child: ListView(
        scrollDirection: Axis.horizontal,
        physics: const BouncingScrollPhysics(),
        padding: const EdgeInsets.symmetric(horizontal: 20),
        children: [
          _filtro(
            texto: "Disponíveis",
            filtro: "Disponíveis",
            quantidade: disponiveis.length,
          ),
          _filtro(
            texto: "Todas",
            filtro: "Todas",
            quantidade: quantidadePorStatus("Todas"),
          ),
          _filtro(
            texto: "Pendentes",
            filtro: "Pendentes",
            quantidade: quantidadePorStatus("Pendentes"),
          ),
          _filtro(
            texto: "Em rota",
            filtro: "Trânsito",
            quantidade: quantidadePorStatus("Trânsito"),
          ),
          _filtro(
            texto: "Entregues",
            filtro: "Entregue",
            quantidade: quantidadePorStatus("Entregue"),
          ),
          _filtro(
            texto: "Alertas",
            filtro: "Alerta",
            quantidade: quantidadePorStatus("Alerta"),
          ),
        ],
      ),
    );
  }

  Widget _filtro({
    required String texto,
    required String filtro,
    required int quantidade,
  }) {
    final selecionado = filtroSelecionado == filtro;

    return GestureDetector(
      onTap: () {
        setState(() {
          filtroSelecionado = filtro;
          _modoDisponiveis = filtro == 'Disponíveis';
        });
      },
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 250),
        curve: Curves.easeOut,
        margin: const EdgeInsets.only(right: 8),
        padding: const EdgeInsets.symmetric(horizontal: 14),
        decoration: BoxDecoration(
          color: selecionado ? azul : corCard,
          borderRadius: BorderRadius.circular(14),
          border: Border.all(color: selecionado ? azul : corBorda),
          boxShadow: selecionado
              ? [
                  BoxShadow(
                    color: azul.withValues(alpha: 0.16),
                    blurRadius: 10,
                    offset: const Offset(0, 4),
                  ),
                ]
              : null,
        ),
        child: Row(
          children: [
            Text(
              texto,
              style: TextStyle(
                color: selecionado ? Colors.white : textoSecundario,
                fontSize: 11,
                fontWeight: FontWeight.w700,
              ),
            ),
            const SizedBox(width: 7),
            Container(
              padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 3),
              decoration: BoxDecoration(
                color: selecionado
                    ? Colors.white.withValues(alpha: 0.18)
                    : const Color(0xFFF0F3F8),
                borderRadius: BorderRadius.circular(8),
              ),
              child: Text(
                "$quantidade",
                style: TextStyle(
                  color: selecionado ? Colors.white : textoSecundario,
                  fontSize: 9,
                  fontWeight: FontWeight.w800,
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  // ============================================================
  // BOTTOM NAVIGATION
  // ============================================================

  Widget _buildBottomNavigation() {
    return Container(
      decoration: BoxDecoration(
        color: corCard,
        boxShadow: [
          BoxShadow(
            color: Colors.black.withValues(alpha: 0.06),
            blurRadius: 20,
            offset: const Offset(0, -5),
          ),
        ],
      ),
      child: SafeArea(
        top: false,
        child: Padding(
          padding: const EdgeInsets.fromLTRB(10, 8, 10, 7),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceAround,
            children: [
              _navItem(icon: LucideIcons.house, texto: "Início", index: 0),
              _navItem(icon: LucideIcons.truck, texto: "Entregas", index: 1),
              _navItem(
                icon: LucideIcons.circleUserRound,
                texto: "Perfil",
                index: 2,
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _navItem({
    required IconData icon,
    required String texto,
    required int index,
  }) {
    final selecionado = _currentIndex == index;

    return GestureDetector(
      onTap: () {
        if (index == 0) {
          Navigator.of(context).pop();
        } else if (index == 2) {
          _abrirDashboard(2);
        }
      },
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 250),
        curve: Curves.easeOut,
        width: 78,
        padding: const EdgeInsets.symmetric(vertical: 7),
        decoration: BoxDecoration(
          color: selecionado
              ? azul.withValues(alpha: 0.09)
              : Colors.transparent,
          borderRadius: BorderRadius.circular(16),
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            AnimatedScale(
              scale: selecionado ? 1.08 : 1,
              duration: const Duration(milliseconds: 200),
              child: Icon(
                icon,
                size: 22,
                color: selecionado ? azul : const Color(0xFF94A3B8),
              ),
            ),
            const SizedBox(height: 4),
            Text(
              texto,
              style: TextStyle(
                color: selecionado ? azul : const Color(0xFF94A3B8),
                fontSize: 10,
                fontWeight: selecionado ? FontWeight.w700 : FontWeight.w500,
              ),
            ),
          ],
        ),
      ),
    );
  }

  // ============================================================
  // DASHBOARD
  // ============================================================

  void _abrirDashboard(int initialIndex) {
    Navigator.of(context).pushReplacement(
      MaterialPageRoute(
        builder: (_) => MotoristaDashboard(initialIndex: initialIndex),
      ),
    );
  }
}

// ============================================================================
// MODELO DA REMESSA
// ============================================================================

class Remessa {
  final String codigo;
  String status;
  final String origem;
  final String destino;
  final String tipo;
  final String peso;
  final String eta;
  final String distancia;
  final String prioridade;
  final DateTime? prazoEntrega;
  double progresso;
  final double? destinoLatitude;
  final double? destinoLongitude;
  final Object? id;
  final bool comOcorrencia;
  bool? comprovanteEnviado;

  bool favorita;
  final bool disponivel;

  Remessa({
    required this.codigo,
    required this.status,
    required this.origem,
    required this.destino,
    required this.tipo,
    required this.peso,
    required this.eta,
    required this.progresso,
    this.destinoLatitude,
    this.destinoLongitude,
    this.distancia = 'Não informado',
    this.id,
    this.prioridade = 'Normal',
    this.prazoEntrega,
    this.comOcorrencia = false,
    this.comprovanteEnviado,
    this.disponivel = false,
    this.favorita = false,
  });
}

class _EntregaProofData {
  const _EntregaProofData({
    required this.destinatario,
    required this.observacao,
    required this.fotoBase64,
    required this.assinaturaBase64,
  });

  final String destinatario;
  final String observacao;
  final String? fotoBase64;
  final String assinaturaBase64;
}

class _ComprovanteEntregaDialog extends StatefulWidget {
  const _ComprovanteEntregaDialog({required this.remessa});

  final Remessa remessa;

  @override
  State<_ComprovanteEntregaDialog> createState() =>
      _ComprovanteEntregaDialogState();
}

class _ComprovanteEntregaDialogState extends State<_ComprovanteEntregaDialog> {
  final TextEditingController _destinatarioController = TextEditingController();
  final TextEditingController _observacaoController = TextEditingController();
  final SignaturePadController _signatureController = SignaturePadController();
  final ImagePicker _picker = ImagePicker();
  String? _fotoBase64;
  bool _carregandoFoto = false;
  bool _qrValidado = false;

  Future<void> _validarQrDaRemessa() async {
    final lido = await Navigator.of(
      context,
    ).push<String>(MaterialPageRoute(builder: (_) => const QrScannerPage()));
    if (!mounted || lido == null) return;
    final esperado = '${widget.remessa.id ?? widget.remessa.codigo}';
    setState(() => _qrValidado = lido == esperado);
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(
          _qrValidado
              ? 'QR desta remessa validado.'
              : 'O QR lido pertence a outra remessa.',
        ),
      ),
    );
  }

  Future<void> _tirarFoto() async {
    setState(() => _carregandoFoto = true);
    try {
      final file = await _picker.pickImage(
        source: ImageSource.camera,
        preferredCameraDevice: CameraDevice.rear,
        maxWidth: 1600,
        imageQuality: 80,
      );
      if (file == null) return;
      final bytes = await File(file.path).readAsBytes();
      if (!mounted) return;
      setState(() => _fotoBase64 = base64Encode(bytes));
    } catch (_) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text(
            'Não foi possível abrir a câmera. Confira a permissão do app; a foto é opcional e você pode tentar novamente.',
          ),
        ),
      );
    } finally {
      if (mounted) setState(() => _carregandoFoto = false);
    }
  }

  void _confirmar() async {
    final destinatario = _destinatarioController.text.trim();
    final assinaturaBytes = await _signatureController.toPng();
    if (destinatario.isEmpty) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Informe o nome do destinatário.')),
      );
      return;
    }
    if (assinaturaBytes == null || assinaturaBytes.isEmpty) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Assine para concluir o comprovante.')),
      );
      return;
    }

    final assinaturaBase64 = base64Encode(assinaturaBytes);
    if (!mounted) return;
    Navigator.pop(
      context,
      _EntregaProofData(
        destinatario: destinatario,
        observacao: _observacaoController.text.trim(),
        fotoBase64: _fotoBase64,
        assinaturaBase64: assinaturaBase64,
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return AlertDialog(
      title: const Text('Comprovante de entrega'),
      content: SizedBox(
        width: double.maxFinite,
        child: SingleChildScrollView(
          child: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              TextField(
                controller: _destinatarioController,
                decoration: const InputDecoration(
                  labelText: 'Nome do destinatário (obrigatório)',
                  hintText: 'Ex.: Maria da Silva',
                ),
              ),
              const SizedBox(height: 12),
              TextField(
                controller: _observacaoController,
                minLines: 2,
                maxLines: 3,
                decoration: const InputDecoration(
                  labelText: 'Observação (opcional)',
                  hintText: 'Ex.: Entregue com cuidado ao porteiro.',
                ),
              ),
              const SizedBox(height: 12),
              Row(
                children: [
                  Expanded(
                    child: FilledButton.icon(
                      onPressed: _tirarFoto,
                      icon: _carregandoFoto
                          ? const SizedBox(
                              width: 18,
                              height: 18,
                              child: CircularProgressIndicator(strokeWidth: 2),
                            )
                          : const Icon(LucideIcons.camera),
                      label: Text(
                        _carregandoFoto
                            ? 'Capturando...'
                            : _fotoBase64 == null
                            ? 'Foto (opcional)'
                            : 'Refazer foto',
                      ),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 8),
              OutlinedButton.icon(
                onPressed: _validarQrDaRemessa,
                icon: Icon(
                  _qrValidado ? LucideIcons.badgeCheck : LucideIcons.scanLine,
                ),
                label: Text(
                  _qrValidado
                      ? 'QR da remessa validado'
                      : 'Validar QR da remessa',
                ),
              ),
              const Text(
                'A validação do QR confirma a remessa; a assinatura continua necessária para registrar a entrega.',
                style: TextStyle(fontSize: 11),
              ),
              if (_fotoBase64 != null) ...[
                const SizedBox(height: 10),
                Container(
                  height: 110,
                  width: double.infinity,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(12),
                    border: Border.all(color: const Color(0xFFE2E8F0)),
                  ),
                  child: ClipRRect(
                    borderRadius: BorderRadius.circular(12),
                    child: Image.memory(
                      base64Decode(_fotoBase64!),
                      fit: BoxFit.cover,
                    ),
                  ),
                ),
              ],
              const SizedBox(height: 12),
              const Text(
                'Campos obrigatórios: nome do destinatário, assinatura e localização IoT. A foto é opcional.',
                style: TextStyle(fontSize: 12, height: 1.35),
              ),
              const SizedBox(height: 12),
              const Text(
                'Assinatura do destinatário (obrigatória)',
                style: TextStyle(fontSize: 12, fontWeight: FontWeight.w600),
              ),
              const SizedBox(height: 8),
              SignaturePad(controller: _signatureController),
              const SizedBox(height: 8),
              Align(
                alignment: Alignment.centerRight,
                child: TextButton.icon(
                  onPressed: () => _signatureController.clear(),
                  icon: const Icon(LucideIcons.trash2),
                  label: const Text('Limpar assinatura'),
                ),
              ),
            ],
          ),
        ),
      ),
      actions: [
        TextButton(
          onPressed: () => Navigator.pop(context),
          child: const Text('Cancelar'),
        ),
        FilledButton(
          onPressed: _confirmar,
          child: const Text('Salvar comprovante'),
        ),
      ],
    );
  }
}

// ============================================================================
// CARD DA REMESSA
// ============================================================================

String _normalizarStatusMotorista(Object? value) => '$value'
    .trim()
    .toLowerCase()
    .replaceAll('á', 'a')
    .replaceAll('ã', 'a')
    .replaceAll('ç', 'c')
    .replaceAll('_', ' ')
    .replaceAll('-', ' ');

bool _statusEntregueMotorista(Object? status) => {
  'entregue',
  'delivered',
  'completed',
  'concluida',
}.contains(_normalizarStatusMotorista(status));

bool _statusOcorrenciaMotorista(Object? status) => {
  'alerta',
  'atrasado',
  'atrasada',
  'problema',
  'ocorrencia',
  'com ocorrencia',
  'incident',
  'issue',
}.contains(_normalizarStatusMotorista(status));

bool _statusTransitoMotorista(Object? status) => {
  'em rota',
  'em transito',
  'em deslocamento',
  'saiu para entrega',
  'in transit',
  'in progress',
  'out for delivery',
}.contains(_normalizarStatusMotorista(status));

class _RemessaCard extends StatefulWidget {
  final Remessa remessa;
  final VoidCallback onTap;

  const _RemessaCard({required this.remessa, required this.onTap});

  @override
  State<_RemessaCard> createState() => _RemessaCardState();
}

class _RemessaCardState extends State<_RemessaCard> {
  Color get corStatus {
    final status = _normalizarStatusMotorista(widget.remessa.status);
    if (_statusEntregueMotorista(status)) return const Color(0xFF16A34A);
    if (_statusOcorrenciaMotorista(status) || widget.remessa.comOcorrencia) {
      return const Color(0xFFDC2626);
    }
    if (status.startsWith('aguardando') || status == 'pending') {
      return const Color(0xFFF59E0B);
    }
    return const Color(0xFF0C46FF);
  }

  IconData get iconeStatus {
    final status = _normalizarStatusMotorista(widget.remessa.status);
    if (_statusEntregueMotorista(status)) return LucideIcons.circleCheckBig;
    if (_statusOcorrenciaMotorista(status) || widget.remessa.comOcorrencia) {
      return LucideIcons.triangleAlert;
    }
    if (status.startsWith('aguardando') || status == 'pending') {
      return LucideIcons.clock;
    }
    return LucideIcons.navigation;
  }

  @override
  Widget build(BuildContext context) {
    final remessa = widget.remessa;
    final scheme = Theme.of(context).colorScheme;

    return Semantics(
      button: true,
      label: 'Entrega ${remessa.codigo}, ${remessa.status}',
      onTap: widget.onTap,
      child: GestureDetector(
        onTap: widget.onTap,
        child: AnimatedContainer(
          duration: const Duration(milliseconds: 200),
          padding: const EdgeInsets.all(16),
          decoration: BoxDecoration(
            color: scheme.surface,
            borderRadius: BorderRadius.circular(22),
            border: Border.all(color: const Color(0xFFE1E7F0)),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withValues(alpha: 0.025),
                blurRadius: 12,
                offset: const Offset(0, 4),
              ),
            ],
          ),
          child: Column(
            children: [
              Row(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // ÍCONE
                  Container(
                    width: 50,
                    height: 50,
                    decoration: BoxDecoration(
                      color: corStatus.withValues(alpha: 0.10),
                      borderRadius: BorderRadius.circular(15),
                    ),
                    child: Icon(iconeStatus, color: corStatus, size: 24),
                  ),

                  const SizedBox(width: 13),

                  // INFORMAÇÕES
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Row(
                          children: [
                            Flexible(
                              child: Text(
                                remessa.codigo,
                                maxLines: 1,
                                overflow: TextOverflow.ellipsis,
                                style: TextStyle(
                                  color: scheme.onSurface,
                                  fontSize: 14,
                                  fontWeight: FontWeight.w800,
                                ),
                              ),
                            ),
                            const SizedBox(width: 7),
                            Flexible(
                              child: Container(
                                padding: const EdgeInsets.symmetric(
                                  horizontal: 7,
                                  vertical: 3,
                                ),
                                decoration: BoxDecoration(
                                  color: corStatus.withValues(alpha: 0.09),
                                  borderRadius: BorderRadius.circular(7),
                                ),
                                child: Text(
                                  remessa.status,
                                  maxLines: 1,
                                  overflow: TextOverflow.ellipsis,
                                  style: TextStyle(
                                    color: corStatus,
                                    fontSize: 8,
                                    fontWeight: FontWeight.w800,
                                  ),
                                ),
                              ),
                            ),
                          ],
                        ),

                        const SizedBox(height: 6),

                        Text(
                          remessa.tipo,
                          style: TextStyle(
                            color: scheme.onSurfaceVariant,
                            fontSize: 10,
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                        const SizedBox(height: 7),
                        Wrap(
                          spacing: 6,
                          runSpacing: 4,
                          children: [
                            _chipFila(
                              'Prioridade ${remessa.prioridade}',
                              corStatus,
                            ),
                            _chipFila(
                              remessa.prazoEntrega == null
                                  ? 'Prazo não informado'
                                  : '${remessa.prazoEntrega!.isBefore(DateTime.now()) ? 'Atrasada • ' : 'Prazo • '}${remessa.prazoEntrega!.toLocal().day.toString().padLeft(2, '0')}/${remessa.prazoEntrega!.toLocal().month.toString().padLeft(2, '0')} ${remessa.prazoEntrega!.toLocal().hour.toString().padLeft(2, '0')}:${remessa.prazoEntrega!.toLocal().minute.toString().padLeft(2, '0')}',
                              remessa.prazoEntrega?.isBefore(DateTime.now()) ==
                                      true
                                  ? const Color(0xFFDC2626)
                                  : const Color(0xFF64748B),
                            ),
                          ],
                        ),
                      ],
                    ),
                  ),

                  const Icon(
                    LucideIcons.chevronRight,
                    color: Color(0xFFB1BBCB),
                    size: 14,
                  ),
                ],
              ),

              const SizedBox(height: 16),

              // ROTA
              Row(
                children: [
                  _pontoRota(
                    cor: const Color(0xFF2563EB),
                    icon: LucideIcons.circleDot,
                  ),

                  const SizedBox(width: 8),

                  Expanded(
                    child: Text(
                      remessa.origem,
                      overflow: TextOverflow.ellipsis,
                      style: TextStyle(
                        color: scheme.onSurfaceVariant,
                        fontSize: 10,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ),

                  const Padding(
                    padding: EdgeInsets.symmetric(horizontal: 5),
                    child: Icon(
                      LucideIcons.arrowRight,
                      size: 15,
                      color: Color(0xFFB0BAC9),
                    ),
                  ),

                  Expanded(
                    child: Text(
                      remessa.destino,
                      textAlign: TextAlign.right,
                      overflow: TextOverflow.ellipsis,
                      style: TextStyle(
                        color: scheme.onSurfaceVariant,
                        fontSize: 10,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ),

                  const SizedBox(width: 8),

                  _pontoRota(
                    cor: const Color(0xFFDC2626),
                    icon: LucideIcons.mapPin,
                  ),
                ],
              ),

              const SizedBox(height: 15),

              // PROGRESSO
              Column(
                children: [
                  Row(
                    children: [
                      const Text(
                        "Progresso da entrega",
                        style: TextStyle(
                          color: Color(0xFF94A3B8),
                          fontSize: 9,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                      const Spacer(),
                      Text(
                        "${(remessa.progresso * 100).round()}%",
                        style: TextStyle(
                          color: corStatus,
                          fontSize: 9,
                          fontWeight: FontWeight.w800,
                        ),
                      ),
                    ],
                  ),

                  const SizedBox(height: 7),

                  ClipRRect(
                    borderRadius: BorderRadius.circular(10),
                    child: LinearProgressIndicator(
                      value: remessa.progresso,
                      minHeight: 5,
                      backgroundColor: scheme.surfaceContainerHighest,
                      valueColor: AlwaysStoppedAnimation<Color>(corStatus),
                    ),
                  ),
                ],
              ),

              const SizedBox(height: 15),

              // INFORMAÇÕES INFERIORES
              Row(
                children: [
                  _infoItem(icon: LucideIcons.weight, texto: remessa.peso),
                  const SizedBox(width: 15),
                  _infoItem(icon: LucideIcons.clock, texto: remessa.eta),
                  const Spacer(),
                  if (_statusTransitoMotorista(remessa.status))
                    TextButton.icon(
                      onPressed: () {
                        Navigator.of(context).push(
                          MaterialPageRoute(
                            builder: (_) => const MapaMotoristaPage(),
                          ),
                        );
                      },
                      style: TextButton.styleFrom(
                        padding: const EdgeInsets.symmetric(
                          horizontal: 8,
                          vertical: 4,
                        ),
                      ),
                      icon: const Icon(LucideIcons.map, size: 15),
                      label: const Text(
                        "Mapa",
                        style: TextStyle(
                          fontSize: 10,
                          fontWeight: FontWeight.w700,
                        ),
                      ),
                    ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _chipFila(String texto, Color cor) => Container(
    padding: const EdgeInsets.symmetric(horizontal: 7, vertical: 3),
    decoration: BoxDecoration(
      color: cor.withValues(alpha: 0.08),
      borderRadius: BorderRadius.circular(8),
    ),
    child: Text(
      texto,
      maxLines: 1,
      overflow: TextOverflow.ellipsis,
      style: TextStyle(color: cor, fontSize: 9, fontWeight: FontWeight.w700),
    ),
  );

  Widget _pontoRota({required Color cor, required IconData icon}) {
    return Icon(icon, size: 13, color: cor);
  }

  Widget _infoItem({required IconData icon, required String texto}) {
    return Row(
      mainAxisSize: MainAxisSize.min,
      children: [
        Icon(icon, size: 14, color: const Color(0xFF94A3B8)),
        const SizedBox(width: 5),
        Text(
          texto,
          style: const TextStyle(
            color: Color(0xFF64748B),
            fontSize: 9,
            fontWeight: FontWeight.w600,
          ),
        ),
      ],
    );
  }
}

// ============================================================================
// ESTADO VAZIO
// ============================================================================

class _EstadoVazio extends StatelessWidget {
  const _EstadoVazio();

  @override
  Widget build(BuildContext context) {
    return Center(
      child: Padding(
        padding: const EdgeInsets.all(30),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Container(
              width: 82,
              height: 82,
              decoration: BoxDecoration(
                color: const Color(0xFFE9EEFF),
                borderRadius: BorderRadius.circular(25),
              ),
              child: const Icon(
                LucideIcons.truck,
                color: Color(0xFF0C46FF),
                size: 38,
              ),
            ),

            const SizedBox(height: 18),

            const Text(
              "Nenhuma entrega encontrada",
              textAlign: TextAlign.center,
              style: TextStyle(
                color: Color(0xFF172033),
                fontSize: 17,
                fontWeight: FontWeight.w800,
              ),
            ),

            const SizedBox(height: 6),

            const Text(
              "Tente alterar sua busca ou selecionar outro filtro.",
              textAlign: TextAlign.center,
              style: TextStyle(
                color: Color(0xFF718096),
                fontSize: 11,
                height: 1.5,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

// ============================================================================
// DETALHES DA REMESSA
// ============================================================================

class DetalhesRemessa extends StatefulWidget {
  final Remessa remessa;

  const DetalhesRemessa({super.key, required this.remessa});

  @override
  State<DetalhesRemessa> createState() => _DetalhesRemessaState();
}

class _SincronizacaoDaEntrega extends StatefulWidget {
  const _SincronizacaoDaEntrega({required this.remessaId});
  final Object remessaId;
  @override
  State<_SincronizacaoDaEntrega> createState() =>
      _SincronizacaoDaEntregaState();
}

class _SincronizacaoDaEntregaState extends State<_SincronizacaoDaEntrega> {
  late Future<
    ({List<PendingAction> pendentes, List<Map<String, dynamic>> concluidas})
  >
  _dados = _carregar();

  Future<
    ({List<PendingAction> pendentes, List<Map<String, dynamic>> concluidas})
  >
  _carregar() async {
    final fila = PendingQueue.instance;
    final id = widget.remessaId.toString();
    final pendentes = await fila.listar();
    final concluidas = await fila.sincronizadasDaRemessa(id);
    return (
      pendentes: pendentes
          .where((a) => a.remessaId == id || a.caminho.contains('/$id/'))
          .toList(),
      concluidas: concluidas,
    );
  }

  @override
  void initState() {
    super.initState();
    SyncEngine.instance.estado.addListener(_atualizar);
  }

  @override
  void dispose() {
    SyncEngine.instance.estado.removeListener(_atualizar);
    super.dispose();
  }

  void _atualizar() {
    if (!mounted) return;
    setState(() {
      _dados = _carregar();
    });
  }

  Future<void> _tentarNovamente(String id) async {
    try {
      await SyncEngine.instance.tentarAcaoNovamente(id);
    } catch (_) {
      // A mensagem detalhada fica persistida na a??o da fila.
    }
    _atualizar();
  }

  String _rotulo(String tipo, Map<String, dynamic>? corpo) {
    switch (tipo) {
      case 'comprovante_entrega':
        return 'Comprovante de entrega';
      case 'ocorrencia':
        return 'Ocorr\u00eancia';
      case 'status':
        return 'Status: ${corpo?['status'] ?? 'atualizado'}';
      case 'aceitar':
        return 'Aceite da entrega';
      default:
        return 'Atualiza\u00e7\u00e3o da entrega';
    }
  }

  String _hora(Object? valor) {
    final data = DateTime.tryParse('$valor')?.toLocal();
    if (data == null) return '';
    return '${data.hour.toString().padLeft(2, '0')}:${data.minute.toString().padLeft(2, '0')}';
  }

  @override
  Widget build(
    BuildContext context,
  ) => FutureBuilder<({List<PendingAction> pendentes, List<Map<String, dynamic>> concluidas})>(
    future: _dados,
    builder: (context, snapshot) {
      if (snapshot.connectionState == ConnectionState.waiting) {
        return const LinearProgressIndicator(minHeight: 3);
      }
      final dados = snapshot.data;
      final acoes = dados?.pendentes ?? const <PendingAction>[];
      final concluidas =
          dados?.concluidas.take(4).toList() ?? const <Map<String, dynamic>>[];
      final sync = SyncEngine.instance.estado.value;
      final precisaRevisao = acoes.any((a) => a.requerIntervencao);
      final temErro =
          acoes.any((a) => a.ultimoErro != null) || sync.erro != null;
      final pendente = acoes.isNotEmpty;
      final cor = precisaRevisao || temErro
          ? Theme.of(context).colorScheme.error
          : sync.sincronizando || pendente
          ? const Color(0xFF9A6700)
          : const Color(0xFF15803D);
      final titulo = precisaRevisao
          ? 'A\u00e7\u00e3o precisa de revis\u00e3o'
          : sync.sincronizando
          ? 'Sincronizando entrega'
          : temErro
          ? 'Falha na sincroniza\u00e7\u00e3o'
          : pendente
          ? 'Aguardando sincroniza\u00e7\u00e3o'
          : concluidas.isNotEmpty
          ? 'A\u00e7\u00f5es sincronizadas'
          : 'Sem a\u00e7\u00f5es pendentes';
      final descricao = precisaRevisao
          ? 'O servidor recusou uma altera\u00e7\u00e3o. Confira o motivo abaixo; revise os dados antes de tentar novamente.'
          : sync.sincronizando
          ? 'As a\u00e7\u00f5es s\u00e3o enviadas em ordem. A que est\u00e1 sendo transmitida aparece marcada abaixo.'
          : temErro
          ? sync.erro ??
                'Uma a\u00e7\u00e3o falhou. Veja o motivo e tente novamente.'
          : pendente
          ? '${acoes.length} a\u00e7\u00e3o(\u00f5es) guardada(s) neste aparelho.'
          : concluidas.isNotEmpty
          ? 'O servidor confirmou as a\u00e7\u00f5es recentes desta remessa.'
          : 'As altera\u00e7\u00f5es desta remessa est\u00e3o em dia.';

      return Container(
        padding: const EdgeInsets.all(13),
        decoration: BoxDecoration(
          color: cor.withValues(alpha: .07),
          borderRadius: BorderRadius.circular(15),
          border: Border.all(color: cor.withValues(alpha: .25)),
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              children: [
                Icon(
                  precisaRevisao || temErro
                      ? LucideIcons.triangleAlert
                      : sync.sincronizando
                      ? LucideIcons.refreshCw
                      : pendente
                      ? LucideIcons.cloudOff
                      : LucideIcons.cloudCheck,
                  color: cor,
                  size: 20,
                  semanticLabel: titulo,
                ),
                const SizedBox(width: 10),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        titulo,
                        style: TextStyle(
                          color: cor,
                          fontWeight: FontWeight.w800,
                          fontSize: 12,
                        ),
                      ),
                      const SizedBox(height: 3),
                      Text(
                        descricao,
                        style: const TextStyle(fontSize: 11, height: 1.3),
                      ),
                    ],
                  ),
                ),
                if (sync.sincronizando)
                  const Padding(
                    padding: EdgeInsets.all(12),
                    child: SizedBox.square(
                      dimension: 18,
                      child: CircularProgressIndicator(strokeWidth: 2),
                    ),
                  ),
              ],
            ),
            for (final acao in acoes) ...[
              const SizedBox(height: 8),
              _linhaAcao(
                titulo: _rotulo(acao.tipo, acao.corpo),
                icone: acao.requerIntervencao
                    ? LucideIcons.circleAlert
                    : sync.acaoAtualId == acao.id
                    ? LucideIcons.refreshCw
                    : LucideIcons.clock3,
                cor: acao.requerIntervencao || acao.ultimoErro != null
                    ? Theme.of(context).colorScheme.error
                    : cor,
                detalhe: acao.requerIntervencao
                    ? 'Precisa de revis\u00e3o: ${acao.ultimoErro ?? 'verifique os dados'}'
                    : sync.acaoAtualId == acao.id
                    ? 'Sincronizando agora'
                    : acao.proximaTentativa != null &&
                          acao.proximaTentativa!.isAfter(DateTime.now())
                    ? 'Nova tentativa autom\u00e1tica \u00e0s ${_hora(acao.proximaTentativa)}. Motivo: ${acao.ultimoErro ?? 'falha tempor\u00e1ria'}'
                    : acao.ultimoErro != null
                    ? 'Falha; nova tentativa autom\u00e1tica ser\u00e1 feita. Motivo: ${acao.ultimoErro}'
                    : acao.tentativas > 0
                    ? 'Na fila \u2022 ${acao.tentativas} tentativa(s) realizada(s)'
                    : 'Na fila para envio quando houver conex\u00e3o',
                acaoId: acao.id,
                sincronizando: sync.sincronizando,
                aoTentar: _tentarNovamente,
              ),
            ],
            for (final acao in concluidas) ...[
              const SizedBox(height: 8),
              _linhaAcao(
                titulo: _rotulo(
                  '${acao['tipo'] ?? ''}',
                  acao['body'] is Map
                      ? Map<String, dynamic>.from(acao['body'] as Map)
                      : null,
                ),
                icone: LucideIcons.cloudCheck,
                cor: const Color(0xFF15803D),
                detalhe:
                    'Sincronizada \u00e0s ${_hora(acao['sincronizada_em'])}',
              ),
            ],
          ],
        ),
      );
    },
  );

  Widget _linhaAcao({
    required String titulo,
    required IconData icone,
    required Color cor,
    required String detalhe,
    String? acaoId,
    bool sincronizando = false,
    Future<void> Function(String id)? aoTentar,
  }) => Row(
    children: [
      Icon(icone, size: 16, color: cor, semanticLabel: detalhe),
      const SizedBox(width: 8),
      Expanded(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              titulo,
              style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w700),
            ),
            Text(detalhe, style: TextStyle(color: cor, fontSize: 11)),
          ],
        ),
      ),
      if (acaoId != null)
        IconButton(
          tooltip: 'Tentar novamente: $titulo',
          onPressed: sincronizando ? null : () => aoTentar?.call(acaoId),
          constraints: const BoxConstraints.tightFor(width: 48, height: 48),
          icon: sincronizando
              ? const SizedBox.square(
                  dimension: 17,
                  child: CircularProgressIndicator(strokeWidth: 2),
                )
              : Icon(LucideIcons.refreshCw, color: cor, size: 18),
        ),
    ],
  );
}

class _DetalhesRemessaState extends State<DetalhesRemessa> {
  Remessa get remessa => widget.remessa;
  bool _atualizandoStatus = false;
  Future<EtaResultado>? _etaFuture;

  Widget _buildAcoesRapidas() {
    final status = _normalizarStatusMotorista(remessa.status);
    final aguardando = {
      'aguardando coleta',
      'aguardando retirada',
      'pending',
      'pending pickup',
      'assigned',
    }.contains(status);
    final emTransito = _statusTransitoMotorista(status);
    final podeAtualizar = remessa.disponivel || aguardando || emTransito;
    final rotuloPrincipal = remessa.disponivel
        ? 'Aceitar entrega'
        : emTransito
        ? 'Concluir entrega'
        : 'Iniciar entrega';
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'A\u00e7\u00f5es r\u00e1pidas',
          style: TextStyle(fontSize: 14, fontWeight: FontWeight.w800),
        ),
        const SizedBox(height: 10),
        Row(
          children: [
            Expanded(
              child: OutlinedButton.icon(
                style: OutlinedButton.styleFrom(minimumSize: const Size(0, 52)),
                onPressed: () => Navigator.of(context).push(
                  MaterialPageRoute(
                    builder: (_) => MapaMotoristaPage(
                      remessaInicial: '${remessa.id ?? remessa.codigo}',
                    ),
                  ),
                ),
                icon: const Icon(LucideIcons.navigation),
                label: const Text('Abrir rota'),
              ),
            ),
            const SizedBox(width: 10),
            Expanded(
              child: OutlinedButton.icon(
                style: OutlinedButton.styleFrom(minimumSize: const Size(0, 52)),
                onPressed: _registrarOcorrencia,
                icon: const Icon(LucideIcons.octagonAlert),
                label: const Text('Ocorr\u00eancia'),
              ),
            ),
          ],
        ),
        if (podeAtualizar) ...[
          const SizedBox(height: 10),
          SizedBox(
            width: double.infinity,
            height: 52,
            child: FilledButton.icon(
              onPressed: _atualizandoStatus
                  ? null
                  : remessa.disponivel
                  ? _aceitarEntrega
                  : _avancarStatus,
              icon: _atualizandoStatus
                  ? const SizedBox.square(
                      dimension: 18,
                      child: CircularProgressIndicator(strokeWidth: 2),
                    )
                  : Icon(
                      remessa.disponivel
                          ? LucideIcons.circleCheckBig
                          : emTransito
                          ? LucideIcons.packageCheck
                          : LucideIcons.play,
                    ),
              label: Text(
                _atualizandoStatus ? 'Atualizando entrega...' : rotuloPrincipal,
              ),
            ),
          ),
        ],
      ],
    );
  }

  Future<void> _ligarSuporte() async {
    showModalBottomSheet<void>(
      context: context,
      useSafeArea: true,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
      ),
      builder: (context) => Padding(
        padding: const EdgeInsets.fromLTRB(20, 24, 20, 28),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Precisa de ajuda?',
              style: TextStyle(fontSize: 20, fontWeight: FontWeight.w800),
            ),
            const SizedBox(height: 6),
            const Text('Escolha como prefere falar com a equipe GeoSync.'),
            const SizedBox(height: 18),
            SizedBox(
              width: double.infinity,
              child: FilledButton.icon(
                onPressed: () async {
                  Navigator.pop(context);
                  final uri = Uri(scheme: 'tel', path: '08001234567');
                  if (!await launchUrl(uri) && mounted) {
                    ScaffoldMessenger.of(this.context).showSnackBar(
                      const SnackBar(
                        content: Text(
                          'Não foi possível abrir o telefone neste dispositivo.',
                        ),
                      ),
                    );
                  }
                },
                icon: const Icon(LucideIcons.phone),
                label: const Text('Ligar para 0800 123 4567'),
              ),
            ),
            const SizedBox(height: 8),
            SizedBox(
              width: double.infinity,
              child: OutlinedButton.icon(
                onPressed: () {
                  Navigator.pop(context);
                  Navigator.of(this.context).push(
                    MaterialPageRoute(
                      builder: (_) => const SuportePage(motorista: true),
                    ),
                  );
                },
                icon: const Icon(LucideIcons.messageCircle),
                label: const Text('Enviar uma mensagem'),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Future<latlong2.LatLng?> _obterLocalizacaoAtual() async {
    try {
      final dados = await ApiService.instance.ultimaLocalizacaoPorRemessa(
        remessa.id ?? remessa.codigo,
      );
      final latitude = double.tryParse('${dados['latitude'] ?? dados['lat']}');
      final longitude = double.tryParse(
        '${dados['longitude'] ?? dados['lng'] ?? dados['lon']}',
      );
      if (latitude == null ||
          longitude == null ||
          latitude < -90 ||
          latitude > 90 ||
          longitude < -180 ||
          longitude > 180) {
        throw const FormatException('Coordenadas IoT inválidas');
      }
      return latlong2.LatLng(latitude, longitude);
    } on ApiException catch (error) {
      if (!mounted) return null;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(
            'Não foi possível obter a localização IoT: ${error.message}',
          ),
        ),
      );
      return null;
    } on FormatException {
      if (!mounted) return null;
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text(
            'O módulo IoT ainda não enviou uma localização válida. Confira se ele está ligado, aguarde uma nova posição e tente novamente.',
          ),
        ),
      );
      return null;
    }
  }

  Future<void> _registrarOcorrencia() async {
    final controller = TextEditingController();
    final fotoPicker = ImagePicker();
    String? fotoBase64;
    String categoriaSelecionada = 'Cliente ausente';

    final resultado = await showDialog<Map<String, dynamic>?>(
      context: context,
      builder: (context) => StatefulBuilder(
        builder: (context, setState) => AlertDialog(
          title: const Text('Registrar ocorrência'),
          content: SizedBox(
            width: double.maxFinite,
            child: SingleChildScrollView(
              child: Column(
                mainAxisSize: MainAxisSize.min,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  DropdownButtonFormField<String>(
                    initialValue: categoriaSelecionada,
                    decoration: const InputDecoration(labelText: 'Categoria'),
                    items:
                        const [
                              'Cliente ausente',
                              'Endereço incorreto',
                              'Pacote danificado',
                              'Local inacessível',
                              'Problema com veículo',
                              'Problema na rota',
                              'Outro',
                            ]
                            .map(
                              (categoria) => DropdownMenuItem(
                                value: categoria,
                                child: Text(categoria),
                              ),
                            )
                            .toList(),
                    onChanged: (value) {
                      if (value != null) {
                        setState(() => categoriaSelecionada = value);
                      }
                    },
                  ),
                  const SizedBox(height: 12),
                  TextField(
                    controller: controller,
                    autofocus: true,
                    minLines: 3,
                    maxLines: 5,
                    decoration: const InputDecoration(
                      hintText: 'Descreva o problema, impedimento ou atraso.',
                    ),
                  ),
                  const SizedBox(height: 12),
                  Align(
                    alignment: Alignment.centerLeft,
                    child: FilledButton.icon(
                      onPressed: () async {
                        try {
                          final file = await fotoPicker.pickImage(
                            source: ImageSource.camera,
                            preferredCameraDevice: CameraDevice.rear,
                            maxWidth: 1600,
                            imageQuality: 80,
                          );
                          if (file == null) return;
                          final bytes = await File(file.path).readAsBytes();
                          setState(() => fotoBase64 = base64Encode(bytes));
                        } catch (_) {
                          if (!context.mounted) return;
                          ScaffoldMessenger.of(context).showSnackBar(
                            const SnackBar(
                              content: Text(
                                'Não foi possível incluir a foto da ocorrência.',
                              ),
                            ),
                          );
                        }
                      },
                      icon: const Icon(LucideIcons.camera),
                      label: const Text('Anexar foto'),
                    ),
                  ),
                ],
              ),
            ),
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text('Cancelar'),
            ),
            FilledButton(
              onPressed: () => Navigator.pop(context, {
                'descricao': controller.text.trim(),
                'categoria': categoriaSelecionada,
                'foto_base64': fotoBase64,
              }),
              child: const Text('Enviar'),
            ),
          ],
        ),
      ),
    );

    if (resultado == null) return;
    final descricao = '${resultado['descricao']}';
    if (descricao.trim().isEmpty) return;
    final localizacao = await _obterLocalizacaoAtual();
    if (localizacao == null) return;

    try {
      final resposta = await ApiService.instance.registrarOcorrenciaRemessa(
        remessa.id ?? remessa.codigo,
        descricao: descricao,
        categoria: '${resultado['categoria']}',
        fotoBase64: resultado['foto_base64'] as String?,
        latitude: localizacao.latitude,
        longitude: localizacao.longitude,
        nomeResponsavel: AppSession.inicialNome,
      );
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text(
              resposta['pendente_sincronizacao'] == true
                  ? 'Ocorrência salva neste aparelho e aguardando sincronização.'
                  : 'Ocorrência enviada para a equipe.',
            ),
          ),
        );
      }
    } on ApiException catch (error) {
      if (mounted) {
        ScaffoldMessenger.of(
          context,
        ).showSnackBar(SnackBar(content: Text(error.message)));
      }
    }
  }

  Future<void> _registrarComprovanteEntrega() async {
    final navigator = Navigator.of(context);
    final prova = await showDialog<_EntregaProofData>(
      context: context,
      builder: (_) => _ComprovanteEntregaDialog(remessa: remessa),
    );
    if (prova == null) return;

    final localizacao = await _obterLocalizacaoAtual();
    if (localizacao == null) return;

    setState(() => _atualizandoStatus = true);
    try {
      final respostaComprovante = await ApiService.instance
          .registrarComprovanteEntrega(
            remessa.id ?? remessa.codigo,
            destinatario: prova.destinatario,
            assinaturaBase64: prova.assinaturaBase64,
            fotoBase64: prova.fotoBase64,
            observacao: prova.observacao,
            latitude: localizacao.latitude,
            longitude: localizacao.longitude,
          );
      final respostaStatus = await ApiService.instance.atualizarStatusRemessa(
        remessa.id ?? remessa.codigo,
        'Entregue',
      );
      if (!mounted) return;
      final pendente =
          respostaComprovante['pendente_sincronizacao'] == true ||
          respostaStatus['pendente_sincronizacao'] == true;
      remessa.comprovanteEnviado = !pendente;
      final confirmou = await showDialog<bool>(
        context: context,
        builder: (context) => AlertDialog(
          title: const Text('Entrega concluída'),
          content: Text(
            pendente
                ? 'O comprovante foi salvo neste aparelho e será sincronizado quando a conexão estiver disponível.'
                : 'O comprovante foi enviado e a entrega foi atualizada no servidor.',
          ),
          actions: [
            FilledButton(
              onPressed: () => Navigator.pop(context, true),
              child: const Text('OK'),
            ),
          ],
        ),
      );
      if (confirmou ?? false) {
        if (!mounted) return;
        navigator.pop('Entregue');
      }
    } on ApiException catch (error) {
      if (mounted) {
        ScaffoldMessenger.of(
          context,
        ).showSnackBar(SnackBar(content: Text(error.message)));
      }
    } finally {
      if (mounted) setState(() => _atualizandoStatus = false);
    }
  }

  Future<void> _aceitarEntrega() async {
    if (_atualizandoStatus) return;
    setState(() => _atualizandoStatus = true);
    try {
      final resposta = await ApiService.instance.aceitarRemessa(
        remessa.id ?? remessa.codigo,
      );
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(
            resposta['pendente_sincronizacao'] == true
                ? 'Entrega aceita e salva. O envio ficará pendente até haver conexão.'
                : 'Entrega aceita com sucesso.',
          ),
        ),
      );
      Navigator.pop(context, 'accepted');
    } on ApiException catch (error) {
      if (mounted) {
        ScaffoldMessenger.of(
          context,
        ).showSnackBar(SnackBar(content: Text(error.message)));
      }
    } finally {
      if (mounted) setState(() => _atualizandoStatus = false);
    }
  }

  Color get corStatus {
    final status = _normalizarStatusMotorista(remessa.status);
    if (_statusEntregueMotorista(status)) return const Color(0xFF16A34A);
    if (_statusOcorrenciaMotorista(status) || remessa.comOcorrencia) {
      return const Color(0xFFDC2626);
    }
    if (status.startsWith('aguardando') || status == 'pending') {
      return const Color(0xFFF59E0B);
    }
    return const Color(0xFF0C46FF);
  }

  Future<void> _avancarStatus() async {
    final statusAtual = _normalizarStatusMotorista(remessa.status);
    final aguardando = {
      'aguardando coleta',
      'aguardando retirada',
      'pending',
      'pending pickup',
      'assigned',
    }.contains(statusAtual);
    final proximo = aguardando
        ? 'Em rota'
        : _statusTransitoMotorista(statusAtual)
        ? 'Entregue'
        : null;
    if (proximo == null || _atualizandoStatus) return;
    if (proximo == 'Entregue') {
      final confirmou = await showDialog<bool>(
        context: context,
        builder: (context) => AlertDialog(
          title: const Text('Confirmar entrega'),
          content: const Text(
            'Confirma que a entrega foi concluída? O comprovante digital incluirá foto, localização, assinatura e observação.',
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context, false),
              child: const Text('Cancelar'),
            ),
            FilledButton(
              onPressed: () => Navigator.pop(context, true),
              child: const Text('Continuar'),
            ),
          ],
        ),
      );
      if (confirmou != true || !mounted) return;
      await _registrarComprovanteEntrega();
      return;
    }
    setState(() => _atualizandoStatus = true);
    try {
      final resposta = await ApiService.instance.atualizarStatusRemessa(
        remessa.id ?? remessa.codigo,
        proximo,
      );
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(
            resposta['pendente_sincronizacao'] == true
                ? 'Status salvo neste aparelho e aguardando sincronização.'
                : 'Status atualizado no servidor.',
          ),
        ),
      );
      Navigator.pop(context, proximo);
    } on ApiException catch (error) {
      if (mounted) {
        ScaffoldMessenger.of(
          context,
        ).showSnackBar(SnackBar(content: Text(error.message)));
      }
    } finally {
      if (mounted) setState(() => _atualizandoStatus = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.fromLTRB(20, 12, 20, 25),
      decoration: const BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.vertical(top: Radius.circular(30)),
      ),
      child: SafeArea(
        child: SingleChildScrollView(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // INDICADOR
              Center(
                child: Container(
                  width: 42,
                  height: 5,
                  decoration: BoxDecoration(
                    color: const Color(0xFFD8DEE8),
                    borderRadius: BorderRadius.circular(10),
                  ),
                ),
              ),

              const SizedBox(height: 22),

              // CABEÇALHO
              Row(
                children: [
                  Container(
                    width: 56,
                    height: 56,
                    decoration: BoxDecoration(
                      color: corStatus.withValues(alpha: 0.10),
                      borderRadius: BorderRadius.circular(17),
                    ),
                    child: Icon(LucideIcons.truck, color: corStatus, size: 27),
                  ),

                  const SizedBox(width: 13),

                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          remessa.codigo,
                          style: const TextStyle(
                            color: Color(0xFF172033),
                            fontSize: 21,
                            fontWeight: FontWeight.w800,
                          ),
                        ),
                        const SizedBox(height: 3),
                        const Text(
                          "Detalhes da entrega",
                          style: TextStyle(
                            color: Color(0xFF718096),
                            fontSize: 11,
                          ),
                        ),
                      ],
                    ),
                  ),

                  Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 10,
                      vertical: 7,
                    ),
                    decoration: BoxDecoration(
                      color: corStatus.withValues(alpha: 0.10),
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: Text(
                      remessa.status,
                      style: TextStyle(
                        color: corStatus,
                        fontSize: 9,
                        fontWeight: FontWeight.w800,
                      ),
                    ),
                  ),
                ],
              ),

              const SizedBox(height: 25),

              _SincronizacaoDaEntrega(remessaId: remessa.id ?? remessa.codigo),
              const SizedBox(height: 16),
              _buildAcoesRapidas(),

              if (remessa.comprovanteEnviado != null) ...[
                const SizedBox(height: 8),
                Row(
                  children: [
                    Icon(
                      remessa.comprovanteEnviado!
                          ? LucideIcons.badgeCheck
                          : LucideIcons.clock,
                      size: 17,
                      color: remessa.comprovanteEnviado!
                          ? const Color(0xFF15803D)
                          : const Color(0xFFB7791F),
                    ),
                    const SizedBox(width: 7),
                    Expanded(
                      child: Text(
                        remessa.comprovanteEnviado!
                            ? 'Comprovante confirmado pelo servidor.'
                            : 'Comprovante ainda não confirmado pelo servidor.',
                        style: const TextStyle(fontSize: 12),
                      ),
                    ),
                  ],
                ),
              ],

              const SizedBox(height: 20),

              // ROTA
              _buildRota(),

              const SizedBox(height: 22),

              SizedBox(
                width: double.infinity,
                child: OutlinedButton.icon(
                  onPressed: _ligarSuporte,
                  icon: const Icon(LucideIcons.headset),
                  label: const Text('Falar com o suporte'),
                ),
              ),
              const SizedBox(height: 22),

              _historicoEntrega(),

              const SizedBox(height: 22),

              // INFORMAÇÕES
              const Text(
                "Informações da carga",
                style: TextStyle(
                  color: Color(0xFF172033),
                  fontSize: 15,
                  fontWeight: FontWeight.w800,
                ),
              ),

              const SizedBox(height: 12),

              _informacao(
                icon: LucideIcons.package,
                titulo: "Tipo de carga",
                valor: remessa.tipo,
              ),

              _informacao(
                icon: LucideIcons.weight,
                titulo: "Peso",
                valor: remessa.peso,
              ),

              _informacao(
                icon: LucideIcons.clock,
                titulo: "Previsão",
                valor: remessa.eta,
              ),

              _buildEtaCard(),

              const SizedBox(height: 10),

              // PROGRESSO
              Container(
                padding: const EdgeInsets.all(15),
                decoration: BoxDecoration(
                  color: const Color(0xFFF7F9FC),
                  borderRadius: BorderRadius.circular(16),
                  border: Border.all(color: const Color(0xFFE7ECF3)),
                ),
                child: Column(
                  children: [
                    Row(
                      children: [
                        const Text(
                          "Progresso",
                          style: TextStyle(
                            color: Color(0xFF64748B),
                            fontSize: 11,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                        const Spacer(),
                        Text(
                          "${(remessa.progresso * 100).round()}%",
                          style: TextStyle(
                            color: corStatus,
                            fontSize: 11,
                            fontWeight: FontWeight.w800,
                          ),
                        ),
                      ],
                    ),

                    const SizedBox(height: 9),

                    ClipRRect(
                      borderRadius: BorderRadius.circular(10),
                      child: LinearProgressIndicator(
                        value: remessa.progresso,
                        minHeight: 7,
                        backgroundColor: const Color(0xFFE6EAF0),
                        valueColor: AlwaysStoppedAnimation<Color>(corStatus),
                      ),
                    ),
                  ],
                ),
              ),

              const SizedBox(height: 18),

              const SizedBox(height: 8),

              SizedBox(
                width: double.infinity,
                height: 52,
                child: OutlinedButton.icon(
                  onPressed: () {
                    Navigator.of(context).push(
                      MaterialPageRoute(
                        builder: (_) => QrCodePreviewPage(remessa: remessa),
                      ),
                    );
                  },
                  icon: const Icon(LucideIcons.qrCode, size: 20),
                  label: const Text(
                    'Ver QR da entrega',
                    style: TextStyle(fontSize: 13, fontWeight: FontWeight.w700),
                  ),
                ),
              ),
              const SizedBox(height: 12),
            ],
          ),
        ),
      ),
    );
  }

  Future<EtaResultado> _calcularEta() async {
    final destinoLat = remessa.destinoLatitude;
    final destinoLon = remessa.destinoLongitude;
    if (destinoLat == null ||
        destinoLon == null ||
        destinoLat < -90 ||
        destinoLat > 90 ||
        destinoLon < -180 ||
        destinoLon > 180) {
      return EtaService.semCoordenadas(remessa.eta);
    }

    final id = '${remessa.id ?? remessa.codigo}';
    Map<String, dynamic>? atual;
    try {
      atual = await ApiService.instance.ultimaLocalizacaoPorRemessa(id);
    } on ApiException {
      // Usa a ?ltima posi??o local da mesma remessa se estiver dispon?vel.
    } catch (_) {
      // O cart?o informa que a estimativa ? aproximada quando a rede falha.
    }

    final locais = (await LocationStore.instance.todos())
        .where((p) => p.remessaId == id)
        .toList();
    double? latitude;
    double? longitude;
    DateTime? posicaoEm;
    double? velocidade;
    if (atual != null) {
      latitude = _numeroCoordenada(atual['latitude'] ?? atual['lat']);
      longitude = _numeroCoordenada(
        atual['longitude'] ?? atual['lng'] ?? atual['lon'],
      );
      posicaoEm = DateTime.tryParse(
        '${atual['registrado_em'] ?? atual['updated_at'] ?? atual['created_at'] ?? atual['timestamp'] ?? ''}',
      )?.toLocal();
      velocidade = _numeroCoordenada(atual['velocidade'] ?? atual['speed']);
    }
    if (!_coordenadasValidas(latitude, longitude) && locais.isNotEmpty) {
      final ultimo = locais.last;
      latitude = ultimo.latitude;
      longitude = ultimo.longitude;
      posicaoEm = ultimo.registradoEm.toLocal();
      velocidade = ultimo.velocidade;
    }
    if (!_coordenadasValidas(latitude, longitude)) {
      return EtaService.semPosicao(remessa.eta);
    }

    final instante = DateTime.now();
    final recentes = locais
        .where(
          (p) =>
              instante.difference(p.registradoEm.toLocal()).abs() <=
              const Duration(minutes: 30),
        )
        .toList();
    if (velocidade != null && posicaoEm != null) {
      recentes.add(
        LocationPoint.capturado(
          remessaId: id,
          latitude: latitude!,
          longitude: longitude!,
          registradoEm: posicaoEm,
          velocidade: velocidade,
        ),
      );
    }
    final distancia = EtaService.distanciaKm(
      latitudeInicial: latitude!,
      longitudeInicial: longitude!,
      latitudeFinal: destinoLat,
      longitudeFinal: destinoLon,
    );
    return EtaService.calcularComDistancia(
      distanciaRestanteKm: distancia,
      etaReferencia: remessa.eta,
      pontos: recentes,
      posicaoEm: posicaoEm,
      agora: instante,
    );
  }

  double? _numeroCoordenada(Object? valor) =>
      valor is num ? valor.toDouble() : double.tryParse('${valor ?? ''}');

  bool _coordenadasValidas(double? latitude, double? longitude) =>
      latitude != null &&
      longitude != null &&
      latitude.isFinite &&
      longitude.isFinite &&
      latitude >= -90 &&
      latitude <= 90 &&
      longitude >= -180 &&
      longitude <= 180;

  Widget _buildEtaCard() => FutureBuilder<EtaResultado>(
    future: _etaFuture ??= _calcularEta(),
    builder: (context, snapshot) {
      final resultado = snapshot.data;
      final alerta = resultado?.possivelAtraso ?? false;
      final aproximada = resultado?.aproximada ?? true;
      final cor = alerta ? const Color(0xFFF59E0B) : const Color(0xFF16A34A);
      final texto = snapshot.connectionState == ConnectionState.waiting
          ? 'Calculando com a \u00faltima posi\u00e7\u00e3o dispon\u00edvel...'
          : resultado?.texto ?? 'ETA indispon\u00edvel no momento.';
      return Container(
        margin: const EdgeInsets.only(bottom: 12),
        padding: const EdgeInsets.all(14),
        decoration: BoxDecoration(
          color: alerta ? const Color(0xFFFFF7ED) : const Color(0xFFEAFBF1),
          borderRadius: BorderRadius.circular(16),
          border: Border.all(
            color: alerta ? const Color(0xFFFCD34D) : const Color(0xFFBBF7D0),
          ),
        ),
        child: Row(
          children: [
            Icon(
              alerta ? LucideIcons.alertTriangle : LucideIcons.route,
              color: cor,
              size: 20,
            ),
            const SizedBox(width: 10),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    alerta
                        ? 'Poss\u00edvel atraso'
                        : 'Previs\u00e3o de chegada',
                    style: TextStyle(
                      color: cor,
                      fontSize: 12,
                      fontWeight: FontWeight.w800,
                    ),
                  ),
                  const SizedBox(height: 3),
                  Text(
                    texto,
                    style: const TextStyle(
                      color: Color(0xFF172033),
                      fontSize: 12,
                      fontWeight: FontWeight.w700,
                    ),
                  ),
                  if (aproximada && resultado?.motivo != null) ...[
                    const SizedBox(height: 4),
                    Text(
                      'Estimativa aproximada: ${resultado!.motivo}',
                      style: const TextStyle(
                        color: Color(0xFF64748B),
                        fontSize: 10,
                      ),
                    ),
                  ],
                  if (resultado?.distanciaRestanteKm != null) ...[
                    const SizedBox(height: 3),
                    Text(
                      'Dist\u00e2ncia em linha reta: ${resultado!.distanciaRestanteKm!.toStringAsFixed(1)} km',
                      style: const TextStyle(
                        color: Color(0xFF64748B),
                        fontSize: 10,
                      ),
                    ),
                  ],
                ],
              ),
            ),
          ],
        ),
      );
    },
  );

  Widget _buildRota() {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: const Color(0xFFF8FAFD),
        borderRadius: BorderRadius.circular(18),
        border: Border.all(color: const Color(0xFFE6EBF2)),
      ),
      child: Column(
        children: [
          _rotaItem(
            icon: LucideIcons.circleDot,
            cor: const Color(0xFF2563EB),
            titulo: "Origem",
            local: remessa.origem,
          ),

          Container(
            margin: const EdgeInsets.only(left: 6),
            height: 25,
            width: 1.5,
            color: const Color(0xFFD5DCE6),
          ),

          _rotaItem(
            icon: LucideIcons.mapPin,
            cor: const Color(0xFFDC2626),
            titulo: "Destino",
            local: remessa.destino,
          ),
        ],
      ),
    );
  }

  Widget _historicoEntrega() => FutureBuilder<List<dynamic>>(
    future: ApiService.instance.historicoRemessa(remessa.id ?? remessa.codigo),
    builder: (context, snapshot) {
      final eventos = snapshot.data?.whereType<Map>().toList() ?? const <Map>[];
      return Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            'Histórico da entrega',
            style: TextStyle(
              color: Color(0xFF172033),
              fontSize: 15,
              fontWeight: FontWeight.w800,
            ),
          ),
          const SizedBox(height: 8),
          if (snapshot.connectionState == ConnectionState.waiting)
            const LinearProgressIndicator()
          else if (eventos.isEmpty)
            const Text(
              'Nenhuma atualização registrada ainda.',
              style: TextStyle(color: Color(0xFF718096), fontSize: 11),
            )
          else
            ...eventos.map(
              (evento) => ListTile(
                dense: true,
                contentPadding: EdgeInsets.zero,
                leading: const Icon(
                  LucideIcons.history,
                  color: Color(0xFF0C46FF),
                ),
                title: Text(
                  '${evento['status'] ?? evento['descricao'] ?? 'Atualização'}',
                ),
                subtitle: Text(
                  '${evento['created_at'] ?? evento['data'] ?? ''}',
                ),
              ),
            ),
        ],
      );
    },
  );

  Widget _rotaItem({
    required IconData icon,
    required Color cor,
    required String titulo,
    required String local,
  }) {
    return Row(
      children: [
        Icon(icon, color: cor, size: 15),
        const SizedBox(width: 10),
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                titulo,
                style: const TextStyle(
                  color: Color(0xFF94A3B8),
                  fontSize: 9,
                  fontWeight: FontWeight.w600,
                ),
              ),
              const SizedBox(height: 2),
              Text(
                local,
                maxLines: 2,
                overflow: TextOverflow.ellipsis,
                style: const TextStyle(
                  color: Color(0xFF172033),
                  fontSize: 12,
                  fontWeight: FontWeight.w700,
                ),
              ),
            ],
          ),
        ),
      ],
    );
  }

  Widget _informacao({
    required IconData icon,
    required String titulo,
    required String valor,
  }) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Row(
        children: [
          Container(
            width: 34,
            height: 34,
            decoration: BoxDecoration(
              color: const Color(0xFFEFF3FA),
              borderRadius: BorderRadius.circular(10),
            ),
            child: Icon(icon, color: const Color(0xFF64748B), size: 17),
          ),

          const SizedBox(width: 10),

          Text(
            titulo,
            style: const TextStyle(color: Color(0xFF718096), fontSize: 11),
          ),

          const Spacer(),

          Flexible(
            child: Text(
              valor,
              textAlign: TextAlign.right,
              style: const TextStyle(
                color: Color(0xFF172033),
                fontSize: 11,
                fontWeight: FontWeight.w700,
              ),
            ),
          ),
        ],
      ),
    );
  }
}
