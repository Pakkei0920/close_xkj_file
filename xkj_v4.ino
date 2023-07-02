//包括pms5003+dht22post功能
#include <PMS.h>
#include <HTTPClient.h>
#include <Wire.h>
#include <Adafruit_Sensor.h>
#include <DHT.h>

const char* ssid = "6412";
const char* password = "20020920";
const char* serverName = "http://topic.paki91.com/xkj/post_index.php";

DHT dht(15, DHT22);//pin15
PMS pms(Serial1);
PMS::DATA data;

void setup()
{
  Serial.begin(9600);
  
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000); Serial.println("Connecting to WiFi...");
  }
    Serial.println("WiFi OK");
    dht.begin();
    Wire.begin(); //i2c通訊
    Serial1.begin(9600, SERIAL_8N1, 16, 17); //pms5003
}

void loop()
{
if (pms.read(data))
  {
    float pm1 = data.PM_AE_UG_1_0;
    float pm25 = data.PM_AE_UG_2_5;
    float pm100 = data.PM_AE_UG_10_0;
    
    Serial.print("PM 1.0(ug/m3): ");Serial.println(pm1);
    Serial.print("PM 2.5(ug/m3): ");Serial.println(pm25);
    Serial.print("PM 10.0(ug/m3): ");Serial.println(pm100);

    float dht22_temp = dht.readTemperature(); Serial.println(dht22_temp);
    float dht22_humd = dht.readHumidity(); Serial.println(dht22_humd);
  

   HTTPClient http;
   http.begin(serverName);
   http.addHeader("Content-Type", "application/x-www-form-urlencoded");
   
   String postData =    "dht22_temp=" + String(dht22_temp) + 
                        "&dht22_humd=" + String(dht22_humd)+
                        "&pms_pm1=" + String(pm1)+
                        "&pms_pm25=" + String(pm25)+
                        "&pms_pm100=" + String(pm100);
                        
   int httpResponseCode = http.POST(postData);
    
    if (httpResponseCode > 0) {
      Serial.println("Data sent successfully");
    } else {
      Serial.println("Error sending data");
    }
    http.end();

delay(30000);
}
  }
