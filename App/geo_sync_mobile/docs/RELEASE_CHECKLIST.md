# Checklist de preparação para publicação

## Backend e credenciais

- Configure `GOOGLE_ROUTES_API_KEY` apenas no `.env` do Laravel; habilite a
  Routes API, faturamento e alertas de quota no Google Cloud.
- Restrinja essa chave à Routes API e, quando possível, ao IP público do servidor;
  após alterar `.env`, limpe/recrie o cache de configuração do Laravel.
- Confirme que `/api/rotas/estimativa` exige Sanctum e aplica limite de uso.
- Configure `API_BASE_URL` para um host HTTPS de produção e revise certificados.
- Não registre coordenadas, tokens, fotos ou assinaturas em logs de produção.
- Informe na política de privacidade que as coordenadas da remessa são usadas
  para estimar rotas e enviadas ao Google pelo backend.

## Android

- Defina o identificador final do aplicativo antes da publicação:
  `-PgeoSyncApplicationId=br.com.suaorganizacao.geosync`.
- Configure assinatura de release em `android/key.properties` fora do controle
  de versão; nunca publique esse arquivo ou o keystore.
- Gere e instale um bundle de release:

  ```powershell
  flutter build appbundle --release `
    --dart-define=API_BASE_URL=https://api.exemplo.com/api `
    -PgeoSyncApplicationId=br.com.suaorganizacao.geosync
  ```

- Verifique o nome “Geo Sync Mobile”, ícone, permissões e fluxo de atualização.

## iOS

- Defina o Bundle Identifier definitivo no projeto Runner e configure signing e
  provisioning profile no Xcode.
- Gere um Archive em macOS; a etapa de assinatura e envio não pode ser validada
  neste ambiente Windows.
- Confirme os textos de uso da câmera e da galeria apresentados pelo iOS.

## Validação antes de enviar às lojas

- Rode `flutter analyze` e `flutter test`.
- Siga a lista em `docs/VALIDACAO_CAMPO.md` em pelo menos um Android e um iPhone.
- Teste a aplicação sem chave Google: a ETA deve continuar com fallback e sem
  impedir o fluxo de entrega.
- Revise versão/build em `pubspec.yaml`, capturas de tela, política de
  privacidade e instruções de suporte.
