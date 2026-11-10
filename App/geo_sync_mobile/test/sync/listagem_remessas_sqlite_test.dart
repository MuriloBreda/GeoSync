import 'dart:convert';

import 'package:flutter_test/flutter_test.dart';
import 'package:http/http.dart' as http;
import 'package:http/testing.dart';
import 'package:mobile/app_session.dart';
import 'package:mobile/core/remessa_repository.dart';
import 'package:mobile/services/api_service.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:mobile/sync/local_store.dart';

void main() {
  TestWidgetsFlutterBinding.ensureInitialized();

  test('primeira sincronização com SQLite cifrado não trava e devolve as remessas', () async {
    SharedPreferences.setMockInitialValues({});
    JsonListStore.usarSqliteDeTeste = true;
    await JsonListStore.resetarParaTeste();
    await ApiService.saveBaseUrl('http://192.168.0.10:8000');
    await AppSession.iniciarSessao(
      token: '1|abc',
      tipoUsuario: 'Motorista',
      email: 'moto@x.com',
      nome: 'Moto',
    );

    final remessa = {
      'id': 7,
      'codigo_rastreio': 'GS-0007',
      'origem': 'São Paulo',
      'destino': 'Campinas',
      'latitude_destino': -22.9,
      'longitude_destino': -47.06,
      'tipo_carga': 'Caixa',
      'peso': '12.50',
      'previsao_entrega': '2026-11-10',
      'status': 'Em Rota',
      'cliente_id': 3,
      'motorista_id': 5,
      'created_at': '2026-11-01T10:00:00.000000Z',
      'updated_at': '2026-11-08T10:00:00.000000Z',
      'cliente': {'id': 3, 'name': 'Cli', 'email': 'c@x.com'},
      'motorista': {'id': 5, 'name': 'Moto', 'email': 'moto@x.com'},
    };

    final client = MockClient((req) async {
      final body = req.url.path.endsWith('remessas/minhas')
          ? {
              'success': true,
              'data': [remessa],
              'meta': {'current_page': 1, 'last_page': 1, 'per_page': 100, 'total': 1},
            }
          : {'success': true, 'data': [], 'meta': {'last_page': 1}};
      return http.Response(jsonEncode(body), 200,
          headers: {'content-type': 'application/json'});
    });

    final lista = await http.runWithClient(
      () => RemessaRepository().minhas(forceRefresh: true),
      () => client,
    );
    expect(lista, hasLength(1));
    expect((lista.single as Map)['codigo_rastreio'], 'GS-0007');
  });
}
