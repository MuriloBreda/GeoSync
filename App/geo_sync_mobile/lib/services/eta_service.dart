import 'dart:math' as math;

import 'package:mobile/sync/location_point.dart';

class EtaResultado {
  const EtaResultado({
    required this.texto,
    required this.possivelAtraso,
    required this.distanciaRestanteKm,
    required this.tempoRestanteMin,
    required this.margemMinutos,
    this.aproximada = false,
    this.motivo = '',
  });

  final String texto;
  final bool possivelAtraso;
  final double? distanciaRestanteKm;
  final int tempoRestanteMin;
  final int margemMinutos;
  final bool aproximada;
  final String motivo;
}

class EtaService {
  static const double _distanciaPadraoKm = 12.0;
  static const double _velocidadePadraoKmh = 18.0;
  static const double _raioTerraKm = 6371.0;

  static double distanciaKm({
    required double latitudeInicial,
    required double longitudeInicial,
    required double latitudeFinal,
    required double longitudeFinal,
  }) {
    final lat1 = _toRadians(latitudeInicial);
    final lat2 = _toRadians(latitudeFinal);
    final deltaLat = _toRadians(latitudeFinal - latitudeInicial);
    final deltaLon = _toRadians(longitudeFinal - longitudeInicial);

    final a = math.sin(deltaLat / 2) * math.sin(deltaLat / 2) +
        math.cos(lat1) *
            math.cos(lat2) *
            math.sin(deltaLon / 2) *
            math.sin(deltaLon / 2);

    final c = 2 * math.atan2(math.sqrt(a), math.sqrt(1 - a));
    return _raioTerraKm * c;
  }

  static EtaResultado semCoordenadas(String etaReferencia) {
    final tempoPlanejadoMin = _parseTempoMin(etaReferencia);
    return EtaResultado(
      texto: 'Destino sem coordenadas; ETA indisponível',
      possivelAtraso: false,
      distanciaRestanteKm: null,
      tempoRestanteMin: 0,
      margemMinutos: math.max(8, (tempoPlanejadoMin * 0.25).round()),
      aproximada: true,
      motivo: 'Destino sem coordenadas válidas para estimar linha reta.',
    );
  }

  static EtaResultado semPosicao(String etaReferencia) {
    final tempoPlanejadoMin = _parseTempoMin(etaReferencia);
    return EtaResultado(
      texto: 'Posição indisponível; ETA não disponível',
      possivelAtraso: false,
      distanciaRestanteKm: null,
      tempoRestanteMin: 0,
      margemMinutos: math.max(8, (tempoPlanejadoMin * 0.25).round()),
      aproximada: true,
      motivo: 'Posição indisponível para calcular a ETA atual.',
    );
  }

  static EtaResultado calcularComDistancia({
    required double distanciaRestanteKm,
    required String etaReferencia,
    List<LocationPoint> pontos = const <LocationPoint>[],
    DateTime? posicaoEm,
    required DateTime agora,
  }) {
    final tempoPlanejadoMin = _parseTempoMin(etaReferencia);
    final velocidadeKmh = _velocidadeMediaKmh(pontos);
    final tempoRestanteMin = distanciaRestanteKm <= 0
        ? 0
        : (distanciaRestanteKm / velocidadeKmh * 60).round();
    final margemMinutos = math.max(8, (tempoPlanejadoMin * 0.25).round());
    final posicaoAntiga = posicaoEm != null &&
        agora.difference(posicaoEm).inMinutes > 30;
    final possivelAtraso = tempoRestanteMin > 0 &&
        tempoPlanejadoMin > 0 &&
        tempoRestanteMin > tempoPlanejadoMin + margemMinutos;

    final motivo = posicaoAntiga
        ? 'Posição desatualizada; ETA baseada no último ponto conhecido.'
        : 'Estimativa baseada em linha reta e velocidade recente.';

    final texto = possivelAtraso
        ? '⚠️ Possível atraso • estimativa de $tempoRestanteMin min até a entrega'
        : distanciaRestanteKm > 0
            ? 'ETA de $tempoRestanteMin min para atingir o destino'
            : 'Entrega em andamento';

    return EtaResultado(
      texto: texto,
      possivelAtraso: possivelAtraso,
      distanciaRestanteKm: distanciaRestanteKm,
      tempoRestanteMin: tempoRestanteMin,
      margemMinutos: margemMinutos,
      aproximada: true,
      motivo: motivo,
    );
  }

