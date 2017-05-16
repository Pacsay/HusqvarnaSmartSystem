<?
    // Klassendefinition
    class HusqvarnaGarden extends IPSModule {

      var $userId, $token, $locations, $locationId;

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
            $this->RegisterPropertyString("LocationsUrl", "https://smart.gardena.com/sg-1/locations/?user_id=");
            $this->RegisterPropertyString("DevicesUrl", "https://smart.gardena.com/sg-1/devices?locationId=");


        }

        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();

        }


        public function connect() {
          $dumpResponses = true;
            $this->authenticate($dumpResponses);

            $this->locations = $this->loadLocations($dumpResponses);
            $this->locationId = $this->locations[0] -> id;

            $this->loadDevices($dumpResponses);
        }

        public function loadDevices($dump = false){
          $url = $this->ReadPropertyString("DevicesUrl") . $this -> locationId;

          $request = curl_init($url);
          curl_setopt($request, CURLOPT_CUSTOMREQUEST, "GET");
          curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($request, CURLOPT_HTTPHEADER, array(
              'Content-Type:application/json',
              'X-Session:' . $this -> token)
          );

          $data = json_decode(curl_exec($request)) -> devices;

          if($dump){
            echo "LOAD DEVICES\n";
            var_dump($data);
            echo "\n\n";
          }

        }


        public function loadLocations($dump = false) {
          $url = $this->ReadPropertyString("LocationsUrl") . $this -> userId;

          $request = curl_init($url);
          curl_setopt($request, CURLOPT_CUSTOMREQUEST, "GET");
          curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($request, CURLOPT_HTTPHEADER, array(
              'Content-Type:application/json',
              'X-Session:' . $this -> token)
          );

          $data = json_decode(curl_exec($request)) -> locations;

          if($dump){
            echo "LOAD LOCATIONS\n";
            var_dump($data);
            echo "\n\n";
          }

          return $data;

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

          if($dump){
            echo "AUTHENTICATE\n";
            var_dump($data);
            echo "\n\n";
          }

          $this -> token = $data -> sessions -> token;
          $this -> userId = $data -> sessions -> user_id;
        }

    }
?>
