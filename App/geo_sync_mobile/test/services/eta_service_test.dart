import 'package:flutter_test/flutter_test.dart';
import 'package:mobile/services/eta_service.dart';
import 'package:mobile/sync/location_point.dart';

void main() {
  final agora = DateTime.utc(2026, 11, 2, 12);

  test('calcula dist\u00e2ncia geogr\u00e1fica entre coordenadas', () {
    final distancia = EtaService.distanciaKm(
      latitudeInicial: 0,
      longitudeInicial: 0,
      latitudeFinal: 0,
      longitudeFinal: 1,
    );
    expect(distancia, closeTo(111.2, 1));
  });

  test(
    'usa dist\u00e2ncia e velocidade recente e sinaliza risco de atraso',
    () {
      final ponto = LocationPoint(
        id: 'p1',
        remessaId: '10',
        latitude: -23.5,
        longitude: -46.6,
        registradoEm: agora,
        velocidade: 10,
      );
      final resultado = EtaService.calcularComDistancia(
        distanciaRestanteKm: 9,
        etaReferencia: '5 min',
        pontos: [ponto],
        posicaoEm: agora,
        agora: agora,
      );
      expect(resultado.tempoRestanteMin, 15);
      expect(resultado.possivelAtraso, isTrue);
      expect(resultado.aproximada, isTrue);
      expect(resultado.motivo, contains('linha reta'));
      expect(resultado.distanciaRestanteKm, 9);
    },
  );

  test(
    'marca estimativa como aproximada quando posi\u00e7\u00e3o est\u00e1 antiga',
    () {
      final resultado = EtaService.calcularComDistancia(
        distanciaRestanteKm: 3,
        etaReferencia: '45 min',
        posicaoEm: agora.subtract(const Duration(hours: 1)),
        agora: agora,
      );
      expect(resultado.aproximada, isTrue);
      expect(resultado.motivo, contains('desatualizada'));
    },
  );

  test(
    'n\u00e3o inventa dist\u00e2ncia quando faltam coordenadas ou posi\u00e7\u00e3o',
    () {
      final semDestino = EtaService.semCoordenadas('18:00');
      final semPosicao = EtaService.semPosicao('18:00');
      expect(semDestino.distanciaRestanteKm, isNull);
      expect(semPosicao.distanciaRestanteKm, isNull);
      expect(semDestino.aproximada, isTrue);
      expect(semPosicao.texto, contains('indispon'));
    },
  );
}
