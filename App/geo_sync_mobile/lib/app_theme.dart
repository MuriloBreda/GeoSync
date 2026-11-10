import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

/// Paleta e componentes compartilhados pelo GeoSync.
///
/// As telas devem obter cores variáveis pelo [Theme.of] para respeitar a
/// preferência de aparência selecionada pelo usuário.
class AppTheme {
  AppTheme._();

  static const _blue = Color(0xFF0C46FF);
  static const _darkBlue = Color(0xFF0B2A4A);

  static ThemeData light() => _build(Brightness.light);

  static ThemeData dark() => _build(Brightness.dark);

  static ThemeData _build(Brightness brightness) {
    final isDark = brightness == Brightness.dark;
    final scheme =
        ColorScheme.fromSeed(
          seedColor: isDark ? const Color(0xFF60A5FA) : _blue,
          brightness: brightness,
          primary: isDark ? const Color(0xFF60A5FA) : _blue,
          surface: isDark ? const Color(0xFF172033) : Colors.white,
        ).copyWith(
          surface: isDark ? const Color(0xFF182335) : Colors.white,
          secondary: isDark ? const Color(0xFF5EEAD4) : const Color(0xFF0F766E),
          surfaceContainer: isDark
              ? const Color(0xFF202D42)
              : const Color(0xFFF6F8FB),
          surfaceContainerHighest: isDark
              ? const Color(0xFF2A3950)
              : const Color(0xFFEDF2F7),
          onSurface: isDark ? const Color(0xFFF8FAFC) : const Color(0xFF172033),
          onSurfaceVariant: isDark
              ? const Color(0xFFD2DCEB)
              : const Color(0xFF475569),
          outline: isDark ? const Color(0xFF8190A6) : const Color(0xFFCBD5E1),
          outlineVariant: isDark
              ? const Color(0xFF40516A)
              : const Color(0xFFE2E8F0),
        );

    return ThemeData(
      useMaterial3: true,
      brightness: brightness,
      colorScheme: scheme,
      pageTransitionsTheme: const PageTransitionsTheme(
        builders: {
          TargetPlatform.android: _GeoSyncPageTransitionsBuilder(),
          TargetPlatform.fuchsia: _GeoSyncPageTransitionsBuilder(),
          TargetPlatform.linux: _GeoSyncPageTransitionsBuilder(),
          TargetPlatform.windows: _GeoSyncPageTransitionsBuilder(),
          TargetPlatform.iOS: CupertinoPageTransitionsBuilder(),
          TargetPlatform.macOS: CupertinoPageTransitionsBuilder(),
        },
      ),
      scaffoldBackgroundColor: isDark
          ? const Color(0xFF0F172A)
          : const Color(0xFFF3F6FA),
      textTheme: const TextTheme(
        displaySmall: TextStyle(fontSize: 36, fontWeight: FontWeight.w700),
        headlineSmall: TextStyle(fontSize: 24, fontWeight: FontWeight.w700),
        titleLarge: TextStyle(fontSize: 20, fontWeight: FontWeight.w700),
        titleMedium: TextStyle(fontSize: 16, fontWeight: FontWeight.w600),
        bodyLarge: TextStyle(fontSize: 16, height: 1.4),
        bodyMedium: TextStyle(fontSize: 14, height: 1.4),
        labelLarge: TextStyle(fontSize: 14, fontWeight: FontWeight.w600),
      ).apply(bodyColor: scheme.onSurface, displayColor: scheme.onSurface),
      appBarTheme: AppBarTheme(
        backgroundColor: isDark
            ? const Color(0xFF0F172A)
            : const Color(0xFFF5F7FB),
        foregroundColor: scheme.onSurface,
        elevation: 0,
        scrolledUnderElevation: 0,
        surfaceTintColor: Colors.transparent,
      ),
      cardTheme: CardThemeData(
        color: scheme.surface,
        surfaceTintColor: Colors.transparent,
        elevation: 0,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(16),
          side: BorderSide(color: scheme.outlineVariant),
        ),
      ),
      dialogTheme: DialogThemeData(
        backgroundColor: scheme.surface,
        surfaceTintColor: Colors.transparent,
      ),
      bottomSheetTheme: BottomSheetThemeData(
        backgroundColor: scheme.surface,
        surfaceTintColor: Colors.transparent,
      ),
      inputDecorationTheme: InputDecorationTheme(
        filled: true,
        fillColor: scheme.surface,
        contentPadding: const EdgeInsets.symmetric(
          horizontal: 16,
          vertical: 15,
        ),
        labelStyle: TextStyle(color: scheme.onSurfaceVariant),
        hintStyle: TextStyle(
          color: scheme.onSurfaceVariant.withValues(alpha: .8),
        ),
        prefixIconColor: scheme.onSurfaceVariant,
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: BorderSide(color: scheme.outlineVariant),
        ),
        enabledBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: BorderSide(color: scheme.outlineVariant),
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: BorderSide(color: scheme.primary, width: 1.5),
        ),
      ),
      navigationBarTheme: NavigationBarThemeData(
        backgroundColor: scheme.surface,
        indicatorColor: scheme.primary.withValues(alpha: 0.10),
        elevation: 0,
        height: 72,
        labelBehavior: NavigationDestinationLabelBehavior.alwaysShow,
        iconTheme: WidgetStateProperty.resolveWith((states) {
          final selected = states.contains(WidgetState.selected);
          return IconThemeData(
            color: selected ? scheme.primary : scheme.onSurfaceVariant,
            size: 22,
          );
        }),
        labelTextStyle: WidgetStateProperty.resolveWith((states) {
          final selected = states.contains(WidgetState.selected);
          return TextStyle(
            color: selected ? scheme.primary : scheme.onSurfaceVariant,
            fontSize: 11,
            fontWeight: selected ? FontWeight.w700 : FontWeight.w500,
          );
        }),
      ),
      switchTheme: SwitchThemeData(
        thumbColor: WidgetStateProperty.resolveWith(
          (states) => states.contains(WidgetState.selected)
              ? scheme.primary
              : scheme.outline,
        ),
        trackColor: WidgetStateProperty.resolveWith(
          (states) => states.contains(WidgetState.selected)
              ? scheme.primary.withValues(alpha: .35)
              : scheme.outlineVariant,
        ),
      ),
      snackBarTheme: SnackBarThemeData(
        backgroundColor: isDark ? const Color(0xFF2A3950) : _darkBlue,
        // O fundo é escuro nos dois temas, então o texto é sempre claro.
        contentTextStyle: const TextStyle(color: Color(0xFFF8FAFC)),
        actionTextColor: const Color(0xFF93C5FD),
        behavior: SnackBarBehavior.floating,
      ),
      // Botões com área de toque de pelo menos 48 px (recomendação do
      // Material e das diretrizes de acessibilidade).
      filledButtonTheme: FilledButtonThemeData(style: _botao()),
      elevatedButtonTheme: ElevatedButtonThemeData(style: _botao()),
      outlinedButtonTheme: OutlinedButtonThemeData(style: _botao()),
      textButtonTheme: TextButtonThemeData(
        style: TextButton.styleFrom(
          minimumSize: const Size(48, 44),
          padding: const EdgeInsets.symmetric(horizontal: 12),
          textStyle: const TextStyle(fontWeight: FontWeight.w600),
        ),
      ),
    );
  }

  static ButtonStyle _botao() => ButtonStyle(
    minimumSize: const WidgetStatePropertyAll(Size(64, 48)),
    padding: const WidgetStatePropertyAll(
      EdgeInsets.symmetric(horizontal: 20, vertical: 12),
    ),
    shape: WidgetStatePropertyAll(
      RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
    ),
    textStyle: const WidgetStatePropertyAll(
      TextStyle(fontSize: 15, fontWeight: FontWeight.w600),
    ),
  );
}

