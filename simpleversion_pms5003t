#define RXD2 16 // To sensor TXD
#define TXD2 17 // To sensor RXD

struct pms5003data {
  uint16_t framelen;
  uint16_t pm10_standard, pm25_standard, pm100_standard;
};

struct pms5003data data;

void setup() {
  Serial.begin(115200); 
  Serial1.begin(9600, SERIAL_8N1, RXD2, TXD2);
}

void loop() {
  if (readPMSdata(&Serial1)) {
    uint16_t pm1 = data.pm10_standard;
    uint16_t pm25 = data.pm25_standard;
    uint16_t pm100 = data.pm100_standard;
    
    Serial.print("PM 1.0: "); 
    Serial.print(pm1);
    Serial.print("\tPM 2.5: "); 
    Serial.print(pm25);
    Serial.print("\tPM 10: "); 
    Serial.println(pm100);
  }
}

boolean readPMSdata(Stream *s) {
  uint8_t buffer[32];
  s->readBytes(buffer, 32);
  uint16_t buffer_u16[15];
  for (uint8_t i = 0; i < 15; i++) {
    buffer_u16[i] = buffer[2 + i * 2 + 1];
    buffer_u16[i] += (buffer[2 + i * 2] << 8);
  }
  memcpy((void *)&data, (void *)buffer_u16, 30);
  return true;
}
