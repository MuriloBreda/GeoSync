import 'dart:async';

import 'package:flutter/material.dart';
import 'package:lucide_icons_flutter/lucide_icons.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:latlong2/latlong.dart' as latlong2;
import 'package:mobile/core/remessa_repository.dart';
import 'package:mobile/services/api_exception.dart';
import 'package:mobile/widgets/responsive_content.dart';

class MapaMotoristaPage extends StatefulWidget {
  const MapaMotoristaPage({super.key, this.remessaInicial});
  final String? remessaInicial;

  @override
  State<MapaMotoristaPage> createState() => _MapaMotoristaPageState();
}

class _MapaMotoristaPageState extends State<MapaMotoristaPage>
    with WidgetsBindingObserver {
  final RemessaRepository _remessaRepository = RemessaRepository();
  late String _selecionada;
  List<_Remessa> _remessas = [];
  bool _carregandoRemessas = true;
  bool _falhaRemessas = false;
  bool _dadosDesatualizados = false;
  DateTime? _ultimaPosicaoEm;
  List<latlong2.LatLng> _pontosIoT = [];
  bool _carregandoRota = false;
  String? _erroRotaIoT;
  Timer? _timerLocalizacao;
  bool _atualizandoAutomaticamente = false;
  final MapController _mapController = MapController();

  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addObserver(this);
    _selecionada = widget.remessaInicial ?? '';
    _carregarRemessas();
    _timerLocalizacao = Timer.periodic(const Duration(seconds: 30), (_) {
      if (_appEmPrimeiroPlano) unawaited(_atualizarLocalizacaoSelecionada());
    });
  }

  bool get _appEmPrimeiroPlano =>
      WidgetsBinding.instance.lifecycleState == AppLifecycleState.resumed;

  @override
  void didChangeAppLifecycleState(AppLifecycleState state) {
    if (state == AppLifecycleState.resumed) {
      unawaited(_atualizarLocalizacaoSelecionada());
    }
  }

  Future<void> _atualizarLocalizacaoSelecionada() async {
    final remessa = _remessa;
    if (remessa == null ||
        remessa.id == null ||
        _atualizandoAutomaticamente ||
        _carregandoRota) {
      return;
    }
    _atualizandoAutomaticamente = true;
    try {
      final ultima = await _remessaRepository.ultimaLocalizacao(remessa.id!);
      final latitude = double.tryParse(
        '${ultima['latitude'] ?? ultima['lat']}',
      );
      final longitude = double.tryParse(
        '${ultima['longitude'] ?? ultima['lng'] ?? ultima['lon']}',
      );
      if (latitude == null ||
          longitude == null ||
          latitude < -90 ||
          latitude > 90 ||
          longitude < -180 ||
          longitude > 180) {
        return;
      }
      if (!mounted || _remessa?.id?.toString() != remessa.id.toString()) {
        return;
      }
      final ponto = latlong2.LatLng(latitude, longitude);
      setState(() {
        if (_pontosIoT.isEmpty ||
            _pontosIoT.last.latitude != latitude ||
            _pontosIoT.last.longitude != longitude) {
          _pontosIoT = [..._pontosIoT, ponto];
        }
        _erroRotaIoT = null;
      });
      _mapController.move(ponto, 13);
    } on ApiException catch (error) {
      if (mounted && _remessa?.id?.toString() == remessa.id.toString()) {
        setState(() => _erroRotaIoT = error.message);
      }
    } finally {
      _atualizandoAutomaticamente = false;
    }
  }

  Future<void> _carregarRemessas() async {
    if (mounted) {
      setState(() {
        _carregandoRemessas = true;
        _falhaRemessas = false;
      });
    }
    try {
      final dados = await _remessaRepository.minhas(forceRefresh: true);
      final remessas = dados
          .whereType<Map>()
          .map(_Remessa.fromApi)
          .where((r) => r.ativa)
          .toList();
      if (!mounted) return;
      final solicitada = remessas
          .where(
            (r) =>
                r.codigo == widget.remessaInicial ||
                r.id?.toString() == widget.remessaInicial,
          )
          .firstOrNull;
      final atual = remessas
          .where(
            (r) => r.codigo == _selecionada || r.id?.toString() == _selecionada,
          )
          .firstOrNull;
      final codigoSelecionado =
          solicitada?.codigo ??
          atual?.codigo ??
          (remessas.isEmpty ? '' : remessas.first.codigo);
      setState(() {
        _remessas = remessas;
        _carregandoRemessas = false;
        _dadosDesatualizados = SyncEngine.instance.estado.value.erro != null;
        _selecionada = codigoSelecionado;
      });
      final selecionada = _remessa;
      if (selecionada != null) await _carregarRotaIoT(selecionada);
    } on ApiException {
      await _carregarRemessasDoCache();
    } catch (_) {
      await _carregarRemessasDoCache();
    }
  }

  Future<void> _carregarRemessasDoCache() async {
    try {
      final dados = await SyncEngine.instance.remessasLocais();
      final remessas = dados
          .map(_Remessa.fromApi)
          .where((r) => r.ativa)
          .toList();
      if (!mounted) return;
      final solicitada = remessas
          .where(
            (r) =>
                r.codigo == widget.remessaInicial ||
                r.id?.toString() == widget.remessaInicial,
          )
          .firstOrNull;
      final selecionada = remessas
          .where(
            (r) => r.codigo == _selecionada || r.id?.toString() == _selecionada,
          )
          .firstOrNull;
      final codigo =
          solicitada?.codigo ??
          selecionada?.codigo ??
          (remessas.isEmpty ? '' : remessas.first.codigo);
      setState(() {
        _remessas = remessas;
        _selecionada = codigo;
        _carregandoRemessas = false;
        _falhaRemessas = remessas.isEmpty;
        _dadosDesatualizados = remessas.isNotEmpty;
      });
      final atual = _remessa;
      if (atual != null) await _carregarRotaIoT(atual);
    } catch (_) {
      if (mounted) {
        setState(() {
          _carregandoRemessas = false;
          _falhaRemessas = true;
          _dadosDesatualizados = true;
        });
      }
    }
  }

  Future<void> _carregarRotaIoT(_Remessa remessa) async {
    if (remessa.id == null) return;
    setState(() {
      _carregandoRota = true;
      _erroRotaIoT = null;
      _pontosIoT = [];
    });
    try {
      final dados = await _remessaRepository.localizacoes(remessa.id!);
      final registros = dados.whereType<Map>().toList()
        ..sort((a, b) {
          final da = DateTime.tryParse(
            '${a['registrado_em'] ?? a['created_at'] ?? ''}',
          );
          final db = DateTime.tryParse(
            '${b['registrado_em'] ?? b['created_at'] ?? ''}',
          );
          if (da == null) return db == null ? 0 : -1;
          if (db == null) return 1;
          return da.compareTo(db);
        });
      final pontos = registros
          .map((item) {
            final lat = double.tryParse('${item['latitude'] ?? item['lat']}');
            final lng = double.tryParse(
              '${item['longitude'] ?? item['lng'] ?? item['lon']}',
            );
            if (lat == null ||
                lng == null ||
                lat < -90 ||
                lat > 90 ||
                lng < -180 ||
                lng > 180) {
              return null;
            }
            return latlong2.LatLng(lat, lng);
          })
          .whereType<latlong2.LatLng>()
          .toList();
      if (!mounted || _remessa?.id?.toString() != remessa.id.toString()) return;
      final datas = registros
          .map(
            (item) => DateTime.tryParse(
              '${item['registrado_em'] ?? item['created_at'] ?? item['updated_at'] ?? ''}',
            ),
          )
          .whereType<DateTime>()
          .toList();
      setState(() {
        _pontosIoT = pontos;
        _ultimaPosicaoEm = datas.isEmpty ? null : datas.last.toLocal();
        _carregandoRota = false;
        _erroRotaIoT = pontos.isEmpty
            ? 'Sem posi\u00e7\u00f5es de rastreamento recebidas.'
            : null;
      });
      if (pontos.isNotEmpty) _mapController.move(pontos.last, 13);
    } on ApiException catch (error) {
      await _carregarPontosDoCache(remessa, error.message);
    } catch (error) {
      await _carregarPontosDoCache(remessa, '$error');
    }
  }

  Future<void> _carregarPontosDoCache(_Remessa remessa, String motivo) async {
    try {
      final todos = await LocationStore.instance.todos();
      final pontosLocais = todos
          .where(
            (p) =>
                p.remessaId == remessa.id?.toString() ||
                p.remessaId == remessa.codigo,
          )
          .toList();
      if (!mounted || _remessa?.codigo != remessa.codigo) return;
      setState(() {
        _pontosIoT = pontosLocais
            .map((p) => latlong2.LatLng(p.latitude, p.longitude))
            .toList();
        _ultimaPosicaoEm = pontosLocais.isEmpty
            ? null
            : pontosLocais.last.registradoEm.toLocal();
        _carregandoRota = false;
        _dadosDesatualizados = true;
        _erroRotaIoT = pontosLocais.isEmpty
            ? 'Sem conex\u00e3o: n\u00e3o h\u00e1 posi\u00e7\u00f5es guardadas para esta remessa. $motivo'
            : 'Sem conex\u00e3o: exibindo a \u00faltima posi\u00e7\u00e3o guardada. $motivo';
      });
      if (pontosLocais.isNotEmpty) _mapController.move(_pontosIoT.last, 13);
    } catch (_) {
      if (mounted) {
        setState(() {
          _carregandoRota = false;
          _dadosDesatualizados = true;
          _erroRotaIoT =
              'Sem conex\u00e3o: n\u00e3o foi poss\u00edvel carregar a \u00faltima posi\u00e7\u00e3o guardada. $motivo';
        });
      }
    }
  }

  @override
  void dispose() {
    WidgetsBinding.instance.removeObserver(this);
    _timerLocalizacao?.cancel();
    super.dispose();
  }

  _Remessa? get _remessa {
    for (final item in _remessas) {
      if (item.codigo == _selecionada) return item;
    }
    return null;
  }

  void _selecionar(_Remessa remessa) {
    setState(() {
      _selecionada = remessa.codigo;
      _pontosIoT = [];
    });
    _carregarRotaIoT(remessa);
  }

  void _abrirDetalhes(_Remessa item) {
    showModalBottomSheet<void>(
      context: context,
      useSafeArea: true,
      showDragHandle: true,
      builder: (context) => Padding(
        padding: const EdgeInsets.fromLTRB(20, 4, 20, 28),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              'Entrega ${item.codigo}',
              style: Theme.of(
                context,
              ).textTheme.titleLarge?.copyWith(fontWeight: FontWeight.w800),
            ),
            const SizedBox(height: 14),
            Text('Destino: ${item.destino}'),
            const SizedBox(height: 8),
            Text('Status: ${item.status}'),
            const SizedBox(height: 8),
            Text('Distância: ${item.distancia}'),
            const SizedBox(height: 8),
            Text('Previsão: ${item.previsao}'),
            const SizedBox(height: 14),
            SizedBox(
              width: double.infinity,
              height: 48,
              child: FilledButton(
                onPressed: () => Navigator.pop(context),
                child: const Text('Fechar'),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _resumoParadas(_Remessa atual) {
    final ativas = _remessas.where((item) => item.ativa).toList();
    final indice = ativas.indexWhere((item) => item.codigo == atual.codigo);
    final proxima = indice >= 0 && indice + 1 < ativas.length
        ? ativas[indice + 1]
        : null;
    final scheme = Theme.of(context).colorScheme;

    return Card(
      margin: EdgeInsets.zero,
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
        child: Row(
          children: [
            Icon(LucideIcons.navigation, color: scheme.primary, size: 20),
            const SizedBox(width: 9),
            Expanded(
              child: Semantics(
                liveRegion: true,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      'Destino atual • ${atual.destino}',
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                      style: const TextStyle(
                        fontSize: 12,
                        fontWeight: FontWeight.w800,
                      ),
                    ),
                    Text(
                      proxima == null
                          ? 'Não há outra parada ativa'
                          : 'Próximo: ${proxima.destino}',
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                      style: TextStyle(
                        color: scheme.onSurfaceVariant,
                        fontSize: 11,
                      ),
                    ),
                  ],
                ),
              ),
            ),
            IconButton(
              tooltip: 'Ver detalhes da entrega ${atual.codigo}',
              onPressed: () => _abrirDetalhes(atual),
              constraints: const BoxConstraints.tightFor(width: 48, height: 48),
              icon: const Icon(LucideIcons.info),
            ),
            if (proxima != null)
              IconButton(
                tooltip: 'Ir para a próxima parada: ${proxima.destino}',
                onPressed: () => _selecionar(proxima),
                constraints: const BoxConstraints.tightFor(
                  width: 48,
                  height: 48,
                ),
                icon: const Icon(LucideIcons.arrowRight),
              ),
          ],
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final remessa = _remessa;
    final scheme = Theme.of(context).colorScheme;
    if (remessa == null) {
      return Scaffold(
        appBar: AppBar(title: const Text('Rotas e remessas')),
        body: Center(
          child: Padding(
            padding: const EdgeInsets.all(24),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                Icon(
                  _carregandoRemessas ? LucideIcons.refreshCw : LucideIcons.map,
                  size: 36,
                  color: scheme.primary,
                ),
                const SizedBox(height: 12),
                Text(
                  _carregandoRemessas
                      ? 'Carregando suas remessas...'
                      : _falhaRemessas
                      ? 'Não foi possível carregar as remessas.'
                      : 'Não há remessas ativas para exibir.',
                  textAlign: TextAlign.center,
                  style: TextStyle(
                    color: scheme.onSurface,
                    fontWeight: FontWeight.w700,
                  ),
                ),
                if (!_carregandoRemessas && _falhaRemessas) ...[
                  const SizedBox(height: 12),
                  OutlinedButton.icon(
                    onPressed: _carregarRemessas,
                    icon: const Icon(LucideIcons.refreshCw),
                    label: const Text('Tentar novamente'),
                  ),
                ],
              ],
            ),
          ),
        ),
      );
    }
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      appBar: AppBar(
        backgroundColor: Theme.of(context).colorScheme.surface,
        foregroundColor: scheme.onSurface,
        elevation: 0,
        scrolledUnderElevation: 0,
        title: const Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              'Rotas e remessas',
              style: TextStyle(fontWeight: FontWeight.w800),
            ),
            Text(
              'Acompanhe sua operação',
              style: TextStyle(color: Color(0xFF718096), fontSize: 11),
            ),
          ],
        ),
        actions: [
          IconButton(
            tooltip: 'Atualizar localização IoT',
            icon: const Icon(LucideIcons.refreshCw),
            onPressed: () {
              final atual = _remessa;
              if (atual != null) _carregarRotaIoT(atual);
            },
          ),
          IconButton(
            tooltip: 'Centralizar localização IoT',
            icon: const Icon(LucideIcons.locateFixed),
            onPressed: () {
              if (_pontosIoT.isNotEmpty) {
                _mapController.move(_pontosIoT.last, 14);
              }
            },
          ),
          const SizedBox(width: 4),
        ],
      ),
      body: ResponsiveContent(
        maxWidth: 1280,
        child: Column(
          children: [
            Padding(
              padding: const EdgeInsets.fromLTRB(16, 12, 16, 8),
              child: _Mapa(
                remessa: remessa,
                controller: _mapController,
                pontos: _pontosIoT,
                carregando: _carregandoRota,
                erro: _erroRotaIoT,
              ),
            ),
            if (_avisoDeAtualidade != null)
              Padding(
                padding: const EdgeInsets.fromLTRB(16, 0, 16, 8),
                child: Semantics(
                  container: true,
                  liveRegion: true,
                  child: Material(
                    color: scheme.tertiaryContainer,
                    borderRadius: BorderRadius.circular(12),
                    child: Padding(
                      padding: const EdgeInsets.all(10),
                      child: Row(
                        children: [
                          Icon(
                            LucideIcons.cloudOff,
                            size: 18,
                            color: scheme.onTertiaryContainer,
                          ),
                          const SizedBox(width: 8),
                          Expanded(
                            child: Text(
                              _avisoDeAtualidade!,
                              style: TextStyle(
                                color: scheme.onTertiaryContainer,
                                fontSize: 11,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                ),
              ),
            Padding(
              padding: const EdgeInsets.fromLTRB(16, 0, 16, 8),
              child: _resumoParadas(remessa),
            ),
            Expanded(
              child: Container(
                padding: const EdgeInsets.fromLTRB(16, 18, 16, 0),
                decoration: BoxDecoration(
                  color: scheme.surface,
                  borderRadius: BorderRadius.vertical(top: Radius.circular(26)),
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Row(
                      children: [
                        Expanded(
                          child: Text(
                            'Minhas remessas',
                            maxLines: 1,
                            overflow: TextOverflow.ellipsis,
                            style: TextStyle(
                              color: scheme.onSurface,
                              fontSize: 18,
                              fontWeight: FontWeight.w800,
                            ),
                          ),
                        ),
                        const SizedBox(width: 8),
                        Text(
                          '${_remessas.length} ativas',
                          style: const TextStyle(
                            color: Color(0xFF718096),
                            fontSize: 12,
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(height: 10),
                    Expanded(
                      child: ListView.separated(
                        padding: const EdgeInsets.only(bottom: 12),
                        itemCount: _remessas.length,
                        separatorBuilder: (_, _) => const SizedBox(height: 9),
                        itemBuilder: (_, index) => _CartaoRemessa(
                          remessa: _remessas[index],
                          selecionada: _remessas[index].codigo == _selecionada,
                          onTap: () => _selecionar(_remessas[index]),
                        ),
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
}

class _Mapa extends StatelessWidget {
  const _Mapa({
    required this.remessa,
    required this.controller,
    required this.pontos,
    required this.carregando,
    required this.erro,
  });

  final _Remessa remessa;
  final MapController controller;
  final List<latlong2.LatLng> pontos;
  final bool carregando;
  final String? erro;

  @override
  Widget build(BuildContext context) {
    final destino = remessa.latitude != null && remessa.longitude != null
        ? latlong2.LatLng(remessa.latitude!, remessa.longitude!)
        : null;
    final centro = pontos.isNotEmpty
        ? pontos.last
        : destino ?? const latlong2.LatLng(-14.2350, -51.9253);
    return Container(
      height: (MediaQuery.sizeOf(context).height * 0.34).clamp(160.0, 260.0),
      clipBehavior: Clip.antiAlias,
      decoration: BoxDecoration(
        color: const Color(0xFFE7ECE5),
        borderRadius: BorderRadius.circular(24),
      ),
      child: Stack(
        children: [
          FlutterMap(
            mapController: controller,
            options: MapOptions(
              initialCenter: centro,
              initialZoom: pontos.isEmpty ? 5 : 13,
              interactionOptions: const InteractionOptions(
                flags: InteractiveFlag.all,
              ),
            ),
            children: [
              TileLayer(
                urlTemplate: 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                userAgentPackageName: 'br.com.geosync.mobile',
              ),
              if (pontos.length > 1)
                PolylineLayer(
                  polylines: [
                    Polyline(
                      points: pontos,
                      color: const Color(0xFF0C46FF),
                      strokeWidth: 5,
                    ),
                  ],
                ),
              if (pontos.isNotEmpty)
                MarkerLayer(
                  markers: [
                    Marker(
                      point: pontos.last,
                      width: 48,
                      height: 48,
                      child: const _Marcador(
                        icone: LucideIcons.radio,
                        cor: Color(0xFF0C46FF),
                      ),
                    ),
                  ],
                ),
            ],
          ),
          Positioned(
            top: 14,
            left: 14,
            right: 14,
            child: Container(
              padding: const EdgeInsets.all(13),
              decoration: BoxDecoration(
                color: Colors.white.withValues(alpha: .96),
                borderRadius: BorderRadius.circular(16),
                boxShadow: const [
                  BoxShadow(
                    color: Color(0x1A172033),
                    blurRadius: 12,
                    offset: Offset(0, 4),
                  ),
                ],
              ),
              child: Row(
                children: [
                  const Icon(LucideIcons.radio, color: Color(0xFF0C46FF)),
                  const SizedBox(width: 10),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          remessa.codigo,
                          maxLines: 1,
                          overflow: TextOverflow.ellipsis,
                          style: const TextStyle(fontWeight: FontWeight.w800),
                        ),
                        Text(
                          remessa.destino,
                          maxLines: 1,
                          overflow: TextOverflow.ellipsis,
                          style: const TextStyle(
                            color: Color(0xFF718096),
                            fontSize: 11,
                          ),
                        ),
                      ],
                    ),
                  ),
                  if (carregando)
                    const SizedBox(
                      width: 18,
                      height: 18,
                      child: CircularProgressIndicator(strokeWidth: 2),
                    )
                  else
                    Text(
                      '${pontos.length} pontos IoT',
                      style: const TextStyle(
                        color: Color(0xFF475569),
                        fontSize: 10,
                        fontWeight: FontWeight.w700,
                      ),
                    ),
                ],
              ),
            ),
          ),
          if (!carregando && pontos.isEmpty)
            Positioned(
              left: 20,
              right: 20,
              bottom: 18,
              child: Container(
                padding: const EdgeInsets.all(12),
                decoration: BoxDecoration(
                  color: Colors.white.withValues(alpha: .95),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: Text(
                  erro ??
                      'Ainda não há localização IoT registrada para esta remessa.',
                  textAlign: TextAlign.center,
                  style: TextStyle(fontSize: 12),
                ),
              ),
            ),
        ],
      ),
    );
  }
}

class _Marcador extends StatelessWidget {
  const _Marcador({required this.icone, required this.cor});
  final IconData icone;
  final Color cor;
  @override
  Widget build(BuildContext context) => Container(
    width: 40,
    height: 40,
    decoration: BoxDecoration(
      color: cor,
      shape: BoxShape.circle,
      boxShadow: [BoxShadow(color: cor.withValues(alpha: .35), blurRadius: 10)],
    ),
    child: Icon(icone, color: Colors.white, size: 21),
  );
}

class _CartaoRemessa extends StatelessWidget {
  const _CartaoRemessa({
    required this.remessa,
    required this.selecionada,
    required this.onTap,
  });
  final _Remessa remessa;
  final bool selecionada;
  final VoidCallback onTap;
  @override
  Widget build(BuildContext context) => Material(
    color: selecionada ? const Color(0xFFE9EEFF) : const Color(0xFFF8FAFC),
    borderRadius: BorderRadius.circular(17),
    child: InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(17),
      child: Container(
        padding: const EdgeInsets.all(14),
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(17),
          border: Border.all(
            color: selecionada
                ? const Color(0xFF0C46FF)
                : const Color(0xFFE8ECF3),
          ),
        ),
        child: Row(
          children: [
            Container(
              width: 9,
              height: 40,
              decoration: BoxDecoration(
                color: remessa.status == 'Atenção'
                    ? const Color(0xFFDC2626)
                    : const Color(0xFF0C46FF),
                borderRadius: BorderRadius.circular(8),
              ),
            ),
            const SizedBox(width: 11),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    remessa.codigo,
                    style: const TextStyle(
                      color: Color(0xFF172033),
                      fontWeight: FontWeight.w800,
                    ),
                  ),
                  const SizedBox(height: 3),
                  Text(
                    remessa.rota,
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                    style: const TextStyle(
                      color: Color(0xFF718096),
                      fontSize: 11,
                    ),
                  ),
                  const SizedBox(height: 7),
                  LinearProgressIndicator(
                    value: remessa.progresso,
                    minHeight: 4,
                    borderRadius: BorderRadius.circular(10),
                    color: const Color(0xFF0C46FF),
                    backgroundColor: Colors.white,
                  ),
                ],
              ),
            ),
            const SizedBox(width: 10),
            const Icon(LucideIcons.chevronRight, color: Color(0xFF718096)),
          ],
        ),
      ),
    ),
  );
}

class _Remessa {
  const _Remessa(
    this.codigo,
    this.destino,
    this.rota,
    this.distancia,
    this.previsao,
    this.status,
    this.progresso, {
    this.id,
    this.latitude,
    this.longitude,
  });
  factory _Remessa.fromApi(Map value) {
    final rawProgress =
        value['progresso'] ?? value['progress'] ?? value['percentual'] ?? 0;
    final progress = rawProgress is num
        ? rawProgress.toDouble()
        : double.tryParse(
                '$rawProgress'.replaceAll('%', '').replaceAll(',', '.'),
              ) ??
              0;
    return _Remessa(
      '${value['codigo'] ?? value['code'] ?? value['tracking_code'] ?? value['id'] ?? '-'}',
      '${value['destino'] ?? value['destination'] ?? value['destinatario_endereco'] ?? value['delivery_address'] ?? '-'}',
      '${value['rota'] ?? value['origem'] ?? value['origin'] ?? '-'} → ${value['destino'] ?? value['destination'] ?? '-'}',
      '${value['distancia'] ?? value['distancia_km'] ?? value['distance'] ?? value['distance_km'] ?? '-'}',
      '${value['eta'] ?? value['previsao_entrega'] ?? value['estimated_delivery'] ?? value['data_prevista_entrega'] ?? '-'}',
      '${value['status'] ?? value['situacao'] ?? value['status_name'] ?? 'Status não informado'}',
      (progress > 1 ? progress / 100 : progress).clamp(0.0, 1.0).toDouble(),
      id:
          value['id'] ??
          value['remessa_id'] ??
          value['shipment_id'] ??
          value['uuid'] ??
          value['codigo'] ??
          value['code'] ??
          value['tracking_code'],
      latitude: _coordenada(
        value['destino_latitude'] ??
            value['delivery_latitude'] ??
            value['latitude_destino'] ??
            value['latitude'] ??
            value['lat'],
      ),
      longitude: _coordenada(
        value['destino_longitude'] ??
            value['delivery_longitude'] ??
            value['longitude_destino'] ??
            value['longitude'] ??
            value['lng'] ??
            value['lon'],
      ),
    );
  }
  final String codigo, destino, rota, distancia, previsao, status;
  final double progresso;
  final Object? id;
  final double? latitude, longitude;
  bool get ativa {
    final normalized = status
        .trim()
        .toLowerCase()
        .replaceAll('á', 'a')
        .replaceAll('ã', 'a')
        .replaceAll('ç', 'c')
        .replaceAll('_', ' ')
        .replaceAll('-', ' ');
    return !{
      'entregue',
      'delivered',
      'completed',
      'concluida',
      'cancelada',
      'cancelado',
      'cancelled',
      'canceled',
    }.contains(normalized);
  }

  static double? _coordenada(Object? valor) =>
      valor is num ? valor.toDouble() : double.tryParse('${valor ?? ''}');
}
