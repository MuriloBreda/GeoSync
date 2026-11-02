import 'package:flutter_test/flutter_test.dart';
import 'package:mobile/services/offline_position_service.dart';
import 'package:mobile/sync/location_point.dart';

void main() {
  final agora = DateTime.utc(2026, 11, 2, 12);

  LocationPoint ponto(String id, String remessaId, DateTime quando) =>
      LocationPoint(
        id: id,
        remessaId: remessaId,
        latitude: -23.5,
        longitude: -46.6,
        registradoEm: quando,
      );

  test('usa a posição recente mais nova somente da remessa solicitada', () {
    final escolhida = OfflinePositionService.maisRecente(
      pontos: [
        ponto('antiga', '1', agora.subtract(const Duration(minutes: 10))),
        ponto('outra-remessa', '2', agora),
        ponto('nova', '1', agora.subtract(const Duration(minutes: 2))),
      ],
      remessaId: '1',
      agora: agora,
    );

    expect(escolhida?.id, 'nova');
  });

  test('recusa localização antiga para não apresentá-la como atual', () {
    final escolhida = OfflinePositionService.maisRecente(
      pontos: [
        ponto('antiga', '1', agora.subtract(const Duration(minutes: 21))),
      ],
      remessaId: '1',
      agora: agora,
    );

    expect(escolhida, isNull);
  });
}