  /// Calcula uma ETA local e detecta atraso provável sem depender de rota
  /// externa. O algoritmo usa a posição atual, a velocidade média recente e o
  /// progresso da entrega; quando não há dados suficientes, cai para uma média
  /// conservadora para não apontar falso positivo.
  static EtaResultado calcular({
    required double progresso,
    required String etaReferencia,
    List<LocationPoint> pontos = const <LocationPoint>[],
    double? distanciaKm,
  }) {
    final progressoNormalizado = progresso.clamp(0.0, 1.0);
    final distanciaBaseKm = (distanciaKm ?? _distanciaPadraoKm).clamp(1.0, 80.0);
    final distanciaRestanteKm = math.max(
      0.0,
      (1 - progressoNormalizado) * distanciaBaseKm,
    );

    final velocidadeKmh = _velocidadeMediaKmh(pontos);
    final tempoRestanteMin = distanciaRestanteKm <= 0
        ? 0
        : (distanciaRestanteKm / velocidadeKmh * 60).round();

    final tempoPlanejadoMin = _parseTempoMin(etaReferencia);
    final margemMinutos = math.max(8, (tempoPlanejadoMin * 0.25).round());
    final possivelAtraso = tempoRestanteMin > 0 &&
        tempoPlanejadoMin > 0 &&
        tempoRestanteMin > tempoPlanejadoMin + margemMinutos;

    final motivo = 'Estimativa baseada em linha reta e velocidade recente.';
    final texto = _montarTexto(
      distanciaRestanteKm: distanciaRestanteKm,
      tempoRestanteMin: tempoRestanteMin,
      possivelAtraso: possivelAtraso,
      tempoPlanejadoMin: tempoPlanejadoMin,
    );

    return EtaResultado(
      texto: texto,
      possivelAtraso: possivelAtraso,
      distanciaRestanteKm: distanciaRestanteKm,
      tempoRestanteMin: tempoRestanteMin,
      margemMinutos: margemMinutos,
      aproximada: true,
      motivo: motivo,
    );
  }

  static String _montarTexto({
    required double distanciaRestanteKm,
    required int tempoRestanteMin,
    required bool possivelAtraso,
    required int tempoPlanejadoMin,
  }) {
    if (possivelAtraso) {
      final faixa = tempoRestanteMin <= 0 ? 0 : tempoRestanteMin;
      return '⚠️ Possível atraso • estimativa de $faixa min até a entrega';
    }

    if (tempoRestanteMin <= 0) {
      return 'Entrega em andamento';
    }

    if (distanciaRestanteKm > 0 && tempoPlanejadoMin > 0) {
      final inicio = math.max(0, tempoRestanteMin - 5);
      final fim = tempoRestanteMin + 5;
      return 'Chegada estimada: $inicio–$fim minutos';
    }

    if (distanciaRestanteKm > 0) {
      return 'Motorista a ~${distanciaRestanteKm.toStringAsFixed(1)} km do destino';
    }

    return 'Chegada estimada em $tempoPlanejadoMin min';
  }

  static double _velocidadeMediaKmh(List<LocationPoint> pontos) {
    final validos = pontos
        .where((p) => p.velocidade != null && p.velocidade! > 0)
        .map((p) => p.velocidade! * 3.6)
        .toList();

    if (validos.isEmpty) return _velocidadePadraoKmh;

    final media = validos.reduce((soma, item) => soma + item) / validos.length;
    return media.clamp(4.0, 80.0);
  }

  static int _parseTempoMin(String valor) {
    final texto = valor.trim();
    if (texto.isEmpty || texto == '-' || texto == '--:--') return 0;

    final semTexto = texto.toLowerCase().replaceAll(RegExp(r'[^0-9,.-]'), ' ');
    final numeros = semTexto
        .split(RegExp(r'\s+'))
        .where((item) => item.isNotEmpty)
        .map(double.tryParse)
        .whereType<double>()
        .toList();

    if (numeros.isEmpty) return 0;

    final base = numeros.first;
    if (texto.toLowerCase().contains('hora') || texto.toLowerCase().contains('horas')) {
      return (base * 60).round();
    }
    if (texto.toLowerCase().contains('dia') || texto.toLowerCase().contains('dias')) {
      return (base * 24 * 60).round();
    }
    if (texto.toLowerCase().contains('min') || texto.toLowerCase().contains('minute')) {
      return base.round();
    }

    return base.round();
  }

  static double _toRadians(double graus) => graus * (math.pi / 180.0);
}
