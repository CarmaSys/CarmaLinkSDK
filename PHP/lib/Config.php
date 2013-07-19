<?php
namespace CarmaLink;

	/**
	 * Represents a CarmaLink configuration.
	 *
	 * @class Config
	 */
	class Config {

		const API_THRESHOLD		= 'threshold';
		const API_ALLOWANCE		= 'allowance';
		const API_LOCATION		= 'location';
		const API_BUZZER		= 'buzzer';
		const API_DELETE_CONFIG	= 'OFF';
		const API_PARAMS		= 'optionalParams';
		const API_CONDITIONS	= 'optionalConditions';

		const ODOMETER = "ODOMETER";
		const DURATION_TO_SERVICE = "DURATION_TO_SERVICE";
		const DISTANCE_TO_SERVICE = "DISTANCE_TO_SERVICE";
		const EMISSION_MONITORS = "EMISSION_MONITORS";
		const FUEL_LEVEL = "FUEL_LEVEL";
		const SPEEDING ="SPEEDING";
		const TIRE_PRESSURE_CHANGE = "TIRE_PRESSURE_CHANGE";

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
		public function __construct($id = 0, $threshold = 0, $allowance = 0, $location = false, $params = NULL, $conditions = NULL, $state = NULL) {
			$this -> id = $id;
			$this -> __api_version = CarmaLinkAPI::API_VERSION;
			$this -> threshold = $threshold;
			$this -> allowance = $allowance;
			$this -> location = $location;
			$this -> params = $params;
			$this -> conditions = $conditions;
			if($state) {
				$this -> state = $state;
			}
		}

		/**
		 * Sets the protected member variable if valid.
		 *
		 * @param string|ConfigType		config_type
		 * @return bool
		 */
		public function setConfigType($config_type) {
			if ($config_type === $this -> _config_type || !ConfigType::validConfigType($config_type))
				return false;
			$this -> _config_type = $config_type;
			return true;
		}

		/**
		 * Converts object to associative array.
		 *
		 * @return array
		 */
		public function toArray() {
			$configArray = (!in_array($this -> _config_type,array(ConfigType::CONFIG_TRIP_REPORT, ConfigType::CONFIG_VEHICLE_HEALTH))) ? 
				array(self::API_THRESHOLD => (float)$this -> threshold, self::API_ALLOWANCE => (float)$this -> allowance ) : 
					array( self::API_PARAMS => (!empty($this -> params) ? $this -> params : null) );

			$configArray[self::API_LOCATION] = (bool)$this -> location;

			if(is_array($this -> conditions) && !empty($this -> conditions)) {
				$configArray[self::API_CONDITIONS] = $this -> conditions; 
			}
			
			if ($this -> hasBuzzerConfig()) {
				$configArray[self::API_BUZZER] = (string)$this -> buzzer;
			}
			return $configArray;
		}

		/**
		 * Determines if current configuration type utilizes a buzzer property.
		 *
		 * @return bool
		 */
		public function hasBuzzerConfig() {
			return ConfigType::buzzerConfigType($this -> _config_type);
		}


		/**
		 * Utility to setup a config's optional parameters based on a device
		 *
		 * @param CarmaLink 	device 	Custom data object representing CarmaLink
		 * @param Config 		config 	Config object to setup
		 * @return array|NULL
		 */
		protected static function setupConfigParams($device, $config) {
			$params = array();
			if($device->getUseOdometer()) {
				$params[] = self::ODOMETER;
			}
			if($device->getUseNextServiceDistance()) {
				$params[] = self::DISTANCE_TO_SERVICE;
			}
			if($device->getUseNextServiceDuration()) {
				$params[] = self::DURATION_TO_SERVICE;
			}
			if($device->getUseEmissionMonitors()) {
				$params[] = self::EMISSION_MONITORS;
			}
			if($device->getUseFuelLevel()) {
				$params[] = self::FUEL_LEVEL;
			}
			if(empty($params)) {
				return NULL;
			}
			return $params;
		}

		/**
		 * Utility method to create a new Config instance based on a device and report type.
		 * @deprecated To be deprecated in 1.4.0
		 *
		 * @deprecated This method will become deprecated in version 1.4.0
		 *
		 * @param CarmaLink				device		A custom data object representing a CarmaLink
		 * @param string|ConfigType 	config_type
		 * @return Config|bool 			return new config object, or false to delete configuration
		 */
		public static function createConfigFromDevice($device, $config_type) {
			$config = new Config();

			if (!$config -> setConfigType($config_type)) {
				throw new CarmaLinkAPIException('Invalid configuration type : ' . $config_type);
			}

			$config -> buzzer = (string)$device -> getBuzzerVolume();
			$config -> location = (bool)$device -> getUseGPS();

			switch ($config->_config_type) {
				
				case ConfigType::CONFIG_STATUS :
					if( (int)$device -> getPingTime() < ConfigType::CONFIG_STATUS_MINIMUM_PING )
						return FALSE;
					$config -> threshold = $device -> getPingTime();
					break;

				case ConfigType::CONFIG_VEHICLE_HEALTH :
					if($device -> getVehicleHealthConditions() === FALSE) {
						return FALSE;
					}
					$config -> params = self::setupConfigParams($device, $config);
					$config -> conditions  = $device->getVehicleHealthConditions();
					break;

				case ConfigType::CONFIG_TRIP_REPORT :
					$config -> params = self::setupConfigParams($device, $config);
					break;

				case ConfigType::CONFIG_OVERSPEEDING :
					if( (int)$device -> speedLimit === 0 )
						return FALSE;
					$config -> threshold = $device -> getSpeedLimit();
					$config -> allowance = $device -> getSpeedLimitAllowance();
					break;
				
				case ConfigType::CONFIG_HARD_CORNERING :
					if( (int)$device -> getCorneringLimit() === 0 )
						return FALSE;
					$config -> threshold = $device -> getCorneringLimit();
					$config -> allowance = $device -> getCorneringLimitAllowance();
					break;
				
				case ConfigType::CONFIG_HARD_BRAKING :
					if( (int)$device -> getBrakeLimit() === 0 )
						return FALSE;
					$config -> threshold = $device -> getBrakeLimit();
					$config -> allowance = $device -> getBrakeLimitAllowance();
					break;

				case ConfigType::CONFIG_HARD_ACCEL :
					if( (int)$device -> getAccelLimit() === 0 )
						return FALSE;
					$config -> threshold = $device -> getAccelLimit();
					$config -> allowance = $device -> getAccelLimitAllowance();
					break;

				case ConfigType::CONFIG_PARKINGBRAKE :
					if( $device -> getParkingBrakeLimit() === FALSE )
						return FALSE;
					$config -> threshold = $device -> getParkingBrakeLimit();
					$config -> allowance = $device -> getParkingBrakeLimitAllowance();
					break;

				case ConfigType::CONFIG_SEATBELT :
					if( $device -> getSeatbeltLimit() === FALSE )
						return FALSE;
					$config -> threshold = $device -> getSeatbeltLimit();
					$config -> allowance = $device -> getSeatbeltLimitAllowance();
					break;

				case ConfigType::CONFIG_IDLING :
					if( (int)$device -> getIdleTimeLimit() < ConfigType::CONFIG_IDLING_MINIMUM_ALLOWANCE)
						return FALSE;
					$config -> allowance = $device -> getIdleTimeLimit();
					break;

				case ConfigType::CONFIG_GENERAL :
					$config = new GeneralConfig( $device->getFuelType(), $device->getDisplacement() );
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
			return ($newConfig !== FALSE) ? $newConfig -> toArray() : FALSE;
		}

		/**
		 * Static factory
		 * 
		 * @param string|stdClass 	obj 			Either a JSON string or a stdClass object representing a Config
		 * @param ConfigType 		config_type 	A valid ConfigType
		 * @return Config
		 */
		public static function Factory($obj,$config_type) {
			if(!$obj) return FALSE;

			if(!is_object($obj) && is_string($obj)) {
				try {
					$obj = json_decode($obj);
				} catch(Exception $e) {
					throw new CarmaLinkAPIException("Could not instantiate Config with provided JSON data ".$e->getMessage());	
				}
			}
			foreach (array('configId','threshold','allowance','location','buzzer','optionalParams','optionalConditions','status') as $prop) {
				$obj -> $prop = isset($obj -> $prop) ? $obj -> $prop : NULL;				
			}
			$config = new Config(
				(int)$obj -> configId,
				(float)$obj -> threshold,
				(float)$obj -> allowance,
				(bool)$obj -> location,
				$obj -> optionalParams,
				$obj -> optionalConditions,
				$obj -> status
			);
			$config -> buzzer = $obj -> buzzer;
			$config -> setConfigType($config_type);
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
		public $displacement = 2.0;
		
		/**
		 * Constructor
		 * @param string Type of fuel
		 * @param float	Engine displacement
		 * @return void
		 */
		public function __construct($fuel = FuelType::FUEL_GASOLINE, $displacement = 2.0) {
			$this -> __api_version = CarmaLinkAPI::API_VERSION;
			$this -> fuel = $fuel;
			$this -> displacement = $displacement;
		}
		
		/**
		 * Converts object to associative array.
		 *
		 * @return array
		 */
		public function toArray() {
			return array("fuel" => $this -> fuel, "displacement" => $this -> displacement);
		}
		
	}