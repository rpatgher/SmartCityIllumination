#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

#define Led1 4
#define Led2 18
#define Led3 21
#define Led4 22

#define LDR1 33
#define LDR2 32
#define LDR3 35
#define LDR4 34

#define CNY1 25
#define CNY2 26

int CNY[2] = {CNY1, CNY2};
int LDR[4] = {LDR1, LDR2, LDR3, LDR4};
int Leds[4] = {Led1, Led2, Led3, Led4};
int LedActive[4] = {1, 1, 1, 1}; //para saber si el led está activado

int fullActive = 1;
int emergency = 0; 
int enCNY[2] = {0, 0};//guardar el valor que leen los sensores de presencia
int brightnessLeds[4] = {0, 0, 0, 0};//guardar %brillo de cada led
float current[4] = {0, 0, 0, 0};
float power[4] = {0, 0, 0, 0};
float voltage[4] = {0, 0, 0, 0};


WiFiServer servidor(80);  //declaras el objeto- puerto internet - esp es servidor y cliente 
WiFiClient cliente;       //parametros 


// Connection to WiFi
const char* ssid="Tec-Contingencia";
const char* pass="";
// const char* ssid="PATGHER";
// const char* pass="748A0DEB2AC0";
const char* serverName = "https://v8szvqw2-3000.usw3.devtunnels.ms/api/save";//direccion del servidor con el end point para guardar los datos 
//la conexión a la compu se habilitó un puerto publico y la direccion publica es serverName (https://v8szvqw2-3000.usw3.devtunnels.ms/)
//api/save- end point AKA espacio habilitado donde llegan los datos (se procesan) - no se guarda a primera instancia por seguridad
const char* serverNameLeds = "https://v8szvqw2-3000.usw3.devtunnels.ms/api/update-brightness";//end point para guardar el % de luz de led 
String api_key = "sbdiewhgbjakbfahu"; //contraseña- la información del servidor se está mandando desde el esp- para que nos idenficar con el servidor

//medir el tiempo que se tardan los requets
unsigned long lastTime = 0;
unsigned long timerDelay = 2000;
unsigned long lastTimeLeds = 0;
unsigned long timerDelayLeds = 1000;

//valor de resistencia del led 
const int resistance = 330; // Ohm

//declaramos la funcion para inicializar wifi 

void InitWiFi();
// int readCNY(int n);
// void sendData(float voltage, float current, float power, int led);

//funcion para actualizar el % de brillo de los leds en el base de datos aka dashboard
void updateLedsBrightnessonDB();

void setup() {
  for(int i = 0; i < 4; i++){
    pinMode(LDR[i], INPUT); //configurar pines de entrada - los de luz siempre son entrada porque reciben datos (0 y 1)
    pinMode(Leds[i], OUTPUT);//pines de salidas de para ver si prende a apagada 
  }
  for(int i = 0; i < 2; i++){
    pinMode(CNY[i], INPUT);//sensor de proximidad - entrada 
  }
  Serial.begin(9600);
  InitWiFi();//mandas a llamar para que se conecte a internet 

  servidor.begin();   //Se configura como servidor el esp32
  Serial.println("Servidor iniciado");
}


