import 'dart:convert';

import 'package:latlong2/latlong.dart';
import 'package:mobile/services/api_service.dart';

class RoadRouteEstimate {
  const RoadRouteEstimate({
    required this.distanceKm,
    required this.durationMin,
  });

  final double distanceKm;
  final int durationMin;
}

typedef RouteProxy =
    Future<Map<String, dynamic>> Function({
      required LatLng origin,
      required LatLng destination,
    });

/// Consulta o backend autenticado. A chave Google fica apenas no servidor.
/// Respostas próximas são mantidas brevemente para reduzir tráfego e custo.
class GoogleRoutesService {
  GoogleRoutesService({
    RouteProxy? proxy,
    DateTime Function()? clock,
    this.cacheDuration = const Duration(minutes: 2),
    this.maxCacheEntries = 32,
  }) : _proxy = proxy ?? GoogleRoutesService._requestBackend,
       _clock = clock ?? DateTime.now;

  final RouteProxy _proxy;
  final DateTime Function() _clock;
  final Duration cacheDuration;
  final int maxCacheEntries;
  final Map<String, _CacheEntry> _cache = {};

  Future<RoadRouteEstimate?> calcular({
    required LatLng origem,
    required LatLng destino,
  }) async {
    final agora = _clock();
    final chave = _cacheKey(origem, destino);
    final guardada = _cache.remove(chave);
    if (guardada != null && guardada.expiraEm.isAfter(agora)) {
      _cache[chave] = guardada;
      return guardada.rota;
    }

    final resposta = await _proxy(origin: origem, destination: destino);
    final payload = resposta['data'] is Map
        ? Map<String, dynamic>.from(resposta['data'] as Map)
        : resposta;
    final distancia = _numero(payload['distance_km']);
    final duracao = _numero(payload['duration_minutes']);
    if (distancia == null ||
        duracao == null ||
        distancia <= 0 ||
        duracao <= 0) {
      return null;
    }
    final rota = RoadRouteEstimate(
      distanceKm: distancia,
      durationMin: duracao.ceil(),
    );
    _cache[chave] = _CacheEntry(rota, agora.add(cacheDuration));
    while (_cache.length > maxCacheEntries) {
      _cache.remove(_cache.keys.first);
    }
    return rota;
  }

  static Future<Map<String, dynamic>> _requestBackend({
    required LatLng origin,
    required LatLng destination,
  }) async {
    final result = await ApiService.instance.requisicao(
      'POST',
      'rotas/estimativa',
      body: {
        'origin': {'latitude': origin.latitude, 'longitude': origin.longitude},
        'destination': {
          'latitude': destination.latitude,
          'longitude': destination.longitude,
        },
      },
    );
    if (result is Map) return Map<String, dynamic>.from(result);
    throw const FormatException('Resposta inválida do serviço de rotas.');
  }

  String _cacheKey(LatLng origem, LatLng destino) => jsonEncode([
    origem.latitude.toStringAsFixed(3),
    origem.longitude.toStringAsFixed(3),
    destino.latitude.toStringAsFixed(4),
    destino.longitude.toStringAsFixed(4),
  ]);

  double? _numero(Object? value) =>
      value is num ? value.toDouble() : double.tryParse('$value');
}

class _CacheEntry {
  const _CacheEntry(this.rota, this.expiraEm);

  final RoadRouteEstimate? rota;
  final DateTime expiraEm;
}
