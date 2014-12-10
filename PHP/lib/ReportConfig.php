<?php
namespace CarmaLink;

	/**
	 * Represents a CarmaLink configuration.
	 *
	 * @class ReportConfig
	 */
	class ReportConfig {

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
		const FUEL_RATE            = "FUEL_RATE";

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
		public function setReportConfigType($config_type) {
			if ($config_type === $this->_config_type || !ConfigType::isValidReportConfigType($config_type)) { return false; }
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
			if ($this->threshold !== NULL)  { $a[self::API_THRESHOLD]  = (float) $this->threshold; }
			if ($this->allowance !== NULL)  { $a[self::API_ALLOWANCE]  = (float) $this->allowance; }
			if ($this->params !== NULL)     { $a[self::API_PARAMS] = (!empty($this->params) ? $this->params : null); }
			if ($this->location !== NULL)   { $a[self::API_LOCATION]   = (bool)$this->location; }
			if ($this->conditions !== NULL) { $a[self::API_CONDITIONS] = $this->conditions; }

			if      ($this->hasBuzzerConfig() && ($this->buzzer !== NULL))
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
			if (method_exists($device, "getUseOdometer" && 
				$device->getUseOdometer())            { $a[] = self::ODOMETER; }

			if (method_exists($device, "getUseNextServiceDistance" && 
				$device->getUseNextServiceDistance()) { $a[] = self::DISTANCE_TO_SERVICE; }

			if (method_exists($device, "getUseNextServiceDuration" && 
				$device->getUseNextServiceDuration()) { $a[] = self::DURATION_TO_SERVICE; }

			if (method_exists($device, "getUseBatteryVoltage" && 
				$device->getUseBatteryVoltage())	  { $a[] = self::BATTERY_VOLTAGE; $a[] = self::BATTERY_VOLTAGE_LOW; }

			if (method_exists($device, "getUseTirePressure" && 
				$device->getUseTirePressure())	      { $a[] = self::TIRE_PRESSURE_LOW; }

			if (method_exists($device, "getUseEmissionMonitors" && 
				$device->getUseEmissionMonitors())    { $a[] = self::EMISSION_MONITORS; }

			if (method_exists($device, "getUseFuelLevel" && 
				$device->getUseFuelLevel())           { $a[] = self::FUEL_LEVEL; }

			return $a;
		}

		/**
		 * Utility method to create a new Config instance based on a vehicle device and report type. assets don't have any of these configurations, so nothing happens there.
		 *
		 * @param VehicleCarmaLink		device		A custom data object representing a VehicleCarmaLink
		 * @param string|ConfigType 	config_type
		 * @return Config|bool 			return new config object, or false to delete configuration
		 */
		private static function createConfigFromVehicleDevice(CarmaLink $device, $config_type) {
			$config = new ReportConfig();

			if (!$config->setReportConfigType($config_type)) {
				throw new CarmaLinkAPIException("Invalid configuration type : " . $config_type);
			}
			if($config->hasBuzzerConfig()) {
				$config->buzzer   = (string)$device->getBuzzerVolume();
			}
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
					return NULL;
					break;
				
				case ConfigType::CONFIG_DRIVER_LOG:
					/* TBD */
					return NULL;
					break;

				case ConfigType::CONFIG_GREEN_BAND:
					/* TBD */
					return NULL;
					break;
				
				case ConfigType::CONFIG_HARD_ACCEL:
					if(!method_exists($device, "getAccelLimit_Mpss") ||
					   !method_exists($device, "getAccelLimitAllowance_Msec")) {
						return NULL;
					}
					if ((int)$device->getAccelLimit_Mpss() === 0) { return FALSE; }
					$config->threshold = $device->getAccelLimit_Mpss();
					$config->allowance = $device->getAccelLimitAllowance_Msec();
					break;

				case ConfigType::CONFIG_HARD_BRAKING:
					if(!method_exists($device, "getBrakeLimit_Mpss") ||
					   !method_exists($device, "getBrakeLimitAllowance_Msec")) {
						return NULL;
					}
					if ((int)$device->getBrakeLimit_Mpss() === 0) { return FALSE; }
					$config->threshold = $device->getBrakeLimit_Mpss();
					$config->allowance = $device->getBrakeLimitAllowance_Msec();
					break;

				case ConfigType::CONFIG_HARD_CORNERING:
					if(!method_exists($device, "getCorneringLimit_Mpss") ||
					   !method_exists($device, "getCorneringLimitAllowance_Msec")) {
						return NULL;
					}
					if ((int)$device->getCorneringLimit_Mpss() === 0) { return FALSE; }
					$config->threshold = $device->getCorneringLimit_Mpss();
					$config->allowance = $device->getCorneringLimitAllowance_Msec();
					break;
				
				case ConfigType::CONFIG_STATUS:
					if(!method_exists($device, "getPingTime_Msec")) {
						return NULL;
					}
					if ((int)$device->getPingTime_Msec() < ConfigType::CONFIG_STATUS_MINIMUM_PING) { return FALSE; }
					$config->threshold = $device->getPingTime_Msec();
					$optParams = array();
					if(method_exists($device, "getUseBatteryVoltage") && $device->getUseBatteryVoltage()) { array_push($optParams, self::BATTERY_VOLTAGE); }
					if(method_exists($device, "getUseFuelRate")       && $device->getUseFuelRate())       { array_push($optParams, self::FUEL_RATE);       }
					$config->optParams = $optParams;
					break;

				case ConfigType::CONFIG_IDLING:
					if(!method_exists($device, "getIdleTimeLimit_Msec")) {
						return NULL;
					}
					if ((int)$device->getIdleTimeLimit_Msec() < ConfigType::CONFIG_IDLING_MINIMUM_ALLOWANCE) { return FALSE; }
					$config->allowance = $device->getIdleTimeLimit_Msec();
					break;

				case ConfigType::CONFIG_OVERSPEEDING:
					if(!method_exists($device, "getSpeedLimit_kmph")) {
						return NULL;
					}
					if ((int)$device->getSpeedLimit_kmph() === 0) { return FALSE; }
					$config->threshold = $device->getSpeedLimit_kmph();
					$config->allowance = $device->getSpeedLimitAllowance_Msec();
					break;
				case ConfigType::CONFIG_ENGINE_OVERSPEED:
					if(!method_exists($device, "getEngineSpeedLimit_rpm")) {
						return NULL;
					}
					if((int)$device->getEngineSpeedLimit_rpm() === 0) { return FALSE; }
					$config->threshold = $device->getEngineSpeedLimit_rpm();
					$config->allowance = $device->getEngineSpeedLimitAllowance_Msec();
					break;
				case ConfigType::CONFIG_PARKING_BRAKE:
					if(!method_exists($device, "getParkingBreakLimit_kmph")) {
						return NULL;
					}
					if ($device->getParkingBrakeLimit_kmph() === FALSE) { return FALSE; }
					$config->threshold = $device->getParkingBrakeLimit_kmph();
					$config->allowance = $device->getParkingBrakeLimitAllowance_Msec();
					break;
				case ConfigType::CONFIG_PARKING:
					if(!method_exists($device, "getParkingTimeoutThreshold_Msec")) {
						return NULL;
					}
					if($device->getParkingTimeoutThreshold_Msec() == FALSE) { return FALSE; }
					$config->threshold = $device->getParkingTimeoutThreshold_Msec();
					$optParams = array();
					if(method_exists($device, "getUseBatteryVoltage") && $device->getUseBatteryVoltage()) { array_push($optParams, self::BATTERY_VOLTAGE); }
					$config->params = $optParams;
					break;
				case ConfigType::CONFIG_SEATBELT:
					if(!method_exists($device, "getSeatbeltLimit_kmph") ||
					   !method_exists($device, "getSeatbeltLimitAllowance_Msec")) {
						return NULL;
					}
					if ($device->getSeatbeltLimit_kmph() === FALSE) { return FALSE; }
					$config->threshold = $device->getSeatbeltLimit_kmph();
					$config->allowance = $device->getSeatbeltLimitAllowance_Msec();
					break;

				case ConfigType::CONFIG_TRIP_REPORT:
					if ($device->useTrips == FALSE) { return FALSE; }
					$config->params = self::setupConfigParams($device, $config);
					break;

				case ConfigType::CONFIG_VEHICLE_HEALTH:
					if(!method_exists($device, "getVehicleHealthConditions")){
						return NULL;
					}
					if ($device->useVehicleHealth === FALSE) { return FALSE; }
					$config->params     = self::setupConfigParams($device, $config);
					$config->conditions = $device->getVehicleHealthConditions();
					break;
			}
			return $config;
		}

		/**
		 * Shortcut method which retreives a configuration object and converts to an array.
		 *
		 * @uses ReportConfig::createConfigFromDevice()
		 * @uses ReportConfig::toArray()
		 *
		 * @param CarmaLink	device		Representation of CarmaLink
		 * @param string|ConfigType		config_type
		 * @return array|bool|null		returns array of config parameters or false if it should be deleted, and null if the device does not support that config type.
		 */
		public static function getConfigArray($device, $config_type) {
			$newConfig = self::createConfigFromDevice($device, $config_type);
			return (!$newConfig) ? $newConfig->toArray() : $newConfig;
		}

		/**
		 * Static factory
		 * 
		 * @param string|stdClass 	obj 			Either a JSON string or a stdClass object representing a Config
		 * @param ConfigType 		config_type 	A valid ConfigType
		 * @return ReportConfig
		 */
		public static function Factory($obj, $config_type) {
			if (!$obj) { return FALSE; }

			if (!is_object($obj) && is_string($obj)) {
				try { $obj = json_decode($obj); }
				catch(Exception $e) { throw new CarmaLinkAPIException("Could not instantiate ReportConfig with provided JSON data ".$e->getMessage()); }
			}
			// set any missing fields to NULL
			foreach (array("configId","threshold","allowance","location","buzzer","optionalParams","optionalConditions","status") as $prop) {
				$obj->$prop = isset($obj->$prop) ? $obj->$prop : NULL;				
			}
			$config = new ReportConfig(
				(int)$obj->configId,
				(float)$obj->threshold,
				(float)$obj->allowance,
				(bool)$obj->location,
				$obj->optionalParams,
				$obj->optionalConditions,
				$obj->status
			);
			if($obj->buzzer) {
				$config->buzzer = $obj->buzzer; }
			$config->setReportConfigType($config_type);
			return $config;
		}
	}
	
	
