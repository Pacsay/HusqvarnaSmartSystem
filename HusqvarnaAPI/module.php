<?
    // Klassendefinition
    class HusqvarnaAPI extends IPSModule {


        // Der Konstruktor des Moduls
        // Überschreibt den Standard Kontruktor von IPS
        public function __construct($InstanceID) {
            // Diese Zeile nicht löschen
            parent::__construct($InstanceID);

            // Selbsterstellter Code
        }

        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
            parent::Create();

            $this->RegisterPropertyString("user", "info@buttge.de");
            $this->RegisterPropertyString("password", "pw140583");

            $this->RegisterPropertyString("LoginUrl", "https://smart.gardena.com/sg-1/sessions");
            $this->RegisterPropertyString("LocationsUrl", "https://smart.gardena.com/sg-1/locations/?user_id=");
            $this->RegisterPropertyString("DevicesUrl", "https://smart.gardena.com/sg-1/devices?locationId=");

            $this->SetBuffer("TokenStamp", 0);

        }

        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
        }

        public function CheckCredentialsForGui() {
          if ($this -> getToken() == NULL) {
            echo "Authentifizierung fehlgeschlagen! URL, Username, Passwort und physikalische Verbindung checken...";
          } else {
            echo "Verbindung hergestellt.";
          }
        }

        private function getToken() {

          echo "Current TokenStamp: " . $this->GetBuffer("TokenStamp") . "\n";
          echo "TimeDiv is: " . (time() - $this->GetBuffer("TokenStamp")) . "\n";
          if ((time() - $this->GetBuffer("TokenStamp")) <= 30) {
            echo "reusing Token " . $this -> token . "\n" ;
            return $this->GetBuffer("Token");
          } else {
            echo "renewing Token \n";
            if($this -> authenticate()) {
              echo "New TokenStamp " . $this->GetBuffer("TokenStamp") . "\n";
              return $this->GetBuffer("Token");
            } else {
              return NULL;
            }
          }



        }


        private function authenticate($dump = false) {
          $credentials = array("sessions" => array("email" => "" . $this->ReadPropertyString("user"). "", "password" => "" . $this->ReadPropertyString("password"). ""));
          $data_string = json_encode($credentials);

          $request = curl_init($this->ReadPropertyString("LoginUrl"));
          curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
          curl_setopt($request, CURLOPT_POSTFIELDS, $data_string);
          curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($request, CURLOPT_HTTPHEADER, array(
              'Content-Type:application/json',
              'Content-Length: ' . strlen($data_string))
          );

          $result = curl_exec($request);
          $data = json_decode($result);

          if($data) {
            if($dump) {
              echo "AUTHENTICATE\n";
              var_dump($data);
              echo "\n\n";
            }

            $this->SetBuffer("Token", $data -> sessions -> token);
            $this->SetBuffer("TokenStamp", time());
            $this->SetBuffer("UserId", $data -> sessions -> user_id);

            return true;
          } else {
            return false;
          }
        }

    }
?>
