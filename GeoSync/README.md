# GeoSync — backend e painel web

Backend Laravel 12 que sustenta a plataforma GeoSync: regras de logística, API JSON para o aplicativo Flutter e o ESP32, persistência MySQL e interfaces web para clientes, motoristas e administradores.

## Funcionalidades

- Cadastro e login web/API; tokens Bearer por Laravel Sanctum na API e autenticação Google via Socialite na web.
- Perfis de cliente, motorista e administrador, com rotas e operações limitadas pelo tipo de conta.
- Cadastro, consulta, edição e exclusão de remessas; motoristas consultam cargas disponíveis, aceitam entregas e atualizam status.
- Rastreamento por remessa, histórico de posições e cálculo de distância até as coordenadas de destino.
- Geocodificação de endereço e estimativa de rota com Google Routes API, incluindo cache de curta duração.
- Alertas, pagamentos, avaliações, formulário de contato, atualização de perfil/senha e rotas de administração.
- Interface web com páginas públicas, painéis por perfil, chat operacional e ferramenta antifraude.
- Notificação por e-mail ao cliente quando uma localização recebida fica a até 100 m do destino; um aviso é emitido por remessa.

## Tecnologias

| Camada | Tecnologia |
| --- | --- |
| Backend | PHP 8.2+, Laravel 12 |
| Autenticação API | Laravel Sanctum |
| Login social web | Laravel Socialite (Google) |
| Interface e assets | Blade, Vite, Tailwind CSS 4, JavaScript |
| Banco padrão do projeto | MySQL (`TCC_GeoSync` no `.env.example`) |
| Filas, cache e sessão | Laravel; configuração padrão baseada em banco de dados |
| Testes/estilo | PHPUnit 11, Laravel Pint |

## Requisitos

- PHP 8.2 ou superior com extensões exigidas pelo Laravel e pelo driver do banco.
- Composer 2, Node.js e npm.
- MySQL disponível, ou outro driver configurado e compatível com as migrations.

## Instalação local

Na raiz deste diretório (`GeoSync/`):

```bash
composer install
cp .env.example .env
php artisan key:generate
```

No PowerShell, substitua o comando de cópia por `Copy-Item .env.example .env`.

Crie um banco vazio e configure `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD` no `.env`. Em seguida:

```bash
php artisan migrate
npm install
npm run build
composer run dev
```

O comando de desenvolvimento inicia `php artisan serve`, worker da fila, logs via Pail e Vite. A aplicação web estará em `http://localhost:8000`. Para executar somente o servidor, use `php artisan serve`; para processar filas em separado, use `php artisan queue:listen`.

O script `composer run setup` automatiza instalação de dependências, criação do `.env`, geração da chave, migrations e build de assets. Confira o script antes de usá-lo em ambientes onde as migrations não devam ser aplicadas automaticamente.

## Configuração

As variáveis iniciais estão em [`.env.example`](.env.example). Além do banco e da chave `APP_KEY`, revise:

| Variável | Uso |
| --- | --- |
| `APP_URL`, `APP_ENV`, `APP_DEBUG` | URL e ambiente Laravel. Em produção use HTTPS e `APP_DEBUG=false`. |
| `DB_*` | Conexão com o banco. O exemplo usa MySQL e `TCC_GeoSync`. |
| `QUEUE_CONNECTION` | Driver das filas; o exemplo usa `database`. Mantenha um worker ativo se houver jobs pendentes. |
| `MAIL_*` | Entrega de notificações. `MAIL_MAILER=log` registra a mensagem localmente, sem enviá-la. |
| `GOOGLE_MAPS_API_KEY` | Chave usada pelo serviço de geocodificação, quando habilitado. |
| `GOOGLE_ROUTES_API_KEY` | Chave privada do servidor para estimativa de rotas viárias. Não incluir no app Flutter. |
| `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI` | Credenciais/callback para login Google web, conforme configuração em `config/services.php`. |

Configure um provedor SMTP para entrega de e-mail. Depois de mudar configuração, aplique `php artisan config:clear` no ambiente local ou regenere o cache de configuração no deploy.

## API REST

Todas as rotas abaixo recebem o prefixo `/api`. Rotas sob `auth:sanctum` exigem `Authorization: Bearer <token>` e `Accept: application/json`.

| Método | Caminho | Acesso | Operação |
| --- | --- | --- | --- |
| `POST` | `/auth/register` | Público | Registra cliente ou motorista e retorna token. |
| `POST` | `/auth/login` | Público | Autentica e retorna token Bearer. |
| `GET` | `/auth/me` | Token | Retorna o usuário da sessão. |
| `POST` | `/auth/logout` | Token | Revoga o token atual. |
| `PUT` | `/perfil` | Token | Atualiza dados do perfil. |
| `POST` | `/contatos` | Público | Recebe uma mensagem de contato. |
| `GET` | `/avaliacoes` | Público | Lista avaliações. |
| `GET` | `/avaliacoes/resumo` | Público | Retorna o resumo agregado das avaliações. |
| `POST` | `/avaliacoes` | Token | Registra avaliação. |
| `GET` | `/remessas/minhas` | Token | Lista remessas relacionadas ao usuário. |
| `GET` | `/remessas/disponiveis` | Token | Lista remessas disponíveis para motoristas. |
| `POST` | `/remessas/{id}/aceitar` | Token, motorista | Aceita uma remessa disponível. |
| `PATCH` | `/remessas/{id}/status` | Token, motorista/admin | Atualiza o status conforme permissões. |
| `GET, POST, PUT/PATCH, DELETE` | `/remessas[/{id}]` | Token | API Resource de remessas; criação/alteração respeita o tipo e a propriedade da remessa. |
| `GET, POST, PUT/PATCH, DELETE` | `/alertas[/{id}]` | Token | API Resource de alertas. |
| `GET` | `/pagamentos` | Token | Lista pagamentos acessíveis. |
| `POST` | `/pagamentos` | Token | Cria pagamento. |
| `GET` | `/pagamentos/{id}` | Token | Consulta pagamento. |
| `POST` | `/localizacao` | Público (dispositivo) | Registra latitude, longitude e `remessa_id`. |
| `GET` | `/localizacao` | Público | Lista localizações conforme a implementação do controller. |
| `GET` | `/localizacao/remessa/{id}` | Público | Consulta histórico de posições da remessa. |
| `GET` | `/localizacao/remessa/{id}/ultima` | Público | Consulta a última posição da remessa. |
| `POST` | `/rotas/estimativa` | Token, limite 20/min | Consulta distância e duração pela Google Routes API. |

