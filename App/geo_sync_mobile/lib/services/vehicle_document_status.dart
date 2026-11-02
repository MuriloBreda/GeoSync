/// Interpreta a validade do CRLV sem depender de um formato específico da API.
enum VehicleDocumentState { valid, expiringSoon, expired, unknown }

class VehicleDocumentStatus {
  const VehicleDocumentStatus(this.state, {this.daysRemaining});

  final VehicleDocumentState state;
  final int? daysRemaining;

  static VehicleDocumentStatus fromValidity(
    String value, {
    DateTime? today,
    int warningDays = 30,
  }) {
    final date = _parseDate(value.trim());
    if (date == null) {
      return const VehicleDocumentStatus(VehicleDocumentState.unknown);
    }
    final now = today ?? DateTime.now();
    final day = DateTime(now.year, now.month, now.day);
    final expiry = DateTime(date.year, date.month, date.day);
    final days = expiry.difference(day).inDays;
    if (days < 0) {
      return VehicleDocumentStatus(
        VehicleDocumentState.expired,
        daysRemaining: days,
      );
    }
    if (days <= warningDays) {
      return VehicleDocumentStatus(
        VehicleDocumentState.expiringSoon,
        daysRemaining: days,
      );
    }
    return VehicleDocumentStatus(
      VehicleDocumentState.valid,
      daysRemaining: days,
    );
  }

  static DateTime? _parseDate(String value) {
    final iso = DateTime.tryParse(value);
    if (iso != null) return iso;
    final parts = value.split(RegExp(r'[/.-]'));
    if (parts.length != 3) return null;
    final first = int.tryParse(parts[0]);
    final second = int.tryParse(parts[1]);
    final third = int.tryParse(parts[2]);
    if (first == null || second == null || third == null) return null;
    final yearFirst = parts[0].length == 4;
    final year = yearFirst ? first : third;
    final month = second;
    final day = yearFirst ? third : first;
    final date = DateTime(year, month, day);
    if (year < 1000 ||
        date.year != year ||
        date.month != month ||
        date.day != day) {
      return null;
    }
    return date;
  }
}
