<?php

/**
 * CarmaLink SDK for PHP
 *
 * @version 1.5.0
 *
 * @author Christopher Najewicz <chris.najewicz@carmasys.com>
 * @license MIT
 *
 */

namespace CarmaLink {
	
	/**
	 * OAuth-PHP (MIT License) is required to use this library.
	 *
	 * @see http://code.google.com/p/oauth-php/ This library uses oauth-php.
	 */
	require_once  realpath(__DIR__ . '/oauth-php/library/OAuthStore.php');
	require_once  realpath(__DIR__ . '/oauth-php/library/OAuthRequester.php');
	
	require_once realpath(__DIR__. '/lib/CarmaLink.php');
	require_once realpath(__DIR__. '/lib/ConfigType.php');
	require_once realpath(__DIR__. '/lib/Config.php');
	require_once realpath(__DIR__. '/lib/CarmaLinkAPI.php');

	/**
	 * Exception class exclusive to this namespace.
	 *
	 * @class CarmaLinkAPIException
	 * @todo Add custom error codes, perhaps include any HTTP codes received.
	 */
	class CarmaLinkAPIException extends \Exception {
		const INVALID_API_KEYS_PROVIDED = "The API key or API secret provided was incorrect.";
		/**
		 * Constructor
		 *
		 * @param string		message		Exception message
		 * @return void
		 */
		public function __construct($message) {
			parent::__construct($message);
		}

	}

	/**
	 * Emulates an enum which defines the status of a CarmaLink configuration.
	 *
	 * @class ConfigStatus
	 */
	class ConfigStatus {
		const UNKNOWN_STATUS = 0;
		const PENDING_ACTIVATION = 1;
		const ACTIVATED = 2;
		const PENDING_DEACTIVATION = 3;
		const DEACTIVATED = 4;
	}

	/**
	 * When sending configurations for buzzer volume, please use these constants.
	 *
	 * @class BuzzerVolume
	 */
	class BuzzerVolume {
		const BUZZER_HIGH = "HIGH";
		const BUZZER_MED = "MEDIUM";
		const BUZZER_OFF = "OFF";
	}
	
	/**
	 * Type of fuel automobile uses.
	 * 
	 * When setting or getting the CONFIG_GENERAL fuel parameters, use these values.
	 * 
	 * @class FuelType
	 */
	class FuelType {
		const FUEL_GASOLINE	= "FUEL_GASOLINE";
		const FUEL_DIESEL	= "FUEL_DIESEL";
	}

} // End of namespace CarmaLink
