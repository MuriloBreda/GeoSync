import 'package:flutter/material.dart';

/// Indicador animado reutilizável para operações que carregam dados.
class GeoSyncLoader extends StatefulWidget {
  const GeoSyncLoader({super.key, this.label, this.color, this.size = 56});

  final String? label;
  final Color? color;
  final double size;

  @override
  State<GeoSyncLoader> createState() => _GeoSyncLoaderState();
}

class _GeoSyncLoaderState extends State<GeoSyncLoader>
    with SingleTickerProviderStateMixin {
  late final AnimationController _controller = AnimationController(
    vsync: this,
    duration: const Duration(milliseconds: 850),
  )..repeat(reverse: true);

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final color = widget.color ?? Theme.of(context).colorScheme.primary;
    final iconSize = widget.size * .42;
    return Semantics(
      liveRegion: true,
      label: widget.label ?? 'Carregando',
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          SizedBox.square(
            dimension: widget.size,
            child: Stack(
              alignment: Alignment.center,
              children: [
                SizedBox.square(
                  dimension: widget.size,
                  child: CircularProgressIndicator(
                    strokeWidth: 3,
                    color: color.withValues(alpha: .28),
                    backgroundColor: color.withValues(alpha: .08),
                  ),
                ),
                ScaleTransition(
                  scale: Tween<double>(begin: .82, end: 1.08).animate(
                    CurvedAnimation(
                      parent: _controller,
                      curve: Curves.easeInOut,
                    ),
                  ),
                  child: Icon(
                    Icons.local_shipping_outlined,
                    size: iconSize,
                    color: color,
                  ),
                ),
              ],
            ),
          ),
          if (widget.label != null) ...[
            const SizedBox(height: 10),
            Text(
              widget.label!,
              textAlign: TextAlign.center,
              style: TextStyle(
                color: Theme.of(context).colorScheme.onSurfaceVariant,
                fontSize: 12,
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
        ],
      ),
    );
  }
}

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
                          ? GeoSyncLoader(color: accentColor, size: 42)
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
