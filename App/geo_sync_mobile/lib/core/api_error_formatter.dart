import 'package:flutter/foundation.dart';

class ApiErrorFormatter {
  const ApiErrorFormatter._();

  static String messageFrom(dynamic data, [int? statusCode]) {
    if (statusCode != null && statusCode >= 500) {
      debugPrint('[API] erro $statusCode do servidor');
      return 'O servidor encontrou um erro ao processar a solicitação. Tente novamente mais tarde.';
    }

    final directMessage = _extractMessage(data);
    if (directMessage != null && directMessage.isNotEmpty) {
      return _looksTechnical(directMessage)
          ? 'Não foi possível concluir a solicitação.'
          : directMessage;
    }

    final formattedErrors = _extractErrors(data);
    if (formattedErrors != null && formattedErrors.isNotEmpty) {
      return formattedErrors;
    }

    if (data is String && data.trim().isNotEmpty) {
      final cleaned = data.trim();
      return _looksTechnical(cleaned)
          ? 'Não foi possível concluir a solicitação.'
          : cleaned;
    }

    return 'Não foi possível concluir a solicitação.';
  }

  static String? _extractMessage(dynamic data) {
    if (data is Map) {
      final message = data['message'] ?? data['error'];
      if (message is String && message.trim().isNotEmpty) {
        return message.trim();
      }
    }
    if (data is String && data.trim().isNotEmpty) {
      return data.trim();
    }
    return null;
  }

  static String? _extractErrors(dynamic data) {
    if (data is! Map) return null;

    final errors = data['errors'];
    if (errors is! Map) return null;

    for (final entry in errors.entries) {
      final value = entry.value;
      if (value is List) {
        for (final item in value) {
          final message = _stringValue(item);
          if (message != null && message.isNotEmpty) {
            if (_looksTechnical(message)) continue;
            return message;
          }
        }
      }
      if (value is Map) {
        final nested = _extractErrors(value);
        if (nested != null && nested.isNotEmpty) return nested;
      }
      final message = _stringValue(value);
      if (message != null && message.isNotEmpty) {
        if (_looksTechnical(message)) continue;
        return '${entry.key}: $message';
      }
    }

    return null;
  }

  static String? _stringValue(Object? value) {
    if (value is String && value.trim().isNotEmpty) {
      return value.trim();
    }
    if (value is num || value is bool) {
      return '$value';
    }
    return null;
  }

  static bool _looksTechnical(String value) {
    final normalized = value.trim();
    if (normalized.isEmpty) return false;

    return RegExp(
      r'SQLSTATE|PDOException|Fatal error|Traceback|Exception:|Call to undefined|at [A-Za-z0-9_./\\-]+\(|<b>Fatal error',
      caseSensitive: false,
    ).hasMatch(normalized);
  }
}
