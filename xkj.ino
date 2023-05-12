#include <WiFi.h>
#include <HTTPClient.h>
#include <Wire.h>
#include <Adafruit_Sensor.h>
#include <DHT.h>

#define DHTPIN 15      // DHT22传感器连接到ESP32的引脚
#define DHTTYPE DHT22   // DHT 22  (AM2302)

const char* ssid = "6412"; // WiFi名称
const char* password = "20020920"; // WiFi密码
const char* serverName = "http://topic.paki91.com/xkj/post_index.php"; // PHP文件的URL

DHT dht(DHTPIN, DHTTYPE); 

void setup() {
  Serial.begin(9600);
  delay(1000);
  WiFi.begin(ssid, password); // 连接到WiFi
  
    while (WiFi.status() != WL_CONNECTED) { // 等待连接
    delay(1000);
    Serial.println("Connecting to WiFi...");}
    Serial.println("Connected to WiFi");
  
  dht.begin(); // 初始化DHT22传感器
}

void loop() {
  float temperature = dht.readTemperature(); // 读取温度
  float humidity = dht.readHumidity(); // 读取湿度
  
  if (isnan(temperature) || isnan(humidity)) { // 如果读取失败
    Serial.println("Failed to read from DHT sensor!");
    return;
  }
  
  // 发送POST请求
  HTTPClient http;
  http.begin(serverName); // 设置请求URL
  http.addHeader("Content-Type", "application/x-www-form-urlencoded"); // 设置请求头
  String postData = "sensor=" + String("DHT22") + "&location=" + String("Home") + "&temperature=" + String(temperature) + "&humidity=" + String(humidity);
int httpResponseCode = http.POST(postData); // 发送POST请求
  if (httpResponseCode > 0) {
    Serial.println("Data sent successfully");
  } else {
    Serial.println("Error sending data");
  }
  http.end();
  
  delay(5000); // 间隔5秒
}
