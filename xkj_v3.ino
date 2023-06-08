#include <WiFi.h>
#include <HTTPClient.h>
#include <Wire.h>
#include <Adafruit_Sensor.h>
#include <DHT.h>
#include <eHaJo_LM75.h>

#define DHTPIN 15
#define DHTTYPE DHT22

const char* ssid = "6412";
const char* password = "20020920";
const char* serverName = "http://topic.paki91.com/xkj/post_index.php";

DHT dht(DHTPIN, DHTTYPE);
EHAJO_LM75 tempsensor;

void setup() {
  Serial.begin(9600);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");
  dht.begin();
  Wire.begin();
}

void loop() {
  float lm75_temp = tempsensor.getTemp();
  float dht22_temp = dht.readTemperature();
  float dht22_humd = dht.readHumidity();
  
  Serial.print("lm75_temp = ");
  Serial.println(lm75_temp);
  Serial.println(dht22_temp);
  Serial.println(dht22_humd);
  
  HTTPClient http;
  http.begin(serverName);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  String postData = "lm75_temp=" + String(lm75_temp) + "&dht22_temp=" + String(dht22_temp) + "&dht22_humd=" + String(dht22_humd);
  int httpResponseCode = http.POST(postData);
  
  if (httpResponseCode > 0) {
    Serial.println("Data sent successfully");
  } else {
    Serial.println("Error sending data");
  }
  http.end();

  delay(30000);
}
