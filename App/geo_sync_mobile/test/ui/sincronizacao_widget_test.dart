import 'package:cryptography/cryptography.dart';
import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:mobile/motorista/sincronizacao_widgets.dart';
import 'package:mobile/sync/local_store.dart';
import 'package:shared_preferences/shared_preferences.dart';

void main() {
  setUp(() async {
    SharedPreferences.setMockInitialValues({});
    await JsonListStore.resetarParaTeste();
    JsonListStore.usarSqliteDeTeste = false;
    JsonListStore.chaveDeTeste = SecretKey(List<int>.filled(32, 7));
  });

  testWidgets('histórico de sincronização tem rótulo e estado vazio', (
    tester,
  ) async {
    await tester.pumpWidget(
      const MaterialApp(
        home: Scaffold(
          body: SingleChildScrollView(child: SecaoSincronizacao()),
        ),
      ),
    );
    await tester.pumpAndSettle();

    final acao = find.text('Histórico de sincronização');
    expect(acao, findsOneWidget);
    await tester.ensureVisible(acao);
    await tester.tap(acao);
    await tester.pumpAndSettle();

    expect(find.text('Ainda não há tentativas registradas.'), findsOneWidget);
  });
}
