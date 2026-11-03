import 'package:flutter_test/flutter_test.dart';
import 'package:mobile/services/vehicle_document_status.dart';

void main() {
  final hoje = DateTime(2026, 11, 2);

  test('classifica validade ISO dentro do prazo de alerta', () {
    final resultado = VehicleDocumentStatus.fromValidity(
      '2026-11-20',
      today: hoje,
    );

    expect(resultado.state, VehicleDocumentState.expiringSoon);
    expect(resultado.daysRemaining, 18);
  });

  test('reconhece documento vencido no formato brasileiro', () {
    final resultado = VehicleDocumentStatus.fromValidity(
      '01/11/2026',
      today: hoje,
    );

    expect(resultado.state, VehicleDocumentState.expired);
    expect(resultado.daysRemaining, -1);
  });

  test('data inválida fica como desconhecida em vez de marcar aprovado', () {
    final resultado = VehicleDocumentStatus.fromValidity(
      '31/02/2027',
      today: hoje,
    );

    expect(resultado.state, VehicleDocumentState.unknown);
  });
}
