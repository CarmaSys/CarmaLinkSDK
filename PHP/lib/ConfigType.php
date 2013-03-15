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
		const CONFIG_TRIP_REPORT	= 'trip_report';
		const CONFIG_NEW_DEPLOYMENT	= 'new_deployment';
		const CONFIG_GENERAL		= 'general_config';
		/**
		 * @deprecated CONFIG_ENGINE_FAULT as of 1.4.0 
		 */
		const CONFIG_ENGINE_FAULT	= 'engine_fault';
		
		/**
		 * @access public
		 * @var array Configuration types which use the buzzer property.
		 */
		public static $buzzer_config_types = array(
			self::CONFIG_IDLING,
			self::CONFIG_OVERSPEEDING,
			self::CONFIG_HARD_BRAKING,
			self::CONFIG_HARD_ACCEL
		);

		/**
		 * @access public
		 * @var array
		 */
		public static $valid_config_types = array(
			self::CONFIG_OVERSPEEDING, 
			self::CONFIG_IDLING, 
			self::CONFIG_STATUS, 
			self::CONFIG_ENGINE_FAULT, 
			self::CONFIG_HARD_BRAKING, 
			self::CONFIG_HARD_ACCEL,
			self::CONFIG_TRIP_REPORT,
			self::CONFIG_NEW_DEPLOYMENT,
			self::CONFIG_GENERAL
		);
	
		/**
		 * @access public
		 * @var array
		 */
		public static $allowance_config_types = array(
			self::CONFIG_OVERSPEEDING, 
			self::CONFIG_HARD_BRAKING, 
			self::CONFIG_HARD_ACCEL
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
	