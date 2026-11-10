# GeoSync Mobile

Aplicativo Flutter de apoio à operação logística do GeoSync. O app oferece áreas de cliente e motorista, consulta remessas e posições IoT, e mantém operações selecionadas disponíveis sem conexão para sincronizá-las quando a rede voltar.

Este aplicativo faz parte deste workspace em `App/geo_sync_mobile`. O backend Laravel correspondente está em [`../../GeoSync/`](../../GeoSync/); consulte também o [README geral](../../README.md).

## Recursos

### Cliente

- Login/cadastro, recuperação de senha, consulta e edição de perfil.
- Painel com início, remessas, mapa e alertas.
- Acompanhamento do status, destino e posição IoT associada à remessa.
- Temas claro e escuro e layout responsivo.

### Motorista

- Painel de entregas, consulta de remessas disponíveis e atualização de status.
- Mapa de entregas e consulta de posições de GPS do dispositivo IoT.
- Fluxos de comprovante de entrega com foto, horário, destinatário, assinatura e observação, e registro de ocorrências com categoria e foto opcional.
- Leitura/geração de QR Code de remessa, avisos, perfil, dados do veículo e documentos.
- Estimativa de chegada e sugestão offline de ordem de paradas; otimização geométrica é aproximada e não substitui navegação por ruas.
- Exportação de remessas e localizações em CSV ou GeoJSON.

### Sincronização e armazenamento

- Fila local de ações, cache, sincronização incremental e tratamento de conflitos.
- Armazenamento SQLite com payloads cifrados por AES-GCM em plataformas móveis compatíveis; a chave é guardada no armazenamento seguro do sistema.
- Exportação por salvar arquivo, download no navegador ou compartilhamento no dispositivo, conforme plataforma.
- Repositórios por domínio e contratos injetáveis para autenticação, sessão, sync, remessas, alertas, perfil, motorista, pagamentos e avaliações.

O aplicativo consulta localização fornecida pelo módulo IoT. Ele não solicita permissão de GPS do celular nos manifests/plists atuais.

## Plataformas e tecnologias

Flutter/Dart (`sdk: ^3.10.8`) para Android, iOS, Windows e Web. As dependências incluem `flutter_map`/`latlong2`, `http`, `flutter_secure_storage`, SQLite, `cryptography`, `image_picker`, `mobile_scanner`, `qr_flutter`, `share_plus` e `file_selector`. A disponibilidade de plugins e recursos varia por plataforma; valide o fluxo alvo antes de publicar.

## Requisitos e instalação

- Flutter SDK compatível com Dart `^3.10.8` (`flutter doctor` para verificar as ferramentas).
- Android Studio/SDK para Android; Xcode e macOS para compilar iOS; toolchain desktop apropriada para Windows.
- Backend Laravel acessível para login e operações remotas.

```bash
cd App/geo_sync_mobile
flutter pub get
```

## Configuração da API

A URL base precisa terminar em `/api`. Configure em tempo de execução:

```bash
flutter run --dart-define=API_BASE_URL=http://192.168.0.10:8000/api
```

Ou abra a opção **Configurar servidor da API** na tela de login; o valor será mantido no aparelho. Emulador Android normalmente usa `10.0.2.2` para alcançar o host local; um aparelho físico deve usar o IP da máquina na LAN.

Builds de produção exigem HTTPS. URLs HTTP são aceitas apenas em desenvolvimento/rede local de acordo com as configurações da plataforma. Nunca embuta chaves privadas Google ou credenciais de produção no app.

## Contrato e integração com o backend

O arquivo [`openapi.yaml`](openapi.yaml) descreve o contrato mobile previsto e serve como referência ao cliente. O Laravel deste workspace define as rotas implementadas em [`../../GeoSync/routes/api.php`](../../GeoSync/routes/api.php). O contrato do app é mais amplo que o backend atual, portanto algumas telas/ações podem precisar das rotas correspondentes antes de funcionarem ponta a ponta.

