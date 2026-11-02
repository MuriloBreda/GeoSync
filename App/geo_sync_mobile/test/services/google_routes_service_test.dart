import 'dart:convert';

import 'package:flutter_test/flutter_test.dart';
import 'package:http/http.dart' as http;
import 'package:http/testing.dart';
import 'package:latlong2/latlong.dart';
import 'package:mobile/services/google_routes_service.dart';

void main() {
  test('solicita rota com trânsito e converte distância e duração', () async {
    final cliente = MockClient((request) async {
      expect(request.url.host, 'routes.test');
      expect(request.headers['X-Goog-Api-Key'], 'chave-teste');
      expect(
        request.headers['X-Goog-FieldMask'],
        'routes.duration,routes.distanceMeters',
      );
      final body = jsonDecode(request.body) as Map<String, dynamic>;
      expect(body['routingPreference'], 'TRAFFIC_AWARE');
      expect(body['origin']['location']['latLng']['latitude'], -23.5);
      expect(body['destination']['location']['latLng']['longitude'], -46.4);
      return http.Response(
        jsonEncode({
          'routes': [
            {'distanceMeters': 12500, 'duration': '900s'},
          ],
        }),
        200,
      );
    });
    final service = GoogleRoutesService(
      apiKey: 'chave-teste',
      client: cliente,
      endpoint: Uri.https('routes.test', '/computeRoutes'),
      clock: () => DateTime.utc(2026, 11, 2),
    );

    final route = await service.calcular(
      origem: const LatLng(-23.5, -46.6),
      destino: const LatLng(-23.6, -46.4),
    );

    expect(route?.distanceKm, 12.5);
    expect(route?.durationMin, 15);
  });

  test('sem chave não faz uma requisição externa', () async {
    var chamadas = 0;
    final service = GoogleRoutesService(
      client: MockClient((_) async {
        chamadas++;
        return http.Response('{}', 200);
      }),
    );

    final route = await service.calcular(
      origem: const LatLng(0, 0),
      destino: const LatLng(1, 1),
    );

    expect(route, isNull);
    expect(chamadas, 0);
  });
}