void loop() {
  //para apagado de emergencia
  cliente = servidor.available();//si hay alguien conectado 
  if (cliente){
    Serial.print("Cliente conectado");//sitio web es el que se conecta
    // while (cliente.connected() && cliente.available()){
    //   char dato = cliente.read();
    //   Serial.print(dato);
    // }

    String request = cliente.readStringUntil('\r'); // Leo hasta retorno de carro
    Serial.println(request); //Imprimo la petición

    //Interpreto lo que he recibido
    //codigo js- sitio web
    if (request.indexOf("/emergency=ON") != -1)  {
      Serial.println("Prendido de Emergencia Activado");
      emergency = 1;
    }
    if (request.indexOf("/emergency=OFF") != -1)  {
      Serial.println("Prendido de Emergencia Activado");
      emergency = 0;
    }
    if (request.indexOf("/LED1=ON") != -1)  {
      Serial.println("Led 1 Encendido");
      LedActive[0] = 1;
    }
    if (request.indexOf("/LED1=OFF") != -1)  {
      Serial.println("Led 1 Apagado");
      LedActive[0] = 0;
    }
    if (request.indexOf("/LED2=ON") != -1)  {
      Serial.println("Led 2 Encendido");
      LedActive[1] = 1;
    }
    if (request.indexOf("/LED2=OFF") != -1)  {
      Serial.println("Led 2 Apagado");
      LedActive[1] = 0;
    }
    if (request.indexOf("/LED3=ON") != -1)  {
      Serial.println("Led 3 Encendido");
      LedActive[2] = 1;
    }
    if (request.indexOf("/LED3=OFF") != -1)  {
      Serial.println("Led 3 Apagado");
      LedActive[2] = 0;
    }
    if (request.indexOf("/LED4=ON") != -1)  {
      Serial.println("Led 4 Encendido");
      LedActive[3] = 1;
    }
    if (request.indexOf("/LED4=OFF") != -1)  {
      Serial.println("Led 4 Apagado");
      LedActive[3] = 0;
    }
  }



//si no hay estado de emergencia
  if(!emergency){
    readCNY();
    if(enCNY[0]){
      for(int i = 0; i < 2; i++){
        if(LedActive[i]){
          readLDR(i);
        }
      }
    }else{
      for(int i = 0; i < 2; i++){
        setZero(i);
      }
    }
    if(enCNY[1]){
      for(int i = 2; i < 4; i++){
        if(LedActive[i]){
          readLDR(i);
        }
      }
    }else{
      for(int i = 2; i < 4; i++){
        setZero(i);
      }
    }
  }else{
    allOnes();//si sí hay estado de emergencia, se prenden todos

  }

  for(int i = 0; i < 4; i++){
    if(!LedActive[i]){
      setZero(i);
    }
  }


  updateLedsBrightnessonDB();
  sendData();

  delay(10);
}

void allOnes(){
  for(int i = 0; i < 4; i++){
    analogWrite(Leds[i], 255);
    voltage[i] = 5;
    current[i] = (voltage[i] / resistance) * 1000;
    power[i] = (voltage[i] * current[i]);
    brightnessLeds[i] = 100;
  }
}

void setZero(int n){
  analogWrite(Leds[n], 0);
  brightnessLeds[n] = 0;
  voltage[n] = 0;
  current[n] = 0;
  power[n] = 0;
}

void readCNY(){
  enCNY[0] = digitalRead(CNY[0]);
  enCNY[1] = digitalRead(CNY[1]);
}

int ldrRead, brightness;
void readLDR(int n){
  ldrRead = analogRead(LDR[n]);
  brightness = map(ldrRead, 0, 4095, 255, 0);
  float voltageRead = (brightness * 5.0) / 255.0;
  float currentRead = (voltageRead / resistance) * 1000;
  float powerRead = (voltageRead * currentRead);
  analogWrite(Leds[n], brightness);

  // Serial.print("Voltage: ");
  // Serial.print(voltageRead);
  // Serial.print(" V  ");
  // Serial.print("Current: ");
  // Serial.print(currentRead);
  // Serial.print(" mA  ");
  // Serial.print("Power: ");
  // Serial.print(powerRead);
  // Serial.println(" mW  ");


  voltage[n] = voltageRead;
  current[n] = currentRead;
  power[n] = powerRead;
  brightnessLeds[n] = (voltageRead * 100) / 5;
}

