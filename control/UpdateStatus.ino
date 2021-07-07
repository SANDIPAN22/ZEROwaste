#include <plugio.h>
#include <WiFi.h>
#include <HTTPClient.h>

////////Pin declaration///////////////
#define echoPin1 13
#define trigPin1 12
#define echoPin2 14
#define trigPin2 27
#define echoPin3 26
#define trigPin3 25

int Gas_01 = 33;
int Gas_02 = 35;
int Gas_03 = 34;

//////////////////////////////
///////Varriable declaration globally////////////
long duration1,duration2,duration3;
int distance1,distance2,distance3;
int MU1,MU2,MU3; ///////Mapping value (Ultrasonic Sensor)

float MG1,MG2,MG3;//////Mapping Value (Gas Sensor)

///////////////////////////////////////
int TR1,TR2,TR3;
/////////Parameter For Cloud Credentials/////////////////
const char* ssid = "CYPHER";
const char* password = "9851793634";
const char* topicid = "608d472fe0626";
const char* wkey = "608d472fe0637";

/// plugio instantiniate
plugio p =plugio();
HTTPClient p2, p3, p4;
void setup() {
  // put your setup code here, to run once:
  WiFi.begin(ssid, password);
  Serial.begin(115200);
  while (WiFi.status() != WL_CONNECTED) {
      delay(50);
     Serial.print(".");
  }
    Serial.println("IP address: ");
    Serial.println(WiFi.localIP());

 /////////PinMode//////////
  pinMode(Gas_01, INPUT);
  pinMode(Gas_02, INPUT);
  pinMode(Gas_03, INPUT);
 
  pinMode(trigPin1, OUTPUT);
  pinMode(echoPin1, INPUT);
  pinMode(trigPin2, OUTPUT);
  pinMode(echoPin2, INPUT);
  pinMode(trigPin3, OUTPUT);
  pinMode(echoPin3, INPUT);
}

