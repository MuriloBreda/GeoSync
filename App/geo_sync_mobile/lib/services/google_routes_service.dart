import 'dart:convert';

import 'package:http/http.dart' as http;
import 'package:latlong2/latlong.dart';

class RoadRouteEstimate {
  const RoadRouteEstimate({
    required this.distanceKm,
    required this.durationMin,
  });

  final double distanceKm;
  final int durationMin;
}

/// Calcula um trajeto por ruas pela Routes API do Google Maps Platform.
/// A chave deve ser fornecida em tempo de build e restrita no Google Cloud
/// ao aplicativo Android/iOS e à Routes API.
class GoogleRoutesService {
  GoogleRoutesService({
    String? apiKey,
    http.Client? client,
    Uri? endpoint,
    DateTime Function()? clock,
  }) : apiKey = apiKey ?? const String.fromEnvironment('GOOGLE_MAPS_API_KEY'),
       _client = client ?? http.Client(),
       _endpoint =
           endpoint ??
           Uri.https('routes.googleapis.com', '/directions/v2:computeRoutes'),
       _clock = clock ?? DateTime.now;

  final String apiKey;
  final http.Client _client;
  final Uri _endpoint;
  final DateTime Function() _clock;

  bool get configurado => apiKey.trim().isNotEmpty;

  Future<RoadRouteEstimate?> calcular({
    required LatLng origem,
    required LatLng destino,
  }) async {
    if (!configurado) return null;
    final resposta = await _client
        .post(
          _endpoint,
          headers: {
            'Content-Type': 'application/json',
            'X-Goog-Api-Key': apiKey,
            'X-Goog-FieldMask': 'routes.duration,routes.distanceMeters',
          },
          body: jsonEncode({
            'origin': {
              'location': {
                'latLng': {
                  'latitude': origem.latitude,
                  'longitude': origem.longitude,
                },
              },
            },
            'destination': {
              'location': {
                'latLng': {
                  'latitude': destino.latitude,
                  'longitude': destino.longitude,
                },
              },
            },
            'travelMode': 'DRIVE',
            'routingPreference': 'TRAFFIC_AWARE',
            'departureTime': _clock().toUtc().toIso8601String(),
            'units': 'METRIC',
          }),
        )
        .timeout(const Duration(seconds: 8));
    if (resposta.statusCode < 200 || resposta.statusCode >= 300) {
      throw StateError('Routes API respondeu HTTP ${resposta.statusCode}.');
    }
    final body = jsonDecode(resposta.body);
    if (body is! Map ||
        body['routes'] is! List ||
        (body['routes'] as List).isEmpty) {
      return null;
    }
    final rota = (body['routes'] as List).first;
    if (rota is! Map) return null;
    final metros = rota['distanceMeters'];
    final segundos = _segundos(rota['duration']);
    if (metros is! num || segundos == null || metros <= 0 || segundos <= 0) {
      return null;
    }
    return RoadRouteEstimate(
      distanceKm: metros.toDouble() / 1000,
      durationMin: (segundos / 60).ceil(),
    );
  }

  int? _segundos(Object? value) {
    final match = RegExp(r'^(\d+(?:\.\d+)?)s$').firstMatch('$value');
    if (match == null) return null;
    return double.tryParse(match.group(1)!)?.round();
  }
}