class _GeoSyncPageTransitionsBuilder extends PageTransitionsBuilder {
  const _GeoSyncPageTransitionsBuilder();

  @override
  Widget buildTransitions<T>(
    PageRoute<T> route,
    BuildContext context,
    Animation<double> animation,
    Animation<double> secondaryAnimation,
    Widget child,
  ) {
    if (MediaQuery.of(context).disableAnimations) return child;

    final transicao = CurvedAnimation(
      parent: animation,
      curve: Curves.easeOutCubic,
      reverseCurve: Curves.easeInCubic,
    );
    return FadeTransition(
      key: const ValueKey('geosync-page-fade'),
      opacity: transicao,
      child: ScaleTransition(
        key: const ValueKey('geosync-page-scale'),
        scale: Tween<double>(begin: 0.985, end: 1).animate(transicao),
        child: child,
      ),
    );
  }
}

extension GeoSyncTheme on BuildContext {
  bool get isDarkMode => Theme.of(this).brightness == Brightness.dark;

  Color get pageBackground => Theme.of(this).scaffoldBackgroundColor;

  Color get surfaceColor => Theme.of(this).colorScheme.surface;

  Color get primaryTextColor => Theme.of(this).colorScheme.onSurface;

  Color get secondaryTextColor => Theme.of(this).colorScheme.onSurfaceVariant;

  Color get borderColor => Theme.of(this).colorScheme.outlineVariant;
}
