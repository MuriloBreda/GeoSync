import 'package:flutter/material.dart';

enum DataStateKind { loading, error, empty }

/// Estados consistentes para listas que dependem de dados remotos.
class DataStatePanel extends StatelessWidget {
  const DataStatePanel({
    super.key,
    required this.kind,
    required this.title,
    required this.message,
    this.onRetry,
  });

  final DataStateKind kind;
  final String title;
  final String message;
  final VoidCallback? onRetry;

  @override
  Widget build(BuildContext context) {
    final scheme = Theme.of(context).colorScheme;
    final carregando = kind == DataStateKind.loading;
    final erro = kind == DataStateKind.error;
    final vazio = kind == DataStateKind.empty;

    final accentColor = erro
        ? const Color(0xFFEF4444)
        : vazio
            ? const Color(0xFF64748B)
            : const Color(0xFF2563EB);

    final backgroundColor = erro
        ? const Color(0xFFFFF1F2)
        : vazio
            ? const Color(0xFFF8FAFC)
            : const Color(0xFFEFF6FF);

    return SingleChildScrollView(
      child: Center(
        child: Padding(
          padding: const EdgeInsets.all(24),
          child: Semantics(
            liveRegion: carregando,
            child: Container(
              width: double.infinity,
              constraints: const BoxConstraints(maxWidth: 420),
              padding: const EdgeInsets.all(24),
              decoration: BoxDecoration(
                color: backgroundColor,
                borderRadius: BorderRadius.circular(22),
                border: Border.all(color: accentColor.withValues(alpha: 0.16)),
              ),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  Container(
                    width: 64,
                    height: 64,
                    decoration: BoxDecoration(
                      color: accentColor.withValues(alpha: 0.12),
                      borderRadius: BorderRadius.circular(18),
                    ),
                    child: Center(
                      child: carregando
                          ? SizedBox(
                              width: 26,
                              height: 26,
                              child: CircularProgressIndicator(
                                strokeWidth: 3,
                                valueColor: AlwaysStoppedAnimation<Color>(
                                  accentColor,
                                ),
                              ),
                            )
                          : Icon(
                              erro
                                  ? Icons.cloud_off_outlined
                                  : vazio
                                      ? Icons.inventory_2_outlined
                                      : Icons.sync_outlined,
                              size: 30,
                              color: accentColor,
                            ),
                    ),
                  ),
                  const SizedBox(height: 16),
                  Text(
                    title,
                    textAlign: TextAlign.center,
                    style: Theme.of(context).textTheme.titleMedium?.copyWith(
                      fontWeight: FontWeight.w800,
                    ),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    message,
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: scheme.onSurfaceVariant,
                      height: 1.5,
                    ),
                  ),
                  if (erro && onRetry != null) ...[
                    const SizedBox(height: 18),
                    FilledButton.icon(
                      onPressed: onRetry,
                      icon: const Icon(Icons.refresh_rounded),
                      label: const Text('Tentar novamente'),
                      style: FilledButton.styleFrom(
                        minimumSize: const Size(48, 48),
                      ),
                    ),
                  ],
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}

class DataFreshnessBanner extends StatelessWidget {
  const DataFreshnessBanner({super.key, required this.message, this.onRetry});

  final String message;
  final VoidCallback? onRetry;

  @override
  Widget build(BuildContext context) {
    return Semantics(
      container: true,
      label: 'Dados possivelmente desatualizados. $message',
      child: Container(
        width: double.infinity,
        padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 10),
        decoration: BoxDecoration(
          color: const Color(0xFFFFF4D6),
          border: Border.all(color: const Color(0xFFB7791F)),
          borderRadius: BorderRadius.circular(14),
        ),
        child: LayoutBuilder(
          builder: (context, constraints) {
            final conteudo = [
              const Icon(Icons.cloud_off_outlined, color: Color(0xFF754600)),
              const SizedBox(width: 10),
              Expanded(
                child: Text(
                  message,
                  style: const TextStyle(
                    color: Color(0xFF4A2C00),
                    fontSize: 13,
                    height: 1.35,
                  ),
                ),
              ),
              if (onRetry != null) ...[
                const SizedBox(width: 4),
                TextButton(
                  onPressed: onRetry,
                  style: TextButton.styleFrom(
                    foregroundColor: const Color(0xFF4A2C00),
                    minimumSize: const Size(48, 48),
                  ),
                  child: const Text('Atualizar'),
                ),
              ],
            ];
            if (constraints.maxWidth < 430 ||
                MediaQuery.textScalerOf(context).scale(14) > 20) {
              return Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(children: conteudo.take(3).toList()),
                  if (onRetry != null)
                    Align(
                      alignment: Alignment.centerRight,
                      child: TextButton(
                        onPressed: onRetry,
                        style: TextButton.styleFrom(
                          foregroundColor: const Color(0xFF4A2C00),
                          minimumSize: const Size(48, 48),
                        ),
                        child: const Text('Atualizar'),
                      ),
                    ),
                ],
              );
            }
            return Row(children: conteudo);
          },
        ),
      ),
    );
  }
}
