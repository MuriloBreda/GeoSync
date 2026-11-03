import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:mobile/login_screen.dart';

void main() {
  testWidgets('login atende às diretrizes básicas de acessibilidade', (
    tester,
  ) async {
    final semantics = tester.ensureSemantics();
    try {
      await tester.pumpWidget(const MaterialApp(home: LoginScreen()));

      await expectLater(tester, meetsGuideline(labeledTapTargetGuideline));
      await expectLater(tester, meetsGuideline(androidTapTargetGuideline));
    } finally {
      semantics.dispose();
    }
  });
}
