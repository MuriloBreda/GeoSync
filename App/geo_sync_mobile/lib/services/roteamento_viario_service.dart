import 'dart:convert';

import 'package:http/http.dart' as http;
import 'package:latlong2/latlong.dart';

/// Obtém a geometria da rota viária entre a posição atual e o destino.
class RoteamentoViarioService {
  static Future<List<LatLng>> calcular({
    required LatLng origem,
    required LatLng destino,
  }) async {
    final coordenadas =
        '${origem.longitude},${origem.latitude};${destino.longitude},${destino.latitude}';
    final uri = Uri.https(
      'router.project-osrm.org',
      '/route/v1/driving/$coordenadas',
      {'overview': 'full', 'geometries': 'geojson', 'steps': 'false'},
    );
    final resposta = await http.get(uri).timeout(const Duration(seconds: 12));
    if (resposta.statusCode != 200) {
      throw Exception('Não foi possível calcular a rota viária.');
    }
    final payload = jsonDecode(resposta.body) as Map<String, dynamic>;
    final rotas = payload['routes'];
    if (payload['code'] != 'Ok' || rotas is! List || rotas.isEmpty) {
      throw Exception('Não há rota viária entre esses pontos.');
    }
    final geometry = (rotas.first as Map)['geometry'] as Map?;
    final coordenadasRota = geometry?['coordinates'];
    if (coordenadasRota is! List || coordenadasRota.length < 2) {
      throw Exception('O serviço não retornou o traçado da rota.');
    }
    return coordenadasRota.map((ponto) {
      final pontoValido = ponto as List;
      return LatLng(
        (pontoValido[1] as num).toDouble(),
        (pontoValido[0] as num).toDouble(),
      );
    }).toList();
  }
}