void loop() {
  // put your main code here, to run repeatedly:
  float gassensorAnalog1 = analogRead(Gas_01);
  float gassensorAnalog2 = analogRead(Gas_02);
  float gassensorAnalog3 = analogRead(Gas_03);
  MG1= map(gassensorAnalog1,1500,4000,0,100);
  MG2= map(gassensorAnalog2,1500,4000,0,100);
  MG3= map(gassensorAnalog3,1500,4000,0,100);
  Serial.print("Gas Sensor1: ");
  Serial.print(gassensorAnalog1);
  Serial.println("\t");
  Serial.print("Mapped Gas Value1:   ");
  Serial.println(MG1);

  Serial.print("Gas Sensor2: ");
  Serial.print(gassensorAnalog2);
  Serial.println("\t");
  Serial.print("Mapped Gas Value2:");
  Serial.println(MG2);

  Serial.print("Gas Sensor3: ");
  Serial.print(gassensorAnalog3);
  Serial.println("\t");
  Serial.print("Mapped Gas Value3:");
  Serial.println(MG3);

  digitalWrite(trigPin1, LOW);
 delay(2);
 digitalWrite(trigPin1, HIGH);
 delay(10);
 digitalWrite(trigPin1, LOW);
 duration1 = pulseIn(echoPin1, HIGH);
 distance1 = duration1 * 0.034 / 2;
 Serial.print("Distance 1: ");
 Serial.print(distance1);
 Serial.println(" cm");
 MU1 = map(distance1,0, 30,100,0);
 Serial.print("Mapped Distance 1: ");
 Serial.println(MU1);

   digitalWrite(trigPin2, LOW);
 delay(2);
 digitalWrite(trigPin2, HIGH);
 delay(10);
 digitalWrite(trigPin2, LOW);
 duration2 = pulseIn(echoPin2, HIGH);
 distance2 = duration2 * 0.034 / 2;
 Serial.print("Distance 2: ");
 Serial.print(distance2);
 Serial.println(" cm");
 MU2 = map(distance2,0, 30,100,0);
 Serial.print("Mapped Distance 2:");
 Serial.println(MU2);

 digitalWrite(trigPin3, LOW);
 delay(2);
 digitalWrite(trigPin3, HIGH);
 delay(10);
 digitalWrite(trigPin3, LOW);
 duration3 = pulseIn(echoPin3, HIGH);
 distance3 = duration3 * 0.034 / 2;
 Serial.print("Distance 3: ");
 Serial.print(distance3);
 Serial.println(" cm");
 MU3 = map(distance3,0,30,100,0);
 Serial.print("Mapped Distance 3:");
 Serial.println(MU3);

TR1=touchRead(32);
Serial.println("Touch value 1: "+String(TR1,DEC));
TR2=touchRead(4);
Serial.println("Touch value 2: "+String(TR2,DEC));
TR3=touchRead(15);
Serial.println("Touch value 3: "+String(TR3,DEC));

    if(MU1<=100 && MU2<=100 && MU3<=100 && MU1>=0 && MU2>=0 && MU3>=0)
  {
    Serial.println(p.plug_n_plot_write(topicid,wkey,1,MU1));
    Serial.println(p.plug_n_plot_write(topicid,wkey,2,MG1));

    Serial.println(p.plug_n_plot_write(topicid,wkey,3,MU2));
    Serial.println(p.plug_n_plot_write(topicid,wkey,4,MG2));

    Serial.println(p.plug_n_plot_write(topicid,wkey,5,MU3));
    Serial.println(p.plug_n_plot_write(topicid,wkey,6,MG3));
   
    if(MU1>=60)
  {
   
    String api_as01="http://zerowaste.iotics.net/alertupdater.php?bid=BY2021M01S01&status=1";
    p3.begin(api_as01);
    int code2=p3.GET();
    Serial.println("Hit for garbage 1 outbound");
    Serial.println(code2);
    p3.end();
       
  }
 
  if(MG1>=60)
  {
       
    String api_as02="http://zerowaste.iotics.net/alertupdater.php?bid=BY2021M01S01&status=1";
    p3.begin(api_as02);
    int code4=p3.GET();
    Serial.println("Hit for gas 1 outbound");
    Serial.println(code4);
    p3.end();
   
  }
  if(MU2>=80)
  {
    String api_as03="http://zerowaste.iotics.net/alertupdater.php?bid=BY2021M01S02&status=1";
    p3.begin(api_as03);
    int code6=p3.GET();
    Serial.println("Hit for garbage 2 outbound");
    Serial.println(code6);
    p3.end();
   
  }
  if(MG2>=60)
  {
    String api_as04="http://zerowaste.iotics.net/alertupdater.php?bid=BY2021M01S02&status=1";
    p3.begin(api_as04);
    int code8=p3.GET();
    Serial.println("Hit for gas 2 outbound");
    Serial.println(code8);
    p3.end();
   
   }

     if(MU3>=60)
  {
    String api_as05="http://zerowaste.iotics.net/alertupdater.php?bid=BY2021M01S03&status=1";
    p3.begin(api_as05);
    int code10=p3.GET();
    Serial.println("Hit for garbage 3 outbound");
    Serial.println(code10);
    p3.end();
  }
  if(MG3>=60)
  {
    String api_as06="http://zerowaste.iotics.net/alertupdater.php?bid=BY2021M01S03&status=1";
    p3.begin(api_as06);
    int code12=p3.GET();
    Serial.println("Hit for gas 3 outbound");
    Serial.println(code12);
    p3.end();
   
  }
   if(TR1<20)
   {
    String api_as07="http://zerowaste.iotics.net/alertupdater.php?bid=BY2021M01S01&status=1";
    p3.begin(api_as07);
    int code14=p3.GET();
    Serial.println("Button 1 Pressed");
    Serial.println(code14);
    p3.end();
   }
   if(TR2<20)
  {
    String api_as08="http://zerowaste.iotics.net/alertupdater.php?bid=BY2021M01S02&status=1";
    p3.begin(api_as08);
    int code16=p3.GET();
    Serial.println("Button 2 Pressed");
    Serial.println(code16);
    p3.end();
  }
  if(TR3<20)
  {
   
    String api_as09="http://zerowaste.iotics.net/alertupdater.php?bid=BY2021M01S03&status=1";    
    p3.begin(api_as09);    
    int code18=p3.GET();
    Serial.println("Button 3 Pressed");    
    Serial.println(code18);
    p3.end();
   
  }
   
    if(MU1<60 && MG1<60 && MU2<80 && MG2<60 && MU3<60 && MG3<60 && TR1>=20 && TR2>=20 && TR3>=20)
  {
     
    String api_as010="http://zerowaste.iotics.net/alertupdater.php?bid=BY2021M01S01&status=0";
   
    String api_as011="http://zerowaste.iotics.net/alertupdater.php?bid=BY2021M01S02&status=0";
   
    String api_as012="http://zerowaste.iotics.net/alertupdater.php?bid=BY2021M01S03&status=0";
    p2.begin(api_as010);
    Serial.println("Off the 1st bin");
    p3.begin(api_as011);
    Serial.println("Off the 2nd bin");
    p4.begin(api_as012);
    Serial.println("Off the 3rd bin");
    int code19=p2.GET();
    int code20=p3.GET();
    int code21=p4.GET();
    Serial.println(code19);
    Serial.println(code20);
    Serial.println(code21);
    p2.end();
    p3.end();
    p4.end();
  }
 }
  delay(15000);
}
