import 'package:flutter/cupertino.dart' show CupertinoIcons;
import 'package:flutter/material.dart';
import 'package:mobile/tela_dashboard.dart';
import 'package:mobile/motorista/motorista_dashboard.dart';
import 'package:mobile/cadastro_screen.dart';
import 'package:mobile/core/session_repository.dart';
import 'package:mobile/esqueceu_senha_page.dart';
import 'package:mobile/services/api_exception.dart';
import 'package:mobile/services/api_service.dart';
import 'package:mobile/widgets/api_server_settings.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen>
    with SingleTickerProviderStateMixin {
  final _formKey = GlobalKey<FormState>();
  late final AnimationController _entradaController;
  late final Animation<double> _opacidadeEntrada;
  late final Animation<Offset> _deslocamentoEntrada;
  bool _obscurePassword = true;
  String _tipoUsuario = 'Cliente';

  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();

  @override
  void initState() {
    super.initState();
    _entradaController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 520),
    );
    _opacidadeEntrada = CurvedAnimation(
      parent: _entradaController,
      curve: Curves.easeOut,
    );
    _deslocamentoEntrada =
        Tween<Offset>(begin: const Offset(0, .035), end: Offset.zero).animate(
          CurvedAnimation(
            parent: _entradaController,
            curve: Curves.easeOutCubic,
          ),
        );
    _entradaController.forward();
  }

  @override
  void dispose() {
    _emailController.dispose();
    _passwordController.dispose();
    _entradaController.dispose();
    super.dispose();
  }

  bool _carregando = false;

  Future<void> _fazerLogin() async {
    if (_formKey.currentState!.validate()) {
      setState(() => _carregando = true);
      try {
        final resposta = await ApiService.instance.login(
          email: _emailController.text,
          password: _passwordController.text,
        );
        final token = ApiService.instance.authToken(resposta);
        if (token == null) {
          throw ApiException(
            'Login aceito pela API, mas o token não foi encontrado na resposta. '
            'Verifique se o JSON retorna token, access_token ou accessToken.',
          );
        }
        final usuario = ApiService.instance.authUser(resposta);
        final tipoApi =
            '${usuario['tipo_usuario'] ?? usuario['tipo'] ?? _tipoUsuario}';
        final tipo = tipoApi.toLowerCase() == 'motorista'
            ? 'Motorista'
            : 'Cliente';
        await const SessionRepository().iniciarSessaoFromResponse(
          <String, dynamic>{
            ...resposta,
            'data': {
              ...(resposta['data'] is Map
                  ? Map<String, dynamic>.from(resposta['data'])
                  : <String, dynamic>{}),
              'token': token,
              'user': {...Map<String, dynamic>.from(usuario), 'tipo': tipo},
            },
          },
        );
        if (!mounted) return;
        final destino = tipo == 'Cliente'
            ? const TelaDashboard(tipoUsuario: 'Cliente')
            : const MotoristaDashboard();
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (context) => destino),
        );
      } on ApiException catch (error) {
        if (!mounted) return;
        ScaffoldMessenger.of(
          context,
        ).showSnackBar(SnackBar(content: Text(error.message)));
      } finally {
        if (mounted) setState(() => _carregando = false);
      }
    }
  }

  Future<void> _configurarServidor() => configurarServidorApi(context);

  Widget _tipoAcessoCard({
    required String tipo,
    required String descricao,
    required IconData icone,
  }) {
    final scheme = Theme.of(context).colorScheme;
    final selecionado = _tipoUsuario == tipo;
    final cor = selecionado ? scheme.primary : scheme.onSurfaceVariant;
    final radius = BorderRadius.circular(16);

    return Expanded(
      child: Semantics(
        button: true,
        selected: selecionado,
        label: '$tipo: $descricao',
        child: Material(
          color: Colors.transparent,
          borderRadius: radius,
          child: InkWell(
            onTap: _carregando
                ? null
                : () => setState(() => _tipoUsuario = tipo),
            borderRadius: radius,
            child: AnimatedContainer(
              duration: const Duration(milliseconds: 180),
              curve: Curves.easeOut,
              height: 104,
              padding: const EdgeInsets.all(12),
              decoration: BoxDecoration(
                color: selecionado
                    ? Color.alphaBlend(
                        scheme.primary.withValues(alpha: .07),
                        scheme.surface,
                      )
                    : scheme.surface,
                borderRadius: radius,
                border: Border.all(
                  color: selecionado
                      ? scheme.primary.withValues(alpha: .75)
                      : scheme.outlineVariant,
                  width: selecionado ? 1.5 : 1,
                ),
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(
                    children: [
                      AnimatedContainer(
                        duration: const Duration(milliseconds: 180),
                        width: 36,
                        height: 36,
                        decoration: BoxDecoration(
                          color: cor.withValues(alpha: .10),
                          borderRadius: BorderRadius.circular(11),
                        ),
                        child: Icon(icone, color: cor, size: 19),
                      ),
                      const Spacer(),
                      AnimatedSwitcher(
                        duration: const Duration(milliseconds: 180),
                        child: Icon(
                          selecionado
                              ? CupertinoIcons.checkmark_circle_fill
                              : CupertinoIcons.circle,
                          key: ValueKey(selecionado),
                          size: 18,
                          color: selecionado ? scheme.primary : scheme.outline,
                        ),
                      ),
                    ],
                  ),
                  const Spacer(),
                  Text(
                    tipo,
                    style: TextStyle(
                      color: scheme.onSurface,
                      fontSize: 13,
                      fontWeight: FontWeight.w800,
                    ),
                  ),
                  const SizedBox(height: 2),
                  Text(
                    descricao,
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                    style: TextStyle(
                      color: scheme.onSurfaceVariant,
                      fontSize: 10,
                    ),
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final scheme = Theme.of(context).colorScheme;
    final primaryColor = scheme.primary;

    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      body: Stack(
        children: [
          Container(
            height: 190,
            decoration: BoxDecoration(
              gradient: LinearGradient(
                colors: [
                  const Color(0xFF0B2A4A),
                  Color.lerp(primaryColor, const Color(0xFF0B2A4A), .35)!,
                ],
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
              ),
              borderRadius: BorderRadius.only(
                bottomLeft: Radius.circular(28),
                bottomRight: Radius.circular(28),
              ),
            ),
          ),
          SafeArea(
            child: SingleChildScrollView(
              padding: EdgeInsets.symmetric(
                horizontal: MediaQuery.sizeOf(context).width < 360 ? 16 : 24,
                vertical: 18,
              ),
              child: FadeTransition(
                opacity: _opacidadeEntrada,
                child: SlideTransition(
                  position: _deslocamentoEntrada,
                  child: Center(
                    child: ConstrainedBox(
                      constraints: const BoxConstraints(maxWidth: 460),
                      child: Column(
                        children: [
                          const SizedBox(height: 20),
                          Row(
                            children: [
                              Container(
                                width: 58,
                                height: 58,
                                padding: const EdgeInsets.all(8),
                                decoration: BoxDecoration(
                                  color: Colors.white,
                                  borderRadius: BorderRadius.circular(14),
                                ),
                                child: Image.asset(
                                  'assets/logo.png',
                                  fit: BoxFit.contain,
                                  errorBuilder: (context, error, stackTrace) =>
                                      Icon(
                                        CupertinoIcons.car_detailed,
                                        size: 34,
                                        color: primaryColor,
                                      ),
                                ),
                              ),
                              const SizedBox(width: 14),
                              const Expanded(
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text(
                                      'GeoSync',
                                      style: TextStyle(
                                        color: Colors.white,
                                        fontSize: 25,
                                        fontWeight: FontWeight.w800,
                                      ),
                                    ),
                                    SizedBox(height: 3),
                                    Text(
                                      'Gestão e rastreamento de entregas',
                                      maxLines: 2,
                                      style: TextStyle(
                                        color: Colors.white70,
                                        fontSize: 13,
                                        height: 1.25,
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                            ],
                          ),
                          const SizedBox(height: 24),
                          Container(
                            padding: EdgeInsets.all(
                              MediaQuery.sizeOf(context).width < 360 ? 16 : 22,
                            ),
                            decoration: BoxDecoration(
                              color: scheme.surface,
                              borderRadius: BorderRadius.circular(24),
                              border: Border.all(
                                color: scheme.outlineVariant.withValues(
                                  alpha: 0.85,
                                ),
                              ),
                              boxShadow: [
                                BoxShadow(
                                  color: Colors.black.withValues(alpha: 0.045),
                                  blurRadius: 16,
                                  offset: const Offset(0, 6),
                                ),
                              ],
                            ),
                            child: Form(
                              key: _formKey,
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Text(
                                    'Acesse sua conta',
                                    style: Theme.of(context)
                                        .textTheme
                                        .titleLarge
                                        ?.copyWith(color: scheme.onSurface),
                                  ),
                                  const SizedBox(height: 4),
                                  Text(
                                    'Entre para acompanhar suas entregas.',
                                    style: TextStyle(
                                      color: scheme.onSurfaceVariant,
                                      fontSize: 13,
                                    ),
                                  ),
                                  const SizedBox(height: 20),
                                  Text(
                                    'Entrar como',
                                    style: TextStyle(
                                      fontSize: 14,
                                      fontWeight: FontWeight.w700,
                                      color: scheme.onSurface,
                                    ),
                                  ),
                                  const SizedBox(height: 10),
                                  Row(
                                    children: [
                                      _tipoAcessoCard(
                                        tipo: 'Cliente',
                                        descricao: 'Acompanhe seus envios',
                                        icone: CupertinoIcons.person_fill,
                                      ),
                                      const SizedBox(width: 10),
                                      _tipoAcessoCard(
                                        tipo: 'Motorista',
                                        descricao: 'Gerencie suas rotas',
                                        icone: Icons.local_shipping_outlined,
                                      ),
                                    ],
                                  ),
                                  const SizedBox(height: 9),
                                  Row(
                                    crossAxisAlignment:
                                        CrossAxisAlignment.start,
                                    children: [
                                      Icon(
                                        CupertinoIcons.info_circle,
                                        color: scheme.onSurfaceVariant,
                                        size: 15,
                                      ),
                                      const SizedBox(width: 6),
                                      Expanded(
                                        child: Text(
                                          'O perfil de acesso é validado pela conta após o login.',
                                          style: TextStyle(
                                            color: scheme.onSurfaceVariant,
                                            fontSize: 11,
                                            height: 1.35,
                                          ),
                                        ),
                                      ),
                                    ],
                                  ),
                                  const SizedBox(height: 22),
                                  TextFormField(
                                    controller: _emailController,
                                    keyboardType: TextInputType.emailAddress,
                                    textInputAction: TextInputAction.next,
                                    autofillHints: const [
                                      AutofillHints.username,
                                    ],
                                    autocorrect: false,
                                    textCapitalization: TextCapitalization.none,
                                    validator: (value) {
                                      if (value == null ||
                                          value.trim().isEmpty) {
                                        return 'Informe o seu e-mail';
                                      }
                                      if (!value.contains('@')) {
                                        return 'Informe um e-mail válido';
                                      }
                                      return null;
                                    },
                                    decoration: InputDecoration(
                                      labelText: 'E-mail',
                                      hintText: 'seu@email.com',
                                      prefixIcon: const Icon(
                                        CupertinoIcons.envelope,
                                      ),
                                      filled: true,
                                      fillColor: scheme.surfaceContainer,
                                      border: OutlineInputBorder(
                                        borderRadius: BorderRadius.circular(12),
                                        borderSide: BorderSide.none,
                                      ),
                                      enabledBorder: OutlineInputBorder(
                                        borderRadius: BorderRadius.circular(12),
                                        borderSide: BorderSide(
                                          color: scheme.outlineVariant,
                                        ),
                                      ),
                                      focusedBorder: OutlineInputBorder(
                                        borderRadius: BorderRadius.circular(12),
                                        borderSide: BorderSide(
                                          color: primaryColor,
                                          width: 2,
                                        ),
                                      ),
                                    ),
                                  ),
                                  const SizedBox(height: 16),
                                  TextFormField(
                                    controller: _passwordController,
                                    obscureText: _obscurePassword,
                                    textInputAction: TextInputAction.done,
                                    autofillHints: const [
                                      AutofillHints.password,
                                    ],
                                    autocorrect: false,
                                    enableSuggestions: false,
                                    onFieldSubmitted: (_) => _fazerLogin(),
                                    validator: (value) {
                                      if (value == null || value.isEmpty) {
                                        return 'Informe a sua senha';
                                      }
                                      if (value.length < 6) {
                                        return 'A senha deve ter pelo menos 6 caracteres';
                                      }
                                      return null;
                                    },
                                    decoration: InputDecoration(
                                      labelText: 'Senha',
                                      hintText: '••••••••',
                                      prefixIcon: const Icon(
                                        CupertinoIcons.lock,
                                      ),
                                      suffixIcon: IconButton(
                                        tooltip: _obscurePassword
                                            ? 'Mostrar senha'
                                            : 'Ocultar senha',
                                        icon: Icon(
                                          _obscurePassword
                                              ? CupertinoIcons.eye_slash
                                              : CupertinoIcons.eye,
                                        ),
                                        onPressed: () {
                                          setState(() {
                                            _obscurePassword =
                                                !_obscurePassword;
                                          });
                                        },
                                      ),
                                      filled: true,
                                      fillColor: scheme.surfaceContainer,
                                      border: OutlineInputBorder(
                                        borderRadius: BorderRadius.circular(12),
                                        borderSide: BorderSide.none,
                                      ),
                                      enabledBorder: OutlineInputBorder(
                                        borderRadius: BorderRadius.circular(12),
                                        borderSide: BorderSide(
                                          color: scheme.outlineVariant,
                                        ),
                                      ),
                                      focusedBorder: OutlineInputBorder(
                                        borderRadius: BorderRadius.circular(12),
                                        borderSide: BorderSide(
                                          color: primaryColor,
                                          width: 2,
                                        ),
                                      ),
                                    ),
                                  ),
                                  const SizedBox(height: 8),
                                  Align(
                                    alignment: Alignment.centerRight,
                                    child: TextButton(
                                      onPressed: () async {
                                        final senhaRedefinida =
                                            await Navigator.push<bool>(
                                              context,
                                              MaterialPageRoute(
                                                builder: (_) =>
                                                    EsqueceuSenhaPage(
                                                      emailInicial:
                                                          _emailController.text,
                                                    ),
                                              ),
                                            );
                                        if (!context.mounted) return;
                                        if (senhaRedefinida == true) {
                                          ScaffoldMessenger.of(
                                            context,
                                          ).showSnackBar(
                                            const SnackBar(
                                              content: Text(
                                                'Se o e-mail estiver cadastrado, você receberá um link para criar uma nova senha.',
                                              ),
                                              backgroundColor: Color(
                                                0xFF16A34A,
                                              ),
                                            ),
                                          );
                                        }
                                      },
                                      style: TextButton.styleFrom(
                                        padding: const EdgeInsets.symmetric(
                                          horizontal: 4,
                                        ),
                                        minimumSize: const Size(0, 48),
                                      ),
                                      child: Text(
                                        'Esqueceu a senha?',
                                        style: TextStyle(
                                          color: primaryColor,
                                          fontWeight: FontWeight.w700,
                                        ),
                                      ),
                                    ),
                                  ),
                                  const SizedBox(height: 18),
                                  SizedBox(
                                    width: double.infinity,
                                    height: 54,
                                    child: FilledButton.icon(
                                      onPressed: _carregando
                                          ? null
                                          : _fazerLogin,
                                      icon: AnimatedSwitcher(
                                        duration: const Duration(
                                          milliseconds: 180,
                                        ),
                                        child: _carregando
                                            ? const SizedBox(
                                                key: ValueKey('login-loading'),
                                                width: 19,
                                                height: 19,
                                                child:
                                                    CircularProgressIndicator(
                                                      strokeWidth: 2.2,
                                                      color: Colors.white,
                                                    ),
                                              )
                                            : Icon(
                                                key: const ValueKey(
                                                  'login-icon',
                                                ),
                                                _tipoUsuario == 'Cliente'
                                                    ? CupertinoIcons
                                                          .arrow_right_circle
                                                    : Icons
                                                          .local_shipping_rounded,
                                                color: Colors.white,
                                              ),
                                      ),
                                      label: AnimatedSwitcher(
                                        duration: const Duration(
                                          milliseconds: 180,
                                        ),
                                        child: Text(
                                          _carregando
                                              ? 'Entrando...'
                                              : 'Entrar como $_tipoUsuario',
                                          key: ValueKey(
                                            'login-label-$_carregando-$_tipoUsuario',
                                          ),
                                          style: const TextStyle(
                                            fontSize: 16,
                                            fontWeight: FontWeight.w800,
                                            color: Colors.white,
                                          ),
                                        ),
                                      ),
                                      style: FilledButton.styleFrom(
                                        backgroundColor: primaryColor,
                                        foregroundColor: Colors.white,
                                        elevation: 0,
                                        shadowColor: primaryColor.withValues(
                                          alpha: 0.26,
                                        ),
                                        shape: RoundedRectangleBorder(
                                          borderRadius: BorderRadius.circular(
                                            12,
                                          ),
                                        ),
                                      ),
                                    ),
                                  ),
                                  const SizedBox(height: 10),
                                  Center(
                                    child: TextButton.icon(
                                      onPressed: _configurarServidor,
                                      icon: const Icon(
                                        CupertinoIcons.slider_horizontal_3,
                                        size: 18,
                                      ),
                                      label: const Text(
                                        'Configurar servidor da API',
                                      ),
                                      style: TextButton.styleFrom(
                                        foregroundColor:
                                            scheme.onSurfaceVariant,
                                      ),
                                    ),
                                  ),
                                ],
                              ),
                            ),
                          ),
                          const SizedBox(height: 24),
                          Wrap(
                            alignment: WrapAlignment.center,
                            crossAxisAlignment: WrapCrossAlignment.center,
                            children: [
                              Text(
                                'Não tem uma conta?',
                                style: TextStyle(
                                  color: scheme.onSurfaceVariant,
                                ),
                              ),
                              TextButton(
                                onPressed: () {
                                  Navigator.push(
                                    context,
                                    MaterialPageRoute(
                                      builder: (_) => const CadastroScreen(),
                                    ),
                                  );
                                },
                                child: Text(
                                  'Cadastre-se',
                                  style: TextStyle(
                                    color: primaryColor,
                                    fontWeight: FontWeight.w800,
                                  ),
                                ),
                              ),
                            ],
                          ),
                          const SizedBox(height: 18),
                          const Text(
                            'Versão 1.0.0',
                            style: TextStyle(
                              color: Color(0xFF94A3B8),
                              fontSize: 12,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}