void updateLedsBrightnessonDB(){
  if ((millis() - lastTimeLeds) > timerDelayLeds) {
    //Check WiFi connection status
    if(WiFi.status()== WL_CONNECTED){
      HTTPClient http;//para después mandar datos

      // Your Domain name with URL path or IP address with path
      http.begin(serverNameLeds);//manda el valor de la direccion ip de donde se haran los requests

//definir tipo de dato de como se va a enviar
      http.addHeader("Content-Type", "application/json");
      StaticJsonDocument<200> jsonBuffer;

      DynamicJsonDocument doc(1024);
      doc["api_key"] = api_key;
      std::string array = "[" + std::to_string(brightnessLeds[0]) + "," + std::to_string(brightnessLeds[1]) + "," + std::to_string(brightnessLeds[2]) + "," + std::to_string(brightnessLeds[3]) + "]";
      doc["brightness"] = serialized(array);

      String json;
      serializeJson(doc, json);

      
      // Send HTTP POST request
      // int httpResponseCode = http.POST(httpRequestData);
      int httpResponseCode = http.POST(json);
      
      if (httpResponseCode>0) {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
        String payload = http.getString();
        Serial.println(payload);
      }
      else {
        Serial.print("Error code: ");
        Serial.println(httpResponseCode);
      }
      // Free resources
      http.end();
    }
    else {
      Serial.println("WiFi Disconnected");
    }
    lastTimeLeds = millis();
  }
}


void sendData(){
  //Send an HTTP POST request every 5 seconds
  if ((millis() - lastTime) > timerDelay) {
    //Check WiFi connection status
    if(WiFi.status()== WL_CONNECTED){
      HTTPClient http;

      // Your Domain name with URL path or IP address with path
      http.begin(serverName);

      http.addHeader("Content-Type", "application/json");
      StaticJsonDocument<200> jsonBuffer;

      DynamicJsonDocument doc(2048);
      doc["api_key"] = api_key;
      std::string ledArray1 = "[" + std::to_string(voltage[0]) + "," + std::to_string(power[0]) + "," + std::to_string(current[0]) + "]";
      std::string ledArray2 = "[" + std::to_string(voltage[1]) + "," + std::to_string(power[1]) + "," + std::to_string(current[1]) + "]";
      std::string ledArray3 = "[" + std::to_string(voltage[2]) + "," + std::to_string(power[2]) + "," + std::to_string(current[2]) + "]";
      std::string ledArray4 = "[" + std::to_string(voltage[3]) + "," + std::to_string(power[3]) + "," + std::to_string(current[3]) + "]";
      doc["led1"] = serialized(ledArray1);
      doc["led2"] = serialized(ledArray2);
      doc["led3"] = serialized(ledArray3);
      doc["led4"] = serialized(ledArray4);
      
      
      // String httpRequestData = "api_key=" + api_key + "&led=" + led + "&current_mA=" + current + "&power_mW=" + power + "&voltage_V=" + voltage;


      String json;
      serializeJson(doc, json); 
      
      // Send HTTP POST request
      int httpResponseCode = http.POST(json);
      
      if (httpResponseCode>0) {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
        String payload = http.getString();
        Serial.println(payload);
      }
      else {
        Serial.print("Error code: ");
        Serial.println(httpResponseCode);
      }
      Serial.print("\n");
      // Free resources
      http.end();
    }
    else {
      Serial.println("WiFi Disconnected");
    }
    lastTime = millis();
  }
}

void InitWiFi(){
  WiFi.mode(WIFI_STA);                      // Estacion
  //WiFi.mode(WIFI_AP);                     // Punto de Acceso
  //WiFi.mode(WIFI_MODE_APSTA);             // Ambos

  WiFi.begin(ssid,pass);                   // Inicializamos el WiFi con nuestras credenciales.
  Serial.print("Conectando a ");
  Serial.print(ssid);

  while (WiFi.status() != WL_CONNECTED) 
  {   //Espera a que esté conectado
    Serial.print(".");
    delay(500);
  }

  if (WiFi.status() == WL_CONNECTED) 
  {
    Serial.println();
    Serial.println();
    Serial.println("Connected to WIFI!!");
  }

  Serial.println("");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());
}