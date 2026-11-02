import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:mobile/app_session.dart';
import 'package:mobile/app_theme.dart';
import 'package:mobile/motorista/entrega_page.dart';
import 'package:mobile/motorista/mapa_motorista_page.dart';
import 'package:mobile/services/api_service.dart';
import 'package:mobile/sync/sync_engine.dart';
import 'package:shared_preferences/shared_preferences.dart';

void main() {
  testWidgets(
    'filtro Pendentes reduz a lista \u00e0s remessas aguardando a\u00e7\u00e3o',
    (tester) async {
      SharedPreferences.setMockInitialValues({
        SyncEngine.cacheRemessasKey: jsonEncode([
          {'id': 1, 'codigo': 'GS-PEND', 'status': 'Aguardando coleta'},
          {'id': 2, 'codigo': 'GS-ROTA', 'status': 'Em rota'},
          {'id': 3, 'codigo': 'GS-FIM', 'status': 'Entregue'},
        ]),
      });
      await AppSession.iniciarSessao(
        token: 'token-ui',
        tipoUsuario: 'Motorista',
        email: 'motorista@teste.dev',
        nome: 'Motorista',
      );
      await ApiService.saveBaseUrl('http://127.0.0.1:1/api');
      await tester.pumpWidget(
        MaterialApp(theme: AppTheme.light(), home: const RemessasPage()),
      );
      for (var i = 0; i < 10; i++) {
        await tester.pump(const Duration(milliseconds: 100));
      }
      await tester.ensureVisible(find.text('Pendentes'));
      await tester.tap(find.text('Pendentes'));
      await tester.pumpAndSettle();
      expect(find.text('GS-PEND'), findsOneWidget);
      expect(find.text('GS-ROTA'), findsNothing);
      expect(find.text('GS-FIM'), findsNothing);

      await tester.pumpWidget(
        MaterialApp(theme: AppTheme.light(), home: const MapaMotoristaPage()),
      );
      for (var i = 0; i < 20; i++) {
        await tester.pump(const Duration(milliseconds: 100));
      }
      expect(find.text('GS-PEND'), findsWidgets);
      expect(
        find.textContaining('continuar usando as remessas guardadas'),
        findsOneWidget,
      );
      expect(
        find.textContaining('tiles do mapa precisam de internet'),
        findsOneWidget,
      );
      expect(tester.takeException(), isNull);
    },
  );

  Remessa remessaTeste() => Remessa(
    codigo: 'GS-FIELD-1',
    status: 'Em rota',
    origem: 'Centro',
    destino: 'Rua A, 10',
    tipo: 'Caixa',
    peso: '2 kg',
    eta: '18:00',
    progresso: .5,
    id: 88,
  );

  testWidgets('detalhe mostra atalhos operacionais acess\u00edveis', (
    tester,
  ) async {
    SharedPreferences.setMockInitialValues({});
    await AppSession.iniciarSessao(
      token: 'token-ui',
      tipoUsuario: 'Motorista',
      email: 'motorista@teste.dev',
      nome: 'Motorista',
    );
    await ApiService.saveBaseUrl('http://127.0.0.1:1/api');
    await tester.pumpWidget(
      MaterialApp(
        theme: AppTheme.light(),
        home: Scaffold(
          body: SingleChildScrollView(
            child: DetalhesRemessa(remessa: remessaTeste()),
          ),
        ),
      ),
    );
    await tester.pump();
    expect(find.text('Abrir rota'), findsOneWidget);
    expect(find.text('Ocorr\u00eancia'), findsOneWidget);
    expect(find.text('Concluir entrega'), findsOneWidget);
    expect(tester.getSize(find.text('Abrir rota')).height, greaterThan(0));
    expect(tester.takeException(), isNull);
  });

  testWidgets(
    'fluxo de conclus\u00e3o explica campos obrigat\u00f3rios do comprovante',
    (tester) async {
      SharedPreferences.setMockInitialValues({});
      await AppSession.iniciarSessao(
        token: 'token-ui',
        tipoUsuario: 'Motorista',
        email: 'motorista@teste.dev',
        nome: 'Motorista',
      );
      await ApiService.saveBaseUrl('http://127.0.0.1:1/api');
      await tester.pumpWidget(
        MaterialApp(
          theme: AppTheme.light(),
          home: Scaffold(
            body: SingleChildScrollView(
              child: DetalhesRemessa(remessa: remessaTeste()),
            ),
          ),
        ),
      );
      await tester.pump();
      await tester.tap(find.text('Concluir entrega'));
      await tester.pumpAndSettle();
      expect(find.text('Confirmar entrega'), findsOneWidget);
      await tester.tap(find.text('Continuar'));
      await tester.pumpAndSettle();
      expect(find.text('Comprovante de entrega'), findsOneWidget);
      expect(find.textContaining('obrigat\u00f3rio'), findsWidgets);
      expect(find.text('Foto (opcional)'), findsOneWidget);
      expect(find.text('Limpar assinatura'), findsOneWidget);
      expect(tester.takeException(), isNull);
    },
  );
}
