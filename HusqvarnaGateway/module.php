<?
    // Klassendefinition
    class HusqvarnaGateway extends IPSModule {

        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
            parent::Create();

/*
            $this->RegisterPropertyString("LocationId", "");
            $this->RegisterPropertyString("LocationName", "");

            $this->RegisterPropertyString("user", "info@buttge.de");
            $this->RegisterPropertyString("password", "pw140583");

            $this->RegisterPropertyString("LoginUrl", "https://smart.gardena.com/sg-1/sessions");
            $this->RegisterPropertyString("LocationsUrl", "https://smart.gardena.com/sg-1/locations/?user_id=");
            $this->RegisterPropertyString("DevicesUrl", "https://smart.gardena.com/sg-1/devices?locationId=");
*/
            $variablenID = $this->RegisterPropertyString("DeviceId", "ef021e54-5c74-49d5-bfed-dfa1510664cb");

        }

        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();

        }


      /*...*/

    }
?>
