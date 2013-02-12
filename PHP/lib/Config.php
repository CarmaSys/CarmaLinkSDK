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

		const ODOMETER = "ODOMETER";
		const DURATION_TO_SERVICE = "DURATION_TO_SERVICE";
		const DISTANCE_TO_SERVICE = "DISTANCE_TO_SERVICE";
		const SPEEDING ="SPEEDING";

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
		 * @return void
		 */
		public function __constructor($threshold = 0, $allowance = 0, $location = false) {
			$this -> __api_version = CarmaLinkAPI::API_VERSION;
			$this -> threshold = $threshold;
			$this -> allowance = $allowance;
			$this -> location = $location;
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
			$configArray = ($this -> _config_type !== ConfigType::CONFIG_TRIP_REPORT ) ? 
				array(self::API_THRESHOLD => (float)$this -> threshold, self::API_ALLOWANCE => (float)$this -> allowance ) : 
					array( self::API_PARAMS => (!empty($this -> params) ? $this -> params : null) );
			$configArray[self::API_LOCATION] = (bool)$this -> location;
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
		 * Utility method to create a new Config instance based on a device and report type.
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

				case ConfigType::CONFIG_TRIP_REPORT :
					$params =array();
					if($device->getUseOdometer()) {
						$params[] = self::ODOMETER;
					}
					if($device->getUseNextServiceDistance()) {
						$params[] = self::DISTANCE_TO_SERVICE;
					}
					if($device->getUseNextServiceDuration()) {
						$params[] = self::DURATION_TO_SERVICE;
					}
					if(!empty($params))
						$config -> params = $params;
					break;

				case ConfigType::CONFIG_ENGINE_FAULT :
					if(!$device -> getCheckEngineLight())
						return FALSE;
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