#include <TinyGPS++.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

TinyGPSPlus gps;
HardwareSerial GPS(2);

// Não versione as credenciais reais. Preencha somente na cópia gravada no ESP32.
const char* ssid = "SEU_WIFI";
const char* password = "SUA_SENHA";

// Use o IP LAN do computador que executa `php artisan serve --host=0.0.0.0`.
// Não use Markdown, por exemplo: http://10.141.130.88:8000/api/localizacao
const char* serverName = "http://10.141.130.88:8000/api/localizacao";
const int remessaId = 1; // Altere para o ID da remessa transportada por este veículo.

unsigned long ultimoEnvio = 0;
const unsigned long intervaloEnvio = 5000;

void conectarWifi() {
  if (WiFi.status() == WL_CONNECTED) return;

  WiFi.disconnect();
  WiFi.begin(ssid, password);
  Serial.print("Conectando ao WiFi");
  const unsigned long inicio = millis();
  while (WiFi.status() != WL_CONNECTED && millis() - inicio < 15000) {
    delay(500);
    Serial.print('.');
  }
  Serial.println();
}

void enviarDados(double latitude, double longitude) {
  conectarWifi();
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("WiFi desconectado; GPS não enviado.");
    return;
  }

  HTTPClient http;
  http.setTimeout(10000);
  http.begin(serverName);
  http.addHeader("Content-Type", "application/json");
  http.addHeader("Accept", "application/json");

  JsonDocument doc;
  doc["latitude"] = latitude;
  doc["longitude"] = longitude;
  doc["remessa_id"] = remessaId;
  doc["fonte"] = "esp32_gps";

  String json;
  serializeJson(doc, json);
  const int codigoHttp = http.POST(json);
  Serial.printf("HTTP: %d\n", codigoHttp);
  Serial.println(codigoHttp > 0 ? http.getString() : "Falha ao enviar para a API.");
  http.end();
}

void setup() {
  Serial.begin(115200);
  GPS.begin(9600, SERIAL_8N1, 16, 17); // ESP32 RX=16, TX=17
  conectarWifi();
  Serial.println("Aguardando sinal GPS...");
}

void loop() {
  while (GPS.available()) gps.encode(GPS.read());

  if (gps.location.isValid() && gps.location.isUpdated() && millis() - ultimoEnvio >= intervaloEnvio) {
    enviarDados(gps.location.lat(), gps.location.lng());
    ultimoEnvio = millis();
  }

  if (millis() > 5000 && gps.charsProcessed() < 10) {
    Serial.println("Nenhum dado recebido do GPS. Verifique RX/TX e alimentação.");
    delay(1000);
  }
}
