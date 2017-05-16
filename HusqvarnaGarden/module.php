<?
    // Klassendefinition
    class HusqvarnaGarden extends IPSModule {

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

            $this->RegisterPropertyString("UrlLogin", "https://smart.gardena.com/sg-1/sessions");



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
            $this->getToken();
        }




        private function getToken() {
          $data = array(
              "sessions" => array(
                  "email" => "" . $this->ReadPropertyString("user"). "", "password" => "" . $this->ReadPropertyString("password"). "")
                  );

          $data_string = json_encode($data);

          var_dump($data_string);




        }

    }
?>
