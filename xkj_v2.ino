#include <WiFi.h>
#include <HTTPClient.h>
#include <Wire.h>
#include <Adafruit_Sensor.h>
#include <DHT.h>

#include <eHaJo_LM75.h>

#define DHTPIN 15      // DHT22传感器连接到ESP32的引脚
#define DHTTYPE DHT22   // DHT 22  (AM2302)

const char* ssid = "6412"; // WiFi名称
const char* password = "20020920"; // WiFi密码
const char* serverName = "http://topic.paki91.com/xkj/post_index.php"; // PHP文件的URL

DHT dht(DHTPIN, DHTTYPE); 

EHAJO_LM75 tempsensor;

void setup() {
  while(!Serial) {}
  Serial.begin(9600);
  delay(1000);
  WiFi.begin(ssid, password); // 连接到WiFi
  
    while (WiFi.status() != WL_CONNECTED) { // 等待连接
    delay(1000);
    Serial.println("Connecting to WiFi...");}
    Serial.println("Connected to WiFi");
  
  dht.begin(); // 初始化DHT22传感器
  Wire.begin();  // start I2C-stuff
}

void loop() {
  float lm75_temp = tempsensor.getTemp();
  float dht22_temp = dht.readTemperature(); // 读取温度
  float dht22_humd = dht.readHumidity(); // 读取湿度
  
  Serial.print("lm75_temp = ");
  Serial.println(lm75_temp);
  Serial.println(dht22_temp);
  Serial.println(dht22_humd);
  
  HTTPClient http;
  http.begin(serverName); // 设置请求URL
  http.addHeader("Content-Type", "application/x-www-form-urlencoded"); // 设置请求头
  String postData = "lm75_temp=" + String(lm75_temp) + "&dht22_temp=" + String(dht22_temp)+ "&dht22_humd=" + String(dht22_humd);
  int httpResponseCode = http.POST(postData); // 发送POST请求
  
  if (httpResponseCode > 0) {
    Serial.println("Data sent successfully");
  } else {
    Serial.println("Error sending data");
  }
  http.end();

  

  delay(30000);
}
