<?php
namespace CarmaLink;

	/**
	 * Represents a CarmaLink configuration.
	 *
	 * @class GeneralConfig
	 */
	class GeneralConfig {

		/**
		 * @access public
		 * @var string|FuelType
		 */
		public $fuelType = NULL;

		/**
		 * @access public
		 * @var float|int
		 */
		public $engineDisplacement_L = NULL;

		/**
		 * @access public
		 * @var boolean
		 */
		public $isPaused = NULL; //not set to false on purpose.

		/**
		 * @access public
		 * @var int
		 */
		public $connectInterval_Mins = NULL;

		/**
		 * @access public
		 * @var int
		 */
		public $agpsConnectInterval_Hrs = NULL;
		/**
		 * @access public
		 * @var float
		 */
		public $chargingVoltage_V = NULL;
		/**
		 * @access public
		 * @var float
		 */
		public $lowBatteryVoltage_V = NULL;
		/**
		 * @access public
		 * @var int
		 */
		public $lowBatteryMinutes = NULL; //note: units are already included in resource name, and therefore not added.
		/**
		 * @access public
		 * @var int
		 */
		public $minimumRunVoltageEnergy = NULL;
		/**
		 * @access public
		 * @var int
		 */
		public $maximumOffVoltageEnergy = NULL;
		/**
		 * @access public
		 * @var string|OBDDecetionType
		 */
		public $obdDetection = NULL;

		/**
		 * @access private
		 * @var string
		 */
		private $__api_version;

		/**
		 * Constructor
		 *
		 * @param string|FuelType         fuelType     
		 * @param float|int               engineDisplacement_L
		 * @param bool                    isPaused
		 * @param int                     connectInterval_Mins
		 * @param int                     agpsConnectInterval_Hrs
		 * @param float|int               chargingVoltage_V
		 * @param float|int               lowBatteryVoltage_V
		 * @param int                     lowBatteryMinutes
		 * @param int                     minimumRunVoltageEnergy
		 * @param int                     maximumOffVoltageEnergy
		 * @param string|OBDDetectionType obdDetection
		 * @return void
		 */
		public function __construct($fuelType = NULL, $engineDisplacement_L = NULL, $isPaused = NULL,
		                            $connectInterval_Mins = NULL, $agpsConnectInterval_Hrs = NULL, $chargingVoltage_V = NULL,
		                            $lowBatteryVoltage_V = NULL, $lowBatteryMinutes = NULL, $minimumRunVoltageEnergy = NULL,
		                            $maximumOffVoltageEnergy = NULL, $obdDetection = NULL) {
			$this->__api_version = CarmaLinkAPI::API_VERSION;
			$this->fuelType                = $fuelType;
			$this->engineDisplacement_L    = $engineDisplacement_L;
			$this->isPaused                = $isPaused;
			$this->connectInterval_Mins    = $connectInterval_Mins;
			$this->agpsConnectInterval_Hrs = $agpsConnectInterval_Hrs;
			$this->chargingVoltage_V       = $chargingVoltage_V;
			$this->lowBatteryVoltage_V     = $lowBatteryVoltage_V;
			$this->lowBatteryMinutes       = $lowBatteryMinutes;
			$this->minimumRunVoltageEnergy = $minimumRunVoltageEnergy;
			$this->maximumOffVoltageEnergy = $maximumOffVoltageEnergy;
			$this->obdDetection            = $obdDetection;
		}

		/**
		 * Converts object to an associative array.
		 *
		 * @return array
		 */
		public function toArray() {
			//convert to an array with proper SDK names, and then also remove all NULL fields.
			$arr = array(
				"fuel"                    => $this->fuelType,
				"displacement"            => $this->engineDisplacement_L,
				"isPaused"                => $this->isPaused,
				"connectInterval"         => $this->connectInterval_Mins,
				"agpsConnectInterval"     => $this->agpsConnectInterval_Hrs,
				"chargingVoltage"         => $this->chargingVoltage_V,
				"lowBatteryVoltage"       => $this->lowBatteryVoltage_V,
				"lowBatteryMinutes"       => $this->lowBatteryMinutes,
				"minimumRunVoltageEnergy" => $this->minimumRunVoltageEnergy,
				"maximumOffVoltageEnergy" => $this->maximumOffVoltageEnergy,
				"obdDetection"            => $this->obdDetection);
			$nullVals = array();
			foreach($arr as $key=>$value) {
				if($value === NULL) {
					array_push($nullVals, $key);
				}
			}
			
			//remove nulls
			foreach($nullVals as $key) {
				unset($arr[$key]);
			}
			return $arr;
		}
		
		/**
		 * pulls only partial array from the general config based on the resource type of the config
		 * Example being sending in operation. Fails when no general config resource is found.
		 * @param string|ConfigType config_type
		 * @return array
		 */
		public function getPartialArrayFromGeneralConfigType($config_type) {
			if(!ConfigType::isValidGeneralConfig($config_type)) {
				throw new CarmaLinkAPIException("Error on getPartialArrayFromGeneralConfigType, $config_type is not recognized as a valid general config resource");
			}
			$configArray = array();
			//convert to an array with proper SDK names, and then also remove all NULL fields.
			switch($config_type) {
			case ConfigType::CONFIG_GENERAL_ENGINE:
				$configArray = array( 
					"fuel"                    => $this->fuelType,
					"displacement"            => $this->engineDisplacement_L,
					
				);
				break;
			case ConfigType::CONFIG_GENERAL_CONNECTIVITY:
				$configArray = array(
					"isPaused"                => $this->isPaused,
					"connectInterval"         => $this->connectInterval_Mins,
					"agpsConnectInterval"     => $this->agpsConnectInterval_Hrs,
				);
				break;
			case ConfigType::CONFIG_GENERAL_OPERATION:
				$configArray = array(
					"chargingVoltage"         => $this->chargingVoltage_V,
					"lowBatteryVoltage"       => $this->lowBatteryVoltage_V,
					"lowBatteryMinutes"       => $this->lowBatteryMinutes,
					"minimumRunVoltageEnergy" => $this->minimumRunVoltageEnergy,
					"maximumOffVoltageEnergy" => $this->maximumOffVoltageEnergy,
					"obdDetection"            => $this->obdDetection
				);
				break;
			default:
				//function already removes nulls.
				return $this->toArray();
			}
			
			//get keys of nulls
			$nullVals = array();
			foreach($configArray as $key=>$value) {
				if($value === NULL) {
					array_push($nullVals, $key);
				}
			}
			
			//remove nulls
			foreach($nullVals as $key) {
				unset($configArray[$key]);
			}
			return $configArray;
		}

		 /* Utility method to create a new Config instance based on a device
		 *
		 * @param CarmaLink				device		A custom data object representing a CarmaLink
		 * @return Config|bool 			return new config object, or false to delete configuration
		 */
		private static function createConfigFromDevice(CarmaLink $device) {
			$config = new GeneralConfig();

			$config->fuelType                = $device->getFuelType();
			$config->engineDisplacement_L    = $device->getDisplacement_L();
			$config->isPaused                = $device->getDevicePaused();
			$config->connectInterval_Mins    = $device->getConnectInterval_Mins();
			$config->agpsConnectInterval_Hrs = $device->getAGPSConnectInterval_Hrs();
			$config->chargingVoltage_V       = $device->getChargingVoltage_V();
			$config->lowBatteryVoltage_V     = $device->getLowBatteryVoltage_V();
			$config->lowBatteryMinutes       = $device->getLowBatteryMinutes();
			$config->minimumRunVoltageEnergy = $device->getMinimumRunVoltageEnergy();
			$config->maximumOffVoltageEnergy = $device->getMaximumOffVoltageEnergy();
			$config->obdDetection            = $device->getOBDDetection();
			
			return $config;
		}

		/**
		 * Shortcut method which retreives a configuration object and converts to an array.
		 *
		 * @uses GeneralConfig::createConfigFromDevice()
		 * @uses GeneralConfig::toArray()
		 *
		 * @param CarmaLink	device		Representation of CarmaLink
		 * @return array|bool 			returns array of config parameters or false if it should be deleted
		 */
		public static function getConfigArray($device) {
			$newConfig = self::createConfigFromDevice($device);
			return ($newConfig !== FALSE) ? $newConfig->toArray() : FALSE;
		}

		/**
		 * Static factory
		 * 
		 * @param string|stdClass 	obj 			Either a JSON string or a stdClass object representing a general config from the API (no units)
		 * @return GeneralConfig
		 */
		public static function Factory($obj) {
			if (!$obj) { return FALSE; }

			if (!is_object($obj) && is_string($obj)) {
				try { $obj = json_decode($obj); }
				catch(Exception $e) { throw new CarmaLinkAPIException("Could not instantiate GeneralConfig with provided JSON data ".$e->getMessage()); }
			}
			
			//remember, this is the information from the api. the information stored here is with units, api without units.
			$config = new GeneralConfig(
				isset($obj->fuel)                    ? $obj->fuel                    : NULL,
				isset($obj->displacement)            ? $obj->displacement            : NULL,
				isset($obj->isPaused)                ? $obj->isPaused                : NULL,
				isset($obj->connectInterval)         ? $obj->connectInterval         : NULL,
				isset($obj->agpsConnectInterval)     ? $obj->agpsConnectInterval     : NULL,
				isset($obj->chargingVoltage)         ? $obj->chargingVoltage         : NULL,
				isset($obj->lowBatteryVoltage)       ? $obj->lowBatteryVoltage       : NULL,
				isset($obj->lowBatteryMinutes)       ? $obj->lowBatteryMinutes       : NULL,
				isset($obj->minimumRunVoltageEnergy) ? $obj->minimumRunVoltageEnergy : NULL,
				isset($obj->maximumOffVoltageEnergy) ? $obj->maximumOffVoltageEnergy : NULL,
				isset($obj->obdDetection)            ? $obj->obdDetection            : NULL
			);

			return $config;
		}
	}
?>	
