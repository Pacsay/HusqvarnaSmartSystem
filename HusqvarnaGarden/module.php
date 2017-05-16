<?
    // Klassendefinition
    class HusqvarnaGarden extends IPSModule {

      var $userId, $token;

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

            $this->RegisterPropertyString("LocationId", "");
            $this->RegisterPropertyString("LocationName", "");

            $this->RegisterPropertyString("user", "info@buttge.de");
            $this->RegisterPropertyString("password", "pw140583");

            $this->RegisterPropertyString("LoginUrl", "https://smart.gardena.com/sg-1/sessions");



        }

        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();

        }

        /**
        * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
        * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
        *
        * ABC_MeineErsteEigeneFunktion($id);
        *
        */
        public function connect() {
            $this->token = $this->getNewToken();
            echo ($this->token);
        }




        private function getNewToken() {
          $data = array(
              "sessions" => array(
                  "email" => "" . $this->ReadPropertyString("user"). "", "password" => "" . $this->ReadPropertyString("password"). "")
                  );

          $data_string = json_encode($data);

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

          return($data -> sessions -> token);

        }

    }
?>
