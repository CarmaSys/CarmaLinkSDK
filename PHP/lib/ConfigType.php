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

		const CONFIG_DIGITAL_INPUT_X = 'digital_input_';
		const CONFIG_DIGITAL_INPUT_0 = 'digital_input_0';
		const CONFIG_DIGITAL_INPUT_1 = 'digital_input_1';
		const CONFIG_DIGITAL_INPUT_2 = 'digital_input_2';
		const CONFIG_DIGITAL_INPUT_3 = 'digital_input_3';
		const CONFIG_DIGITAL_INPUT_4 = 'digital_input_4';
		const CONFIG_DIGITAL_INPUT_5 = 'digital_input_5';
		const CONFIG_DIGITAL_INPUT_6 = 'digital_input_6';
		const CONFIG_DRIVER_LOG      = 'driver_log';
		const CONFIG_GREEN_BAND      = 'green_band';
		const CONFIG_HARD_ACCEL      = 'hard_accel';
		const CONFIG_HARD_BRAKING    = 'hard_braking';
		const CONFIG_HARD_CORNERING  = 'hard_cornering';
		const CONFIG_STATUS          = 'status';
		const CONFIG_IDLING          = 'idling';
		const CONFIG_OVERSPEEDING    = 'overspeeding';
		const CONFIG_PARKING_BRAKE   = 'parking_brake';
		const CONFIG_SEATBELT        = 'seatbelt';
		const CONFIG_TRIP_REPORT     = 'trip_report';
		const CONFIG_VEHICLE_HEALTH  = 'vehicle_health';

		const CONFIG_NEW_DEPLOYMENT  = 'new_deployment';
		const CONFIG_GENERAL         = 'general_config';
		
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
			self::CONFIG_PARKING_BRAKE,
			self::CONFIG_SEATBELT
		);

		/**
		 * @access public
		 * @var array
		 */
		public static $valid_config_types = array(
			self::CONFIG_DIGITAL_INPUT_0,
			self::CONFIG_DIGITAL_INPUT_1,
			self::CONFIG_DIGITAL_INPUT_2,
			self::CONFIG_DIGITAL_INPUT_3,
			self::CONFIG_DIGITAL_INPUT_4,
			self::CONFIG_DIGITAL_INPUT_5,
			self::CONFIG_DIGITAL_INPUT_6,
			self::CONFIG_DRIVER_LOG,
			self::CONFIG_GREEN_BAND,
			self::CONFIG_HARD_ACCEL,
			self::CONFIG_HARD_BRAKING,
			self::CONFIG_HARD_CORNERING,
			self::CONFIG_STATUS, 
			self::CONFIG_IDLING, 
			self::CONFIG_OVERSPEEDING, 
			self::CONFIG_PARKING_BRAKE,
			self::CONFIG_SEATBELT,
			self::CONFIG_TRIP_REPORT,
			self::CONFIG_VEHICLE_HEALTH,
			self::CONFIG_NEW_DEPLOYMENT,
			self::CONFIG_GENERAL,
		);
	
		/**
		 * @access public
		 * @var array
		 */
		public static $allowance_config_types = array(
			self::CONFIG_DIGITAL_INPUT_0,
			self::CONFIG_DIGITAL_INPUT_1,
			self::CONFIG_DIGITAL_INPUT_2,
			self::CONFIG_DIGITAL_INPUT_3,
			self::CONFIG_DIGITAL_INPUT_4,
			self::CONFIG_DIGITAL_INPUT_5,
			self::CONFIG_DIGITAL_INPUT_6,
			self::CONFIG_GREEN_BAND,
			self::CONFIG_HARD_ACCEL,
			self::CONFIG_HARD_BRAKING,
			self::CONFIG_HARD_CORNERING,
			self::CONFIG_STATUS, 
			self::CONFIG_IDLING, 
			self::CONFIG_OVERSPEEDING, 
			self::CONFIG_PARKING_BRAKE,
			self::CONFIG_SEATBELT
		);

		/**
		 * Helper to determine if a string matches a valid configuration type.
		 *
		 * @param string|ConfigType 	config_type
		 * @return bool
		 */
		public static function isValidConfigType($config_type) { return (array_search($config_type, self::$valid_config_types) !== false); }

		/**
		 * Helper to determine if a string matches a valid configuration type.
		 *
		 * @param string|ConfigType 	config_type
		 * @return bool
		 */
		public static function isAllowanceConfigType($config_type) { return (array_search($config_type, self::$allowance_config_types) !== false); }

		/**
		 * Helper to determine if a configuration type uses the buzzer property.
		 *
		 * @param string|ConfigType 	config_type
		 * @return bool
		 */
		public static function isBuzzerConfigType($config_type) { return (array_search($config_type, self::$buzzer_config_types) !== false); }
	}
	