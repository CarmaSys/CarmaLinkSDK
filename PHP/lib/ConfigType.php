<?php
namespace CarmaLink;

	/**
	 * Type of CarmaLink configuration.
	 *
	 * When querying the API by either retrieving data or setting the CarmaLink,
	 * one of the class constants should be used as the report_type parameter.
	 *
	 * @class ConfigType
	 */
	class ConfigType {

		const CONFIG_IDLING_MINIMUM_ALLOWANCE = 5000; // 5 seconds
		const CONFIG_STATUS_MINIMUM_PING = 5000; // 5 seconds

		const CONFIG_OVERSPEEDING 	= 'overspeeding';
		const CONFIG_IDLING			= 'idling';
		const CONFIG_STATUS			= 'status';
		const CONFIG_HARD_BRAKING	= 'hard_braking';
		const CONFIG_HARD_ACCEL		= 'hard_accel';
		const CONFIG_HARD_CORNERING	= 'hard_cornering';
		const CONFIG_TRIP_REPORT	= 'trip_report';
		const CONFIG_NEW_DEPLOYMENT	= 'new_deployment';
		const CONFIG_REVERSE		= 'reverse';
		const CONFIG_PARKINGBRAKE	= 'parking_brake';
		const CONFIG_SEATBELT		= 'seatbelt';
		const CONFIG_VEHICLE_HEALTH = 'vehicle_health';
		const CONFIG_GENERAL		= 'general_config';
		
		/**
		 * @access public
		 * @var array Configuration types which use the buzzer property.
		 */
		public static $buzzer_config_types = array(
			self::CONFIG_IDLING,
			self::CONFIG_OVERSPEEDING,
			self::CONFIG_HARD_BRAKING,
			self::CONFIG_HARD_CORNERING,
			self::CONFIG_HARD_ACCEL,
			self::CONFIG_REVERSE,
			self::CONFIG_PARKINGBRAKE,
			self::CONFIG_SEATBELT
		);

		/**
		 * @access public
		 * @var array
		 */
		public static $valid_config_types = array(
			self::CONFIG_OVERSPEEDING, 
			self::CONFIG_IDLING, 
			self::CONFIG_STATUS, 
			self::CONFIG_HARD_BRAKING, 
			self::CONFIG_HARD_ACCEL,
			self::CONFIG_HARD_CORNERING,
			self::CONFIG_TRIP_REPORT,
			self::CONFIG_NEW_DEPLOYMENT,
			self::CONFIG_REVERSE,
			self::CONFIG_PARKINGBRAKE,
			self::CONFIG_SEATBELT,
			self::CONFIG_GENERAL,
			self::CONFIG_VEHICLE_HEALTH
		);
	
		/**
		 * @access public
		 * @var array
		 */
		public static $allowance_config_types = array(
			self::CONFIG_OVERSPEEDING, 
			self::CONFIG_HARD_BRAKING,
			self::CONFIG_HARD_CORNERING,
			self::CONFIG_HARD_ACCEL,
			self::CONFIG_REVERSE,
			self::CONFIG_PARKINGBRAKE,
			self::CONFIG_SEATBELT
		);

		/**
		 * Helper to determine if a string matches a valid configuration type.
		 *
		 * @param string|ConfigType 	config_type
		 * @return bool
		 */
		public static function validConfigType($config_type) {
			return (array_search($config_type, self::$valid_config_types) !== false);
		}

		/**
		 * Helper to determine if a string matches a valid configuration type.
		 *
		 * @param string|ConfigType 	config_type
		 * @return bool
		 */
		public static function allowanceConfigType($config_type) {
			return (array_search($config_type, self::$allowance_config_types) !== false);
		}

		/**
		 * Helper to determine if a configuration type uses the buzzer property.
		 *
		 * @param string|ConfigType 	config_type
		 * @return bool
		 */
		public static function buzzerConfigType($config_type) {
			return (array_search($config_type, self::$buzzer_config_types) !== false);
		}

	}
	