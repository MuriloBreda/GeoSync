# GPS do ESP32

1. Execute `php artisan migrate` antes de ligar o dispositivo. A remessa precisa ter latitude e longitude de destino, geradas no cadastro administrativo.
2. No arquivo `geosync_gps.ino`, informe o Wi-Fi e o ID real da remessa transportada.
3. Inicie o Laravel em uma interface acessível ao ESP32: `php artisan serve --host=0.0.0.0 --port=8000`.
4. Ajuste `serverName` para o IP LAN do computador, sem Markdown. Exemplo: `http://192.168.1.20:8000/api/localizacao`.

O endpoint devolve `proximidade_destino` com a distância calculada. Ao receber um ponto a até 100 m do destino, o servidor cria um alerta e envia um único e-mail ao cliente da remessa.

## E-mail

O padrão do Laravel neste projeto é `MAIL_MAILER=log`, que registra o e-mail no log e não o entrega. Para envio real, configure no `.env` um provedor SMTP, por exemplo:

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

Depois execute `php artisan config:clear`.
