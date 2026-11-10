# Firmware GPS para ESP32

O sketch [`geosync_gps.ino`](geosync_gps.ino) lê coordenadas de um receptor GPS conectado à UART2 do ESP32 e envia pontos para o backend GeoSync por Wi-Fi e HTTP/JSON. Cada ponto fica associado a uma remessa; o backend usa os dados para atualizar o rastreamento e verificar a proximidade do destino.

## Hardware e software

- Placa ESP32 compatível com Arduino.
- Receptor GPS serial que emita NMEA a 9600 baud.
- Arduino IDE ou PlatformIO com suporte ESP32.
- Bibliotecas `TinyGPS++` e `ArduinoJson` instaladas.
- Backend GeoSync acessível a partir da mesma rede do dispositivo.

### Ligações do GPS

O código configura `GPS.begin(9600, SERIAL_8N1, 16, 17)`: RX do ESP32 no GPIO 16 e TX no GPIO 17.

| GPS | ESP32 |
| --- | --- |
| TX | RX2 / GPIO 16 |
| RX | TX2 / GPIO 17 |
| GND | GND |
| VCC | Alimentação compatível com o módulo GPS |

Confira os níveis de tensão e a alimentação exigidos pela placa GPS antes de conectar.

## Configuração

Edite a cópia local do sketch:

```cpp
const char* ssid = "NOME_DA_REDE";
const char* password = "SENHA_DA_REDE";
const char* serverName = "http://IP_DO_SERVIDOR:8000/api/localizacao";
const int remessaId = 1;
```

Use o IP LAN do computador que executa o Laravel, não `localhost`. O ID precisa corresponder ao ID numérico de uma remessa existente no banco. Para permitir conexões de outros dispositivos da rede, inicie o backend assim:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Não versione SSID, senha ou credenciais reais. HTTP é adequado apenas para teste em rede controlada; em produção use HTTPS e proteja/autentique o dispositivo. A rota atual de ingestão (`POST /api/localizacao`) não exige token de API.

## Envio de dados

O firmware tenta conectar ao Wi-Fi por até 15 segundos e envia uma posição GPS válida e atualizada a cada 5 segundos. O JSON inclui latitude, longitude, `remessa_id` e `fonte` (`esp32_gps`). O endpoint valida coordenadas e existência da remessa, persiste o ponto e avalia a distância ao destino. Quando o veículo chega a até 100 m, o backend cria alerta e dispara uma notificação por e-mail ao cliente, uma vez por remessa.

Para testar, monitore o Serial Monitor em 115200 baud. O sketch informa estado do Wi-Fi, código HTTP e resposta da API. Se nenhum dado GPS for recebido, confira alimentação, fiação RX/TX, baud rate e visibilidade do céu.

## E-mail de proximidade

O exemplo do Laravel usa `MAIL_MAILER=log`, que registra o conteúdo no log sem entregar mensagem. Para envio real, configure um SMTP no `.env` do backend:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.seu-provedor.com
MAIL_PORT=587
MAIL_USERNAME=seu_usuario
MAIL_PASSWORD=sua_senha_ou_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=notificacoes@seu-dominio.com
MAIL_FROM_NAME="GeoSync"
```

Depois de alterar a configuração, execute `php artisan config:clear`.

## Limitações conhecidas

- O sketch não mantém fila local de posições enquanto está sem Wi-Fi; pontos perdidos durante a desconexão não são reenviados.
- O intervalo configurado é de cinco segundos, quando há atualização GPS válida.
- O dispositivo identifica a remessa por ID fixo no firmware. Configure o ID correto ao trocar a carga.
- O endpoint não autentica o dispositivo. Para ambientes externos, implemente autenticação, HTTPS e controles contra abuso antes de publicar o serviço.
