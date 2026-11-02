import 'dart:math' as math;

import 'package:mobile/sync/location_point.dart';

class EtaResultado {
  const EtaResultado({
    required this.texto,
    required this.possivelAtraso,
    required this.distanciaRestanteKm,
    required this.tempoRestanteMin,
    required this.margemMinutos,
    required this.aproximada,
    this.motivo,
  });

  final String texto;
  final bool possivelAtraso;
  final double? distanciaRestanteKm;
  final int? tempoRestanteMin;
  final int margemMinutos;
  final bool aproximada;
  final String? motivo;
}

/// Estimativa local de chegada, sem afirmar precis\u00e3o de uma rota externa.
class EtaService {
  static const double _velocidadePadraoKmh = 18.0;
  static const Duration idadeMaximaPosicao = Duration(minutes: 20);

  /// Calcula a estimativa com uma dist\u00e2ncia restante medida entre coordenadas.
  static EtaResultado calcularComDistancia({
    required double distanciaRestanteKm,
    required String etaReferencia,
    List<LocationPoint> pontos = const [],
    DateTime? posicaoEm,
    DateTime? agora,
  }) {
    final instante = agora ?? DateTime.now();
    final distancia = distanciaRestanteKm.clamp(0.0, 500.0);
    final velocidades = pontos
        .where((p) => p.velocidade != null && p.velocidade! > 0)
        .map((p) => p.velocidade! * 3.6)
        .where((v) => v >= 4 && v <= 100)
        .toList();
    final temVelocidade = velocidades.isNotEmpty;
    final velocidade = temVelocidade
        ? (velocidades.reduce((a, b) => a + b) / velocidades.length).clamp(
            4.0,
            80.0,
          )
        : _velocidadePadraoKmh;
    final minutos = distancia <= 0 ? 0 : (distancia / velocidade * 60).round();
    final planejado = _tempoRestantePlanejado(etaReferencia, instante);
    final margem = math.max(8, ((planejado ?? 0) * .25).round());
    final atraso = planejado != null && minutos > planejado + margem;
    final posicaoAntiga =
        posicaoEm == null ||
        instante.difference(posicaoEm).abs() > idadeMaximaPosicao;
    final aproximada = true;
    final texto = distancia <= 0
        ? 'Motorista chegou ao destino'
        : atraso
        ? 'Poss\u00edvel atraso \u2022 cerca de $minutos min restantes'
        : 'Chegada estimada: ${math.max(1, minutos - 5)} - ${minutos + 5} min';
    final motivos = <String>[
      'dist\u00e2ncia em linha reta n\u00e3o considera o tra\u00e7ado real nem o tr\u00e2nsito',
    ];
    if (posicaoAntiga) {
      motivos.add('a posi\u00e7\u00e3o pode estar desatualizada');
    }
    if (!temVelocidade) {
      motivos.add('foi usada velocidade m\u00e9dia padr\u00e3o');
    }

    return EtaResultado(
      texto: texto,
      possivelAtraso: atraso,
      distanciaRestanteKm: distancia,
      tempoRestanteMin: minutos,
      margemMinutos: margem,
      aproximada: aproximada,
      motivo: motivos.isEmpty ? null : '${motivos.join('; ')}.',
    );
  }

  /// Sem as duas coordenadas n\u00e3o calcula dist\u00e2ncia ou atraso com valores
  /// inventados; deixa expl\u00edcito que a informa\u00e7\u00e3o do servidor \u00e9 a refer\u00eancia.
  static EtaResultado semPosicao(String etaReferencia) {
    final referencia = etaReferencia.trim();
    return EtaResultado(
      texto: referencia.isEmpty || referencia == '-'
          ? 'ETA indispon\u00edvel: aguardando a posi\u00e7\u00e3o atual do motorista.'
          : 'Previs\u00e3o do servidor: $referencia. A posi\u00e7\u00e3o atual est\u00e1 indispon\u00edvel.',
      possivelAtraso: false,
      distanciaRestanteKm: null,
      tempoRestanteMin: null,
      margemMinutos: 0,
      aproximada: true,
      motivo:
          'N\u00e3o foi poss\u00edvel obter uma localiza\u00e7\u00e3o recente desta remessa.',
    );
  }

  static EtaResultado semCoordenadas(String etaReferencia) {
    final referencia = etaReferencia.trim();
    return EtaResultado(
      texto: referencia.isEmpty || referencia == '-'
          ? 'ETA indispon\u00edvel: faltam coordenadas do destino e posi\u00e7\u00e3o recente.'
          : 'Previs\u00e3o do servidor: $referencia. Dist\u00e2ncia ainda n\u00e3o calcul\u00e1vel.',
      possivelAtraso: false,
      distanciaRestanteKm: null,
      tempoRestanteMin: null,
      margemMinutos: 0,
      aproximada: true,
      motivo:
          'A estimativa por dist\u00e2ncia requer localiza\u00e7\u00e3o atual e destino v\u00e1lidos.',
    );
  }

  static double distanciaKm({
    required double latitudeInicial,
    required double longitudeInicial,
    required double latitudeFinal,
    required double longitudeFinal,
  }) {
    const raioTerraKm = 6371.0;
    final lat1 = _rad(latitudeInicial);
    final lat2 = _rad(latitudeFinal);
    final deltaLat = _rad(latitudeFinal - latitudeInicial);
    final deltaLon = _rad(longitudeFinal - longitudeInicial);
    final a =
        math.sin(deltaLat / 2) * math.sin(deltaLat / 2) +
        math.cos(lat1) *
            math.cos(lat2) *
            math.sin(deltaLon / 2) *
            math.sin(deltaLon / 2);
    return raioTerraKm * 2 * math.atan2(math.sqrt(a), math.sqrt(1 - a));
  }

  static int? _tempoRestantePlanejado(String valor, DateTime agora) {
    final texto = valor.trim();
    if (texto.isEmpty || texto == '-' || texto == '--:--') return null;
    final data = DateTime.tryParse(texto);
    if (data != null) {
      final minutos = data.difference(agora).inMinutes;
      return minutos < 0 ? 0 : minutos;
    }
    final horario = RegExp(r'^(\d{1,2}):(\d{2})(?::\d{2})?$').firstMatch(texto);
    if (horario != null) {
      final alvo = DateTime(
        agora.year,
        agora.month,
        agora.day,
        int.parse(horario.group(1)!),
        int.parse(horario.group(2)!),
      );
      final minutos = alvo.difference(agora).inMinutes;
      return minutos < 0 ? 0 : minutos;
    }
    final duracao = RegExp(
      r'(\d+(?:[,.]\d+)?)\s*(min(?:uto)?s?|h(?:ora)?s?)',
      caseSensitive: false,
    ).firstMatch(texto);
    if (duracao == null) return null;
    final quantidade = double.tryParse(duracao.group(1)!.replaceAll(',', '.'));
    if (quantidade == null) return null;
    return (quantidade *
            (duracao.group(2)!.toLowerCase().startsWith('h') ? 60 : 1))
        .round();
  }

  static double _rad(double graus) => graus * math.pi / 180;
}
