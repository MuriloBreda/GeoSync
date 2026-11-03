import 'package:flutter/cupertino.dart' show CupertinoIcons;
import 'package:flutter/material.dart';
import 'package:mobile/services/api_exception.dart';
import 'package:mobile/services/api_service.dart';
import 'package:mobile/widgets/responsive_content.dart';

/// Solicita ao servidor o envio do link de redefinição de senha.
///
/// A resposta é a mesma para e-mails cadastrados ou não, para não revelar
/// quais contas existem. Fecha com `true` quando o pedido foi aceito.
class EsqueceuSenhaPage extends StatefulWidget {
  const EsqueceuSenhaPage({super.key, this.emailInicial = ''});

  final String emailInicial;

  @override
  State<EsqueceuSenhaPage> createState() => _EsqueceuSenhaPageState();
}

class _EsqueceuSenhaPageState extends State<EsqueceuSenhaPage> {
  final _formKey = GlobalKey<FormState>();
  late final TextEditingController _email;
  bool _enviando = false;

  @override
  void initState() {
    super.initState();
    _email = TextEditingController(text: widget.emailInicial);
  }

  @override
  void dispose() {
    _email.dispose();
    super.dispose();
  }

  Future<void> _enviarLink() async {
    if (_enviando || !_formKey.currentState!.validate()) return;
    setState(() => _enviando = true);
    try {
      await ApiService.instance.esqueciSenha(_email.text);
      if (mounted) Navigator.pop(context, true);
    } on ApiException catch (error) {
      if (!mounted) return;
      // 404/422 indicam e-mail não cadastrado; respondemos como sucesso
      // para não revelar quais contas existem.
      if (error.statusCode == 404 || error.statusCode == 422) {
        Navigator.pop(context, true);
        return;
      }
      setState(() => _enviando = false);
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text(error.message)));
    }
  }

  @override
  Widget build(BuildContext context) {
    final cores = Theme.of(context).colorScheme;
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      body: Stack(
        children: [
          Container(
            height: 220,
            decoration: const BoxDecoration(
              gradient: LinearGradient(
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
                colors: [Color(0xFF0F172A), Color(0xFF1D4ED8)],
              ),
              borderRadius: BorderRadius.only(
                bottomLeft: Radius.circular(30),
                bottomRight: Radius.circular(30),
              ),
            ),
          ),
          SafeArea(
            child: ResponsiveContent(
              maxWidth: 520,
              child: SingleChildScrollView(
                padding: const EdgeInsets.fromLTRB(20, 18, 20, 28),
                child: Form(
                  key: _formKey,
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.stretch,
                    children: [
                      IconButton(
                        onPressed: () => Navigator.pop(context),
                        icon: const Icon(CupertinoIcons.chevron_left, color: Colors.white),
                        padding: EdgeInsets.zero,
                        alignment: Alignment.centerLeft,
                        tooltip: 'Voltar',
                      ),
                      const SizedBox(height: 18),
                      Align(
                        alignment: Alignment.center,
                        child: Container(
                          width: 72,
                          height: 72,
                          decoration: BoxDecoration(
                            color: Colors.white,
                            shape: BoxShape.circle,
                            boxShadow: [
                              BoxShadow(
                                color: Colors.black.withValues(alpha: 0.12),
                                blurRadius: 18,
                                offset: const Offset(0, 8),
                              ),
                            ],
                          ),
                          child: Icon(
                            CupertinoIcons.lock_rotation,
                            size: 34,
                            color: cores.primary,
                          ),
                        ),
                      ),
                      const SizedBox(height: 20),
                      Text(
                        'Esqueceu a senha?',
                        textAlign: TextAlign.center,
                        style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                          fontWeight: FontWeight.w800,
                          color: Colors.white,
                        ),
                      ),
                      const SizedBox(height: 8),
                      Text(
                        'Informe o e-mail cadastrado para receber o link de recuperação.',
                        textAlign: TextAlign.center,
                        style: TextStyle(
                          color: Colors.white.withValues(alpha: 0.82),
                          fontSize: 15,
                        ),
                      ),
                      const SizedBox(height: 28),
                      Container(
                        padding: const EdgeInsets.all(22),
                        decoration: BoxDecoration(
                          color: cores.surface,
                          borderRadius: BorderRadius.circular(28),
                          border: Border.all(
                            color: cores.outlineVariant.withValues(alpha: 0.7),
                          ),
                          boxShadow: [
                            BoxShadow(
                              color: Colors.black.withValues(alpha: 0.05),
                              blurRadius: 20,
                              offset: const Offset(0, 10),
                            ),
                          ],
                        ),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.stretch,
                          children: [
                            TextFormField(
                              controller: _email,
                              enabled: !_enviando,
                              keyboardType: TextInputType.emailAddress,
                              autofillHints: const [AutofillHints.email],
                              textInputAction: TextInputAction.done,
                              onFieldSubmitted: (_) => _enviarLink(),
                              decoration: InputDecoration(
                                labelText: 'E-mail cadastrado',
                                hintText: 'seu@email.com',
                                prefixIcon: const Icon(CupertinoIcons.envelope),
                                filled: true,
                                fillColor: cores.surfaceContainer,
                                border: OutlineInputBorder(
                                  borderRadius: BorderRadius.circular(16),
                                  borderSide: BorderSide.none,
                                ),
                                enabledBorder: OutlineInputBorder(
                                  borderRadius: BorderRadius.circular(16),
                                  borderSide: BorderSide(
                                    color: cores.outlineVariant,
                                  ),
                                ),
                                focusedBorder: OutlineInputBorder(
                                  borderRadius: BorderRadius.circular(16),
                                  borderSide: BorderSide(
                                    color: cores.primary,
                                    width: 2,
                                  ),
                                ),
                              ),
                              validator: (valor) {
                                final email = valor?.trim() ?? '';
                                return RegExp(
                                      r'^[^@\s]+@[^@\s]+\.[^@\s]+$',
                                    ).hasMatch(email)
                                    ? null
                                    : 'Informe um e-mail válido';
                              },
                            ),
                            const SizedBox(height: 24),
                            FilledButton(
                              onPressed: _enviando ? null : _enviarLink,
                              style: FilledButton.styleFrom(
                                minimumSize: const Size.fromHeight(54),
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(16),
                                ),
                              ),
                              child: _enviando
                                  ? const SizedBox.square(
                                      dimension: 22,
                                      child: CircularProgressIndicator(strokeWidth: 2.5),
                                    )
                                  : const Text('Enviar link de redefinição'),
                            ),
                          ],
                        ),
                      ),
                    ],
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