### Exemplos

Login:

```http
POST /api/auth/login
Content-Type: application/json
Accept: application/json

{"email":"cliente@example.com","password":"senha"}
```

A resposta inclui `token`, `token_type: Bearer` e `data` com o usuário. Para endpoints autenticados, envie o token no header Authorization.

Ingestão de GPS pelo ESP32:

```http
POST /api/localizacao
Content-Type: application/json
Accept: application/json

{"latitude":-23.5505,"longitude":-46.6333,"remessa_id":1,"fonte":"esp32_gps"}
```

`latitude`, `longitude` e `remessa_id` são validados; as coordenadas devem estar dentro dos limites geográficos e a remessa precisa existir. O campo `fonte` enviado pelo firmware identifica a origem do ponto quando aceito pela versão atual do esquema/controller. A rota de localização não exige Sanctum, pois é usada pelo firmware de exemplo; restrinja acesso à rede/servidor e use HTTPS em implantação pública.

Estimativa de rota:

```json
{
  "origin": {"latitude": -23.55, "longitude": -46.63},
  "destination": {"latitude": -23.56, "longitude": -46.64}
}
```

O resultado contém `data.distance_km`, `data.duration_minutes` e `cached`. Sem chave Google configurada, o serviço responde `503`; falhas externas podem resultar em `502`.

Para confirmar rotas no ambiente instalado: `php artisan route:list --path=api`.

## Banco de dados

As migrations em [`database/migrations/`](database/migrations/) criam usuários, tokens, filas/cache e entidades de domínio como remessas, localizações, pagamentos, alertas, contatos e avaliações. Execute `php artisan migrate` para instalar/atualizar o esquema. O dump [`geosync.sql`](geosync.sql) e a cópia em [`../Banco de Dados/geosync.sql`](../Banco%20de%20Dados/geosync.sql) são exportações do banco; confira se estão alinhadas às migrations antes de usá-las como fonte de uma nova instalação.

Para checar o esquema esperado pelo script incluído:

```bash
php schema_check.php
```

O destino pode ser informado por variáveis de ambiente conforme o script; sem configuração, revise o próprio `schema_check.php` antes da execução.

## Firmware IoT

O ESP32 com módulo GPS UART usa Arduino C++, TinyGPS++, WiFi, HTTPClient e ArduinoJson. Ele envia a coordenada atual a cada cinco segundos para `POST /api/localizacao`, vinculada ao `remessa_id` configurado no sketch. Instruções de fiação, configuração e limites estão em [`iot/README.md`](iot/README.md).

## Aplicativo Flutter

O cliente mobile fica no repositório deste workspace em [`../App/geo_sync_mobile/`](../App/geo_sync_mobile/). O README do aplicativo explica recursos, configuração da URL base e o contrato mobile. Algumas operações detalhadas pelo app (como ocorrências, comprovantes, documentos de motorista e notificações móveis) não aparecem nas rotas Laravel atuais; consulte o guia mobile para identificar esse estado de integração.

## Testes e qualidade

```bash
composer run test
./vendor/bin/pint --test
```

Para formatar arquivos PHP com Pint, execute `./vendor/bin/pint`. Os testes estão em `tests/Feature` e `tests/Unit`.

## Produção

- Defina `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` HTTPS e credenciais de produção fora do repositório.
- Instale dependências com `composer install --no-dev --optimize-autoloader` e compile assets com `npm ci && npm run build`.
- Aplique migrations com `php artisan migrate --force` após backup do banco.
- Configure worker de fila sob Supervisor/systemd, SMTP e cache/configuração/rotas conforme o servidor.
- Proteja a ingestão IoT e prefira HTTPS. Restrinja as chaves de mapas e nunca exponha `GOOGLE_ROUTES_API_KEY` no cliente.

## Privacidade e segurança

Localizações são dados potencialmente pessoais. Restrinja acesso às remessas por perfil, proteja as credenciais e os tokens, habilite HTTPS e defina política de retenção adequada ao uso e à LGPD. O endpoint público de GPS não autentica o dispositivo atualmente; uma implantação real deve protegê-lo contra envio não autorizado.

## Licença e autoria

Consulte os termos definidos na raiz do repositório e a documentação acadêmica. O projeto é desenvolvido por Murilo Breda e Maria Clara Luz.