| Área | Rotas Laravel presentes |
| --- | --- |
| Autenticação e perfil | `POST auth/register`, `POST auth/login`, `GET auth/me`, `POST auth/logout`, `PUT perfil` |
| Remessas | `GET remessas/minhas`, `GET remessas/disponiveis`, `POST remessas/{id}/aceitar`, `PATCH remessas/{id}/status` e API Resource `/remessas` |
| Posição IoT | `POST localizacao`, `GET localizacao`, `GET localizacao/remessa/{id}`, `GET localizacao/remessa/{id}/ultima` |
| Alertas, pagamentos, avaliações | API Resource `/alertas`; `GET/POST pagamentos`, `GET pagamentos/{id}`, `GET/POST avaliacoes`, `GET avaliacoes/resumo` |
| Estimativa de rota | `POST rotas/estimativa`, autenticada; requer `GOOGLE_ROUTES_API_KEY` no servidor |

As demais operações descritas pelo app — por exemplo `auth/forgot-password`, login Google mobile, histórico por endpoint de remessa, avisos/documentos de motorista, upload de fotos, comprovantes e ocorrências — não estão todas expostas no `routes/api.php` atual. O comportamento pode ficar limitado a dados em cache ou a falha de integração até que o backend implemente o endpoint correspondente. O cadastro via API aceita cliente e motorista; criação de administrador é restrita ao fluxo administrativo web.

Rotas protegidas exigem `Authorization: Bearer <token>` e `Accept: application/json`. O logout revoga o token usado. Ao abrir, o app valida a sessão online; em indisponibilidade de rede pode manter o estado local conforme regras de sessão.

## Executar e compilar

```bash
# Execução em desenvolvimento
flutter run --dart-define=API_BASE_URL=http://10.0.2.2:8000/api

# Verificar/analisar
flutter analyze
flutter test

# Build Android
flutter build apk --release
flutter build appbundle --release

# iOS (em macOS com Xcode configurado)
flutter build ipa --release
```

Para Windows/Web, use `flutter run -d windows` ou `flutter run -d chrome` com a plataforma habilitada no SDK. Configuração de assinatura Android, identificador do app e checklist de publicação devem ser revisados antes de distribuir releases.

## Testes

`flutter test` executa testes unitários, de widget e testes de integração com servidor HTTP fake que fazem parte do projeto. `flutter test integration_test` executa os testes de ponta a ponta em dispositivo/emulador configurado. A cobertura inclui autenticação/sessão, sync e conflitos, repositórios, responsividade/acessibilidade, telas de perfil/veículo/exportação e otimização aproximada de rotas.

Documentos de operação: [`docs/RELEASE_CHECKLIST.md`](docs/RELEASE_CHECKLIST.md), [`docs/google-sign-in.md`](docs/google-sign-in.md), [`docs/push-notifications.md`](docs/push-notifications.md) e [`docs/device-validation.md`](docs/device-validation.md).

## Segurança e privacidade

- Trate localização de entrega e imagens como dados pessoais; restrinja acesso, retenção e exportação conforme a política do projeto e a LGPD.
- Tokens de sessão ficam em `flutter_secure_storage` nas plataformas suportadas. Tokens antigos podem ser migrados do armazenamento legado.
- Repositórios locais cifram payloads de sync; perda da chave segura pode tornar dados cifrados indisponíveis.
- O app oculta detalhes internos de erros HTTP e evita registrar tokens/query strings nos logs.
- O endpoint Laravel usado pelo ESP32 (`POST /api/localizacao`) é público hoje. Essa configuração e o transporte HTTP no sketch são inadequados para exposição pública sem controles adicionais no servidor.

## Estrutura principal

```text
lib/
├── main.dart, app_session.dart, app_theme.dart
├── login_screen.dart, cadastro_screen.dart, tela_dashboard.dart
├── core/         # Contratos e repositórios por domínio
├── motorista/    # Painel e fluxos do motorista
├── services/     # API e serviços de aplicação
├── sync/         # Fila, cache, conflitos, sync e exportação
└── widgets/      # Componentes compartilhados
test/             # Testes unitários, widget e integração HTTP fake
integration_test/ # Testes de fluxo em dispositivo/emulador
```

## Créditos

Aplicativo desenvolvido por [Maria Clara Luz](https://github.com/mariaclaraluz0) como parte do GeoSync.
