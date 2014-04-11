<?php
namespace CarmaLink;

	/**
	 * Represents a CarmaLink configuration.
	 *
	 * @class Config
	 */
	class Config {

		const API_THRESHOLD        = "threshold";
		const API_ALLOWANCE        = "allowance";
		const API_LOCATION         = "location";
		const API_BUZZER           = "buzzer";
		const API_DELETE_CONFIG    = "OFF";
		const API_PARAMS           = "optionalParams";
		const API_CONDITIONS	   = "optionalConditions";

		const SPEEDING             = "SPEEDING";

		const ODOMETER             = "ODOMETER";
		const DURATION_TO_SERVICE  = "DURATION_TO_SERVICE";
		const DISTANCE_TO_SERVICE  = "DISTANCE_TO_SERVICE";
		const BATTERY_VOLTAGE      = "BATTERY_VOLTAGE";
		const BATTERY_VOLTAGE_LOW  = "IS_LOW_BATTERY_VOLTAGE";
		const EMISSION_MONITORS    = "EMISSION_MONITORS";
		const FUEL_LEVEL           = "FUEL_LEVEL";
		const TIRE_PRESSURE_LOW    = "IS_LOW_TIRE_PRESSURE";

		/**
		 * @access public
		 * @var int
		 */
		public $id = 0;

		/**
		 * @access public
		 * @var int|float
		 */
		public $threshold = 0;

		/**
		 * @access public
		 * @var int|float
		 */
		public $allowance = 0.0;

		/**
		 * @access public
		 * @var bool
		 */
		public $location = false;

		/**
		 * @access public
		 * @var string
		 */
		public $buzzer = BuzzerVolume::BUZZER_OFF;

		/**
		 * @access public
		 * @var array
		 */
		public $params = null;

		/**
		 * @access public
		 * @var array
		 */
		public $conditions = null;

		/**
		 * @access public
		 * @var ConfigStatus
		 */
		public $state = ConfigStatus::UNKNOWN_STATUS;

		/**
		 * @access protected
		 * @var ConfigType
		 */
		protected $_config_type;

		/**
		 * @access private
		 * @var string
		 */
		private $__api_version;

		/**
		 * Constructor
		 *
		 * @param int|float 		threshold
		 * @param int|float 		allowance
		 * @param bool 				location
		 * @param bool 				location
		 * @param array 			optional params
		 * @param array 			optional condition
		 * @param CarmaLink\ConfigStatus	status
		 * @return void
		 */
		public function __construct($id = 0, $threshold = NULL, $allowance = NULL, $location = NULL, $params = NULL, $conditions = NULL, $state = NULL, $config_type = NULL) {
			$this->__api_version = CarmaLinkAPI::API_VERSION;
			$this->id            = $id;
			$this->threshold     = $threshold;
			$this->allowance     = $allowance;
			$this->location      = $location;
			$this->params        = $params;
			$this->conditions    = $conditions;
			if ($state) { $this->state = $state; }
		}

		/**
		 * Sets the protected member variable if valid.
		 *
		 * @param string|ConfigType		config_type
		 * @return bool
		 */
		public function setConfigType($config_type) {
			if ($config_type === $this->_config_type || !ConfigType::isValidConfigType($config_type)) { return false; }
			$this->_config_type = $config_type;
			return true;
		}

		/**
		 * Converts object to associative array.
		 *
		 * @return array
		 */
		public function toArray() {
			$a = Array();
			// The reasoning behind all of the null checks:
			// If an object is null when sent, it should not, by default, consider that a 0. It should consider it as
			// NULL, and a thing to be ignored. This allows a person to do simple updates to a threshold via simple
			// requests, such as JUST updating the buzzer, or threshold. 
			if (!in_array($this->_config_type, array(ConfigType::CONFIG_TRIP_REPORT, ConfigType::CONFIG_VEHICLE_HEALTH))) {
				if ($this->threshold != NULL) { $a[self::API_THRESHOLD]  = (float) $this->threshold; }
				if ($this->allowance != NULL) { $a[self::API_ALLOWANCE]  = (float) $this->allowance; }
			}
			if ($this->params   != NULL) { $a[self::API_PARAMS]     = (!empty($this->params) ? $this->params : null); }
			
			if      ($this->location != NULL) { $a[self::API_LOCATION]   = (bool)$this->location; }

			if      (is_array($this->conditions) && !empty($this->conditions) && ($this->conditions != NULL))
			                                  { $a[self::API_CONDITIONS] = $this->conditions; }

			if      ($this->hasBuzzerConfig() && ($this->buzzer != NULL))
			                                  { $a[self::API_BUZZER]     = (string)$this->buzzer; }
			return $a;
		}

		/**
		 * Determines if current configuration type utilizes a buzzer property.
		 *
		 * @return bool
		 */
		public function hasBuzzerConfig() { return (bool)ConfigType::isBuzzerConfigType($this->_config_type); }


		/**
		 * Utility to setup a config's optional parameters based on a device
		 *
		 * @param CarmaLink 	device 	Custom data object representing CarmaLink
		 * @param Config 		config 	Config object to setup
		 * @return array|NULL
		 */
		protected static function setupConfigParams($device, $config) {
			$a = array();
			if ($device->getUseOdometer())            { $a[] = self::ODOMETER; }
			if ($device->getUseNextServiceDistance()) { $a[] = self::DISTANCE_TO_SERVICE; }
			if ($device->getUseNextServiceDuration()) { $a[] = self::DURATION_TO_SERVICE; }
			if ($device->getUseBatteryVoltage())	  { $a[] = self::BATTERY_VOLTAGE; $a[] = self::BATTERY_VOLTAGE_LOW; }
			if ($device->getUseTirePressure())	  { $a[] = self::TIRE_PRESSURE_LOW; }
			if ($device->getUseEmissionMonitors())    { $a[] = self::EMISSION_MONITORS; }
			if ($device->getUseFuelLevel())           { $a[] = self::FUEL_LEVEL; }

			return (empty($a)) ? NULL : $a;
		}

		/**
		 * Utility method to create a new Config instance based on a device and report type.
		 *
		 * @param CarmaLink				device		A custom data object representing a CarmaLink
		 * @param string|ConfigType 	config_type
		 * @return Config|bool 			return new config object, or false to delete configuration
		 */
		private static function createConfigFromDevice($device, $config_type) {
			$config = new Config();

			if (!$config->setConfigType($config_type)) {
				throw new CarmaLinkAPIException("Invalid configuration type : " . $config_type);
			}

			$config->buzzer   = (string)$device->getBuzzerVolume();
			$config->location = (bool)  $device->getUseGps();

			switch ($config->_config_type) {

				case ConfigType::CONFIG_DIGITAL_INPUT_0:
				case ConfigType::CONFIG_DIGITAL_INPUT_1:
				case ConfigType::CONFIG_DIGITAL_INPUT_2:
				case ConfigType::CONFIG_DIGITAL_INPUT_3:
				case ConfigType::CONFIG_DIGITAL_INPUT_4:
				case ConfigType::CONFIG_DIGITAL_INPUT_5:
				case ConfigType::CONFIG_DIGITAL_INPUT_6:
					/* TBD */
					return FALSE;
					break;
				
				case ConfigType::CONFIG_DRIVER_LOG:
					/* TBD */
					return FALSE;
					break;

				case ConfigType::CONFIG_GREEN_BAND:
					/* TBD */
					return FALSE;
					break;
				
				case ConfigType::CONFIG_HARD_ACCEL:
					if ((int)$device->getAccelLimit_Mpss() === 0) { return FALSE; }
					$config->threshold = $device->getAccelLimit_Mpss();
					$config->allowance = $device->getAccelLimitAllowance_Msec();
					break;

				case ConfigType::CONFIG_HARD_BRAKING:
					if ((int)$device->getBrakeLimit_Mpss() === 0) { return FALSE; }
					$config->threshold = $device->getBrakeLimit_Mpss();
					$config->allowance = $device->getBrakeLimitAllowance_Msec();
					break;

				case ConfigType::CONFIG_HARD_CORNERING:
					if ((int)$device->getCorneringLimit_Mpss() === 0) { return FALSE; }
					$config->threshold = $device->getCorneringLimit_Mpss();
					$config->allowance = $device->getCorneringLimitAllowance_Msec();
					break;
				
				case ConfigType::CONFIG_STATUS:
					if ((int)$device->getPingTime_Msec() < ConfigType::CONFIG_STATUS_MINIMUM_PING) { return FALSE; }
					$config->threshold = $device->getPingTime_Msec();
					$config->params = $device->getUseBatteryVoltage() ? array(self::BATTERY_VOLTAGE) : NULL;
					break;

				case ConfigType::CONFIG_IDLING:
					if ((int)$device->getIdleTimeLimit_Msec() < ConfigType::CONFIG_IDLING_MINIMUM_ALLOWANCE) { return FALSE; }
					$config->allowance = $device->getIdleTimeLimit_Msec();
					break;

				case ConfigType::CONFIG_OVERSPEEDING:
					if ((int)$device->getSpeedLimit_kmph() === 0) { return FALSE; }
					$config->threshold = $device->getSpeedLimit_kmph();
					$config->allowance = $device->getSpeedLimitAllowance_Msec();
					break;
				case ConfigType::CONFIG_ENGINE_OVERSPEED:
					if((int)$device->getEngineSpeedLimit_rpm() === 0) { return FALSE; }
					$config->threshold = $device->getEngineSpeedLimit_rpm();
					$config->allowance = $device->getEngineSpeedLimitAllowance_Msec();
					break;
				case ConfigType::CONFIG_PARKING_BRAKE:
					if ($device->getParkingBrakeLimit_kmph() === FALSE) { return FALSE; }
					$config->threshold = $device->getParkingBrakeLimit_kmph();
					$config->allowance = $device->getParkingBrakeLimitAllowance_Msec();
					break;
				case ConfigType::CONFIG_PARKING:
					if($device->getParkingTimeoutThreshold_Msec() == FALSE) { return FALSE; }
					$config->threshold = $device->getParkingTimeoutThreshold_Msec();
					$config->params = array(self::BATTERY_VOLTAGE);//($device->getUseBatteryVoltage() ? array(self::BATTERY_VOLTAGE) : NULL);
					break;
				case ConfigType::CONFIG_SEATBELT:
					if ($device->getSeatbeltLimit_kmph() === FALSE) { return FALSE; }
					$config->threshold = $device->getSeatbeltLimit_kmph();
					$config->allowance = $device->getSeatbeltLimitAllowance_Msec();
					break;

				case ConfigType::CONFIG_TRIP_REPORT:
					if ($device->useTrips == FALSE) { return FALSE; }
					$config->params = self::setupConfigParams($device, $config);
					break;

				case ConfigType::CONFIG_VEHICLE_HEALTH:
					if ($device->useVehicleHealth === FALSE) { return FALSE; }
					$config->params     = self::setupConfigParams($device, $config);
					$config->conditions = $device->getVehicleHealthConditions();
					break;

				case ConfigType::CONFIG_GENERAL:
					$config = new GeneralConfig($device->getFuelType(), $device->getDisplacement_L());
					break;
			}
			return $config;
		}

		/**
		 * Shortcut method which retreives a configuration object and converts to an array.
		 *
		 * @uses Config::createConfigFromDevice()
		 * @uses Config::toArray()
		 *
		 * @param CarmaLink	device		Representation of CarmaLink
		 * @param string|ConfigType		config_type
		 * @return array|bool 			returns array of config parameters or false if it should be deleted
		 */
		public static function getConfigArray($device, $config_type) {
			$newConfig = self::createConfigFromDevice($device, $config_type);
			return ($newConfig !== FALSE) ? $newConfig->toArray() : FALSE;
		}

		/**
		 * Static factory
		 * 
		 * @param string|stdClass 	obj 			Either a JSON string or a stdClass object representing a Config
		 * @param ConfigType 		config_type 	A valid ConfigType
		 * @return Config
		 */
		public static function Factory($obj, $config_type) {
			if (!$obj) { return FALSE; }

			if (!is_object($obj) && is_string($obj)) {
				try { $obj = json_decode($obj); }
				catch(Exception $e) { throw new CarmaLinkAPIException("Could not instantiate Config with provided JSON data ".$e->getMessage()); }
			}
			// set any missing fields to NULL
			foreach (array("configId","threshold","allowance","location","buzzer","optionalParams","optionalConditions","status") as $prop) {
				$obj->$prop = isset($obj->$prop) ? $obj->$prop : NULL;				
			}
			$config = new Config(
				(int)$obj->configId,
				(float)$obj->threshold,
				(float)$obj->allowance,
				(bool)$obj->location,
				$obj->optionalParams,
				$obj->optionalConditions,
				$obj->status
			);
			$config->buzzer = $obj->buzzer;
			$config->setConfigType($config_type);
			return $config;
		}
	}
	
	/**
	 * Represents a General Configuration for a CarmaLink
	 * 
	 * @class GeneralConfig
	 */
	class GeneralConfig extends Config {
		/**
		 * @access public 
		 * @var CarmaLink\FuelType Type of fuel the attached automobile uses
		 */
		public $fuel = FuelType::FUEL_GASOLINE;
		/**
		 * @access public
		 * @var float	Engine displacement used to correctly calculate fuel effiency etc.
		 */
		public $displacement_L = 2.0;
		
		/**
		 * Constructor
		 * @param string Type of fuel
		 * @param float	Engine displacement
		 * @return void
		 */
		public function __construct($fuel = FuelType::FUEL_GASOLINE, $displacement_L = 2.0) {
			$this->__api_version   = CarmaLinkAPI::API_VERSION;
			$this->fuel            = $fuel;
			$this->displacement_L  = $displacement_L;
		}
		
		/**
		 * Converts object to associative array.
		 *
		 * @return array
		 */
		public function toArray() { return array("fuel" => $this->fuel, "displacement" => $this->displacement_L); }		
	}
	
