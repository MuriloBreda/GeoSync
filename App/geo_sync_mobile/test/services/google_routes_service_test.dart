import 'package:flutter_test/flutter_test.dart';
import 'package:latlong2/latlong.dart';
import 'package:mobile/services/google_routes_service.dart';

void main() {
  test('consulta o proxy e interpreta a resposta de rota', () async {
    var chamadas = 0;
    final service = GoogleRoutesService(
      proxy: ({required origin, required destination}) async {
        chamadas++;
        expect(origin.latitude, -23.5);
        expect(destination.longitude, -46.4);
        return {
          'data': {'distance_km': 12.5, 'duration_minutes': 15},
        };
      },
      clock: () => DateTime.utc(2026, 11, 2),
    );

    final rota = await service.calcular(
      origem: const LatLng(-23.5, -46.6),
      destino: const LatLng(-23.6, -46.4),
    );

    expect(rota?.distanceKm, 12.5);
    expect(rota?.durationMin, 15);
    expect(chamadas, 1);
  });

  test('usa cache para coordenadas próximas durante dois minutos', () async {
    var agora = DateTime.utc(2026, 11, 2);
    var chamadas = 0;
    final service = GoogleRoutesService(
      proxy: ({required origin, required destination}) async {
        chamadas++;
        return {
          'data': {'distance_km': 12.5, 'duration_minutes': 15},
        };
      },
      clock: () => agora,
    );
    Future<RoadRouteEstimate?> rota(double lat, double lng) => service.calcular(
      origem: LatLng(lat, lng),
      destino: const LatLng(-23.6, -46.4),
    );

    await rota(-23.5001, -46.6001);
    await rota(-23.5002, -46.6002);
    expect(chamadas, 1);

    agora = agora.add(const Duration(minutes: 3));
    await rota(-23.5002, -46.6002);
    expect(chamadas, 2);
  });

  test('resposta inválida não finge ter uma rota', () async {
    final service = GoogleRoutesService(
      proxy: ({required origin, required destination}) async => {'data': {}},
    );

    final rota = await service.calcular(
      origem: const LatLng(0, 0),
      destino: const LatLng(1, 1),
    );

    expect(rota, isNull);
  });
}
