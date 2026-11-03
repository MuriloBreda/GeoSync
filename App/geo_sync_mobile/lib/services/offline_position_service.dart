import 'package:mobile/sync/location_point.dart';

/// Seleciona a leitura mais recente da remessa, mas nunca considera posições
/// antigas como se fossem a localização atual do motorista.
class OfflinePositionService {
  static LocationPoint? maisRecente({
    required Iterable<LocationPoint> pontos,
    required String remessaId,
    DateTime? agora,
    Duration idadeMaxima = const Duration(minutes: 20),
  }) {
    final instante = agora ?? DateTime.now();
    final elegiveis =
        pontos
            .where((ponto) => ponto.remessaId == remessaId)
            .where(
              (ponto) =>
                  instante.difference(ponto.registradoEm).abs() <= idadeMaxima,
            )
            .toList()
          ..sort((a, b) => b.registradoEm.compareTo(a.registradoEm));
    return elegiveis.firstOrNull;
  }
}
