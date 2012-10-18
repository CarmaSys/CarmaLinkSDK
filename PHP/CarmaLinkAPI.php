<?php

/**
 * CarmaLink SDK for PHP
 *
 * @version 0.0.1
 * 
 * @author Christopher Najewicz <chris.najewicz@carmasys.com>
 * @license MIT
 * 
 * @todo debug logging
 * 
 */

namespace CarmaLink {

/**
 * OAuth-PHP (MIT License) is required to use this library.
 *
 * @see http://code.google.com/p/oauth-php/ This library uses oauth-php.
 */
require_once realpath(__DIR__.'/oauth-php/library/OAuthStore.php');
require_once realpath(__DIR__.'/oauth-php/library/OAuthRequester.php');

/**
 * "Abstract" class representing minimum properties of a CarmaLink
 * 
 * This class represents a possible starting point for an abstraction
 * of a CarmaLink. The getters/setters below are required for some of 
 * the functionality in this SDK.
 *  
 * @class CarmaLink
 */
abstract class CarmaLink 
{
	
	/**
	 * Set CarmaLink ID or serial number
	 * @param int	id	serial number of CarmaLink
	 * @return void
	 */
	public function setID($id)
	{
		if($this->id === $id) return;
		$this->id = (int)$id;
	}
	/**
	 * CarmaLink's serial / ID
	 * @return int
	 */
	public function getID()
	{
		return $this->id;
	}
	
	/**
	 * Set CarmaLink engine fault
	 * @param bool		checkEngineLight	Use engine fault
	 * @return void
	 */
	public function setCheckEngineLight($checkEngineLight = false)
	{
		$this->checkEngineLight = (bool)$checkEngineLight;
	}
	/**
	 * Get CarmaLink engine fault config
	 * @return bool
	 */
	public function getCheckEngineLight()
	{
		return $this->checkEngineLight;
	}
	
	/**
	 * Set CarmaLink global buzzer volume
	 * Can be used to override when setting a configuration which supports buzzer.
	 * @param BuzzerVolume	buzzerVolume	HIGH/MED/OFF
	 * @return void
	 */
	public function setBuzzerVolume($buzzerVolume = BuzzerVolume::BUZZER_OFF)
	{
		$this->buzzerVolume = $buzzerVolume;
	}
	/**
	 * Get global CarmaLink volume setting
	 * @return BuzzerVolume	HIGH/MED/OFF
	 */
	public function getBuzzerVolume()
	{
		return $this->buzzerVolume;
	}
	
	/**
	 * Set CarmaLink location tracking / GPS functionality
	 * @param bool	useGPS	On/Off
	 * @return void
	 */
	public function setUseGPS($useGPS)
	{
		$this->useGPS = (bool)$useGPS;
	}
	/**
	 * Get CarmaLink location functionality
	 * @return bool
	 */
	public function getUseGPS() 
	{
		return $this->useGPS;
	}

	/**
	 * Sets the CarmaLink's update interval
	 * @param int	pingTime	The update interval in milliseconds
	 * @return void
	 */
	public function setPingTime($pingTime = 5000)
	{
		$this->pingTime = (int)$pingTime;
	}
	/**
	 * Gets the CarmaLink's update interval 
	 * @return int	milliseconds
	 */
	public function getPingTime() 
	{
		return $this->pingTime;
	}
	
	/**
	 * Set CarmaLink speed limit
	 * @param int		speedLimit		Speed in Km/h
	 * @return void
	 */
	public function setSpeedLimit($speedLimit = 0)
	{
		$this->speedLimit = (int)$speedLimit;
	}
	/**
	 * Get CarmaLink speed limit
	 * @return int	Km/h limit
	 */
	public function getSpeedLimit()
	{
		return $this->speedLimit;
	}
	
	/**
	 * Set CarmaLink brake limit
	 * @param float		brakeLimit		Limit in G's
	 * @return void
	 */
	public function setBrakeLimit($brakeLimit = 0.0)
	{
		$this->brakeLimit = (float)$brakeLimit;
	}
	/**
	 * Get CarmaLink brake limit
	 * @return float	In G's
	 */
	public function getBrakeLimit()
	{
		return $this->brakeLimit;
	}
	
	/**
	 * Set CarmaLink acceleration limit
	 * @param float		accelLimit		Limit in G's
	 * @return void
	 */
	public function setAccelLimit($accelLimit = 0.0)
	{
		$this->accelLimit = (float)$accelLimit;
	}
	/**
	 * Get CarmaLink acceleration limit
	 * @return float	In G's
	 */
	public function getAccelLimit()
	{
		return $this->accelLimit;
	}
	
	/**
	 * Set CarmaLink idle time limit
	 * @param int	idleTimeLimit	in milliseconds
	 * @return void
	 */
	public function setIdleTimeLimit($idleTimeLimit = 0)
	{
		$this->idleTimeLimit = (int)$idleTimeLimit;
	}
	/**
	 * Get CarmaLink idle time limit
	 * @return int	milliseconds
	 */
	public function getIdleTimeLimit()
	{
		return $this->idleTimeLimit;
	}
}

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
	const UNKNOWN_STATUS		= 0;
	const PENDING_ACTIVATION 	= 1;
	const ACTIVATED 			= 2;
	const PENDING_DEACTIVATION	= 3;
	const DEACTIVATED			= 4;
}

/**
 * When sending configurations for buzzer volume, please use these constants.
 * 
 * @class BuzzerVolume
 */
class BuzzerVolume {
	const BUZZER_HIGH 	= "HIGH";
	const BUZZER_MED	= "MEDIUM";
	const BUZZER_OFF	= "OFF";
}

/**
 * Type of CarmaLink configuration.
 * 
 * When querying the API by either retrieving data or setting the CarmaLink,
 * one of the class constants should be used as the report_type parameter.
 * 
 * @class ConfigType
 */
class ConfigType {
	const CONFIG_OVERSPEEDING	= 'overspeeding';
	const CONFIG_IDLING			= 'idling';
	const CONFIG_STATUS			= 'status';
	const CONFIG_ENGINE_FAULT	= 'engine_fault';
	const CONFIG_HARD_BRAKING	= 'hard_braking';
	const CONFIG_HARD_ACCEL		= 'hard_accel';
	const CONFIG_TRIP_REPORT	= 'trip_report';
	const CONFIG_NEW_DEPLOYMENT	= 'new_deployment';
	
	/**
	 * @access public
	 * @var array Configuration types which use the buzzer property.
	 */
	public static $buzzer_config_types = array(
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
		self::CONFIG_NEW_DEPLOYMENT
	);
	
	/**
	 * Helper to determine if a string matches a valid configuration type.
	 * 
	 * @param string|ConfigType 	config_type
	 * @return bool
	 */
	public static function validConfigType($config_type) 
	{
		return (array_search($config_type, self::$valid_config_types) !== false);
	}
	
	/**
	 * Helper to determine if a configuration type uses the buzzer property.
	 * 
	 * @param string|ConfigType 	config_type
	 * @return bool
	 */
	public static function buzzerConfigType($config_type)
	{
		return (array_search($config_type, self::$buzzer_config_types) !== false);
	}
	
}

/**
 * Represents a CarmaLink configuration.
 * 
 * @class Config
 */
class Config {

	const API_THRESHOLD	= 'threshold';
	const API_ALLOWANCE	= 'allowance';
	const API_LOCATION	= 'location';
	const API_BUZZER	= 'buzzer'; 
	const API_DELETE_CONFIG	= 'OFF';

	/**
	 * @access public
	 * @var int|float 
	 */
	public $threshold 	= 0;

	/**
	 * @access public
	 * @var int|float
	 */
	public $allowance 	= 0;

	/**
	 * @access public
	 * @var bool
	 */
	public $location 	= false;

	/**
	 * @access public
	 * @var string
	 */
	public $buzzer 		= BuzzerVolume::BUZZER_OFF;

	/**
	 * @access public
	 * @var array
	 */
	public $params		= null;

	/**
	 * @access public
	 * @var ConfigStatus
	 */
	public $state		= ConfigStatus::UNKNOWN_STATUS;
	
	/**
	 * @access protected
	 * @var ConfigType
	 */
	protected $_config_type	= ConfigType::CONFIG_TRIP_REPORT;
	
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
	public function __constructor($threshold = 0, $allowance = 0, $location = false)
	{
		$this->__api_version = CarmaLinkAPI::API_VERSION;
		$this->threshold = $threshold;
		$this->allowance = $allowance;
		$this->location = $location;
	}
	
	/**
	 * Sets the protected member variable if valid.
	 * 
	 * @param string|ConfigType		config_type
	 * @return bool
	 */	
	public function setConfigType($config_type)
	{
		if($config_type === $this->_config_type || !ConfigType::validConfigType($config_type)) return false;
		$this->_config_type = $config_type;		
		return true;
	}
	
	/**
	 * Converts object to associative array.
	 * 
	 * @return array
	 */
	public function toArray()
	{
		$configArray = array(
			self::API_THRESHOLD => (float)$this->threshold,
			self::API_ALLOWANCE => (float)$this->allowance,
			self::API_LOCATION	=> (bool)$this->location
		);
		if($this->hasBuzzerConfig())
		{
			$configArray[self::API_BUZZER] = (string)$this->buzzer;
		}
		return $configArray;
	}
	
	/**
	 * Determines if current configuration type utilizes a buzzer property.
	 * 
	 * @return bool
	 */
	public function hasBuzzerConfig() 
	{
		return ConfigType::buzzerConfigType($this->_config_type);
	}
	
	/**
	 * Utility method to create a new Config instance based on a device and report type.
	 * 
	 * @param CarmaLink				device		A custom data object representing a CarmaLink
	 * @param string|ConfigType 	config_type
	 * @return Config
	 */
	public static function createConfigFromDevice($device, $config_type) 
	{
		$config = new Config();
	
		if(!$config->setConfigType($config_type)) 
		{
			throw new CarmaLinkAPIException('Invalid configuration type : '.$config_type);
			return $config;
		}
		$config->buzzer = (string) $device->getBuzzerVolume();
		$config->location = (bool) $device->getUseGPS();
		
		switch ($config->_config_type) {
			case ConfigType::CONFIG_STATUS:
				$config->threshold = $device->getPingTime();
				break;
				
			case ConfigType::CONFIG_TRIP_REPORT:
				break;

			case ConfigType::CONFIG_ENGINE_FAULT:
				break;

			case ConfigType::CONFIG_OVERSPEEDING:
				$config->threshold = $device->getSpeedLimit();
				break;

			case ConfigType::CONFIG_HARD_BRAKING:
				$config->threshold = $device->getBrakeLimit();
				break;

			case ConfigType::CONFIG_HARD_ACCEL:
				$config->threshold = $device->getAccelLimit();
				break;

			case ConfigType::CONFIG_IDLING:
				$config->allowance = $device->getIdleTimeLimit();
				break;
		}
		
		/***
		 * @todo refactor this, it's bad. Should rely on something else to 
		 * express a config needs to be deleted (chief) 
		*/
		if($config->threshold === self::API_DELETE_CONFIG || $config->allowance === self::API_DELETE_CONFIG)
			return false;
		
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
	 * @return array
	 */
	public static function getConfigArray($device, $config_type) 
	{
		$newConfig = self::createConfigFromDevice($device, $config_type); 
		return ($newConfig !== false) ? $newConfig->toArray() : false;
	}
	
}

/**
 * Main interface to use the CarmaLink API.
 * 
 * @class CarmaLinkAPI
 */
class CarmaLinkAPI 
{
	const API_VERSION = 1;
	
	const API_METHOD_GET 	= 'GET';
	const API_METHOD_PUT 	= 'PUT';
	const API_METHOD_DELETE = 'DELETE';
	
	const RESPONSE_CODE = 'response_code';
	const RESPONSE_BODY	= 'response_body';
	
	const API_METHOD_PUT_SUCCESS	= 204;
	const API_METHOD_SUCCESS 		= 200;

	/**
	 * @access public
	 * @var string	Hostname of API URI
	 */
	public $host;
	
	/**
	 * @access public
	 * @var int		Port to use.
	 */
	public $port = 80;
	
	/**
	 * @access public
	 * @var bool	Whether to use SSL, should be true for production.
	 */
	public $https = false;
	
	/**
	 * @access public
	 * @var bool	Whether to use debug, should be false for production.
	 */
	public $debug = false;
	
	/**
	 * Constructor
	 * 
	 * Creates a new instance of an CarmaLinkAPI based on OAuth keys and server address.
	 * Additionally you can specify if you would like debugging enabled.
	 * 
	 * @param string		consumer_key		Valid API key provided by CarmaSys
	 * @param string 		consumer_secret		Valid API secret provided by CarmaSys
	 * @param array 		server_options		Array of 'HOST','PORT', and 'HTTPS' which the API will use
	 * @param bool 			debug				Enable debugging
	 * @return void
	 */
	public function __construct($consumer_key = null, $consumer_secret = null, $server_options = array(), $debug = false )
	{
		if(!$consumer_key || !$consumer_secret || strlen($consumer_key) === 0 || strlen($consumer_secret) === 0)
		{
			throw new CarmaLinkAPIException(CarmaLinkAPIException::INVALID_API_KEYS_PROVIDED);
		}
		
		$this->host = isset($server_options['HOST']) ? $server_options['HOST'] : null;
		$this->port = isset($server_options['PORT']) ? $server_options['PORT'] : null;
		$this->https = isset($server_options['HTTPS']) ? (bool)$server_options['HTTPS'] : false;
		$this->debug = $debug;
		\OAuthStore::instance("2Leg", array('consumer_key' => $consumer_key, 'consumer_secret' => $consumer_secret));
	}
	
	/**
	 * Gets the relative path to the root endpoint of the API
	 * @return string 
	 */
	public static function getEndpointRelativeRoot() 
	{
		return 'v' . self::API_VERSION;
	}
	
	/**
	 * Gets the root URI for and API endpoint
	 * @return string
	 */
	public function getEndpointRootURI() 
	{
		return 'http' . ($this->https ? 's' : '') . '://' . $this->host . ':' . $this->port ;
	}
	
	/**
	 * If parameter is an array it will join it using "." 
	 * @example sanitizeSerials(array("204",209,300)) // "204.209.300"
	 * @todo Verify serial string is valid
	 * @param int|string|array 		serials		Serial numbers to parse
	 * @return string
	 */
	private function sanitizeSerials($serials)
	{
		if(is_array($serials))
		{
			return implode(".", $serials);
		}
		return $serials;
	}

	/**
	 * Shortcut to getReportData w/ TRUE for the returnAllData param
	 * @param string|int|array 	serials			Serial number(s) of CarmaLink
	 * @param string 			report_type 	Report/view type to query
	 * @param array 			parameters		Key=>value parameters for data filtering to be added to the query string
	 * @return array 			Assoc. array of HTTP response code and HTTP body content 
	 */
	public function getReportDataArray($serials, $report_type, $parameters)
	{
		return $this->getReportData($serials, $report_type, $parameters, TRUE);
	}
	
	/**
	 * Gets a CarmaLink data view/report based on provided parameters.
	 * 
	 * @param string|int|array 	serials			Serial number(s) of CarmaLink
	 * @param string 			report_type 	Report/view type to query
	 * @param array 			parameters		Key=>value parameters for data filtering to be added to the query string
	 * @param bool				returnAllData	If set to true will return assoc. array of HTTP code and HTTP body
	 * @return bool|string|array				If returnAllData param is true will return assoc. array of HTTP code and HTTP body
	 * 											otherwise, will return false on error and a JSON string on success
	 */	
	public function getReportData($serials = 0, $report_type, $parameters = array(), $returnAllData = FALSE) 
	{
		if($serials === 0) return FALSE;
		$serials = $this->sanitizeSerials($serials);
		$uri = $this->getEndpointRootURI() . '/' . $this->getEndpointRelativeRoot() . '/' . $serials . '/data/' . $report_type;
		$response_data = $this->get($uri, $parameters);
		
		if($returnAllData === TRUE) 
		{
			return $response_data;
		}
		
		if( (int)$response_data[self::RESPONSE_CODE] !== self::API_METHOD_SUCCESS)
		{
			return FALSE;
		}
		return $response_data[self::RESPONSE_BODY];
	}
	
	/**
	 * Sets up parameters for a configuration update call
	 * 
	 * @param string|int|array 		serials			Serial number(s) of the CarmaLink(s)
	 * @param string				endpoint		Empty endpoint reference for the API call
	 * @param string 				config_type		Valid configuration type
	 * @return void
	 */
	protected function setupConfigCall(&$serials,&$endpoint, $config_type)
	{
		$serials = $this->sanitizeSerials($serials);
		$endpoint = $this->getEndpointRootURI() . '/' . $this->getEndpointRelativeRoot() . '/' . $serials . '/report_config/' . $config_type;
	}

	/**
	 * Retrieves a configuration object from the CarmaLink based on parameters
	 * 
	 * @param string|int|array		$serials		Serial number(s) of the CarmaLink(s)
	 * @param string				config_type		Valid configuration type
	 * @return bool|string On success returns JSON-formatted object, on failure false
	 */	
	public function getConfig($serials = 0, $config_type)
	{
		if($serials === 0) return false;
		$endpoint = '';
		$this->setupConfigCall($serials, $endpoint, $config_type);
		$response_data = $this->get($endpoint);
		if( (int)$response_data[self::RESPONSE_CODE] !== self::API_METHOD_SUCCESS) {
			return false;
		}
		return $response_data[self::RESPONSE_BODY];
	}
	
	/**
	 * Takes a response array from a putConfig or deleteConfig request 
	 * and returns the proper type / value. Mostly a utility DRY method.
	 * 
	 * @param array 		response_data	Associative array of response code and body
	 * @return bool|string	for single queries will return true/false, for multiple queries will return JSON string
	 */
	private function getProperResponse($response_data = NULL)
	{
		if($response_data === NULL) return false;
		switch ((int)$response_data[self::RESPONSE_CODE]) {
		// For single queries
		case self::API_METHOD_PUT_SUCCESS:
			return true;				
			break;
		// For multiple queries a JSON object is always returned with embedded data
		case self::API_METHOD_SUCCESS:
			$body = $response_data[self::RESPONSE_BODY];
			if(strlen($body) > 0)
				return $response_data[self::RESPONSE_BODY];
			else 
				return true;
		// Otherwise there was an error
		default:
			return false;
			break;
		}
	}
	
	/**
	 * Put / send a CarmaLink a new configuration
	 * 
	 * @param string|int|array		serials			Serial number(s) of the CarmaLink(s)
	 * @param array 				config_array	Array representation of a CarmaLink\Config object
	 * @param string				config_type 	Valid configuration type
	 * @return bool 
	 */
	public function putConfig($serials = 0, $config_array, $config_type)
	{
		if($serials === 0) return false;
		$endpoint = '';
		$this->setupConfigCall($serials, $endpoint, $config_type);
		if(empty($config_array) || !$config_type) {
			throw new CarmaLinkAPIException('API PUT ConfigUpdate was not of type array or not a valid configuration type.');
			return false;	
		} 
		if(!is_array($config_array))
		{
			throw new CarmaLinkAPIException('API PUT ConfigUpdate was not of type array.');
			return false;
		}
		return $this->getProperResponse($this->put($endpoint, $config_array));
	}
	
	/**
	 * Delete a configuration from a CarmaLink
	 * 
	 * @param string|int|array		serials			Serial number of the CarmaLink
	 * @param string 				config_type		Valid configuration type
	 * @return bool
	 */
	public function deleteConfig($serials = 0, $config_type) 
	{
		if($serials === 0) return false;
		$endpoint = '';
		$this->setupConfigCall($serials, $endpoint, $config_type);
		$response_data = $this->delete($endpoint);
		switch ((int)$response_data[self::RESPONSE_CODE]) {
			// For single queries
			case self::API_METHOD_PUT_SUCCESS:
				return true;				
				break;
			// For multiple queries a JSON object is always returned with embedded data
			case self::API_METHOD_SUCCESS:
				return $response_data[self::RESPONSE_BODY];
			// Otherwise there was an error
			default:
				return false;
				break;
		}
	}
	
	/**
	* Performs GET request to API
	* @param string		endpoint
	* @param array 		parameters		Any query string parameters to send 
	* @return array
	*/
	public function get($endpoint, $parameters = NULL) 
	{
		return $this->api($endpoint, self::API_METHOD_GET, $parameters);
	}

	/**
	* Performs PUT request to API
	* @param string		endpoint
	* @param array 		parameters		Associative array of options to send
	* @return array
	*/
	public function put($endpoint, $parameters = NULL)
	{
		return $this->api($endpoint, self::API_METHOD_PUT, $parameters);
	}
	
	/**
	* Performs DELETE request to API
	* @param string		endpoint
	* @return array
	*/
	public function delete($endpoint)
	{
		return $this->api($endpoint, self::API_METHOD_DELETE);
	}
	
	/**
	 * All API requests filter through this method.
	 * @param string		endpoint
	 * @param string 		method			default is 'GET'
	 * @param string[]		parameters		Key=>values to send
	 * @param string[]		options			Array for future consideration
	 * @return (int|string)[]
	 */
	private function api($endpoint, $method = self::API_METHOD_GET, $parameters = NULL, $options = array())
	{
		$put_data = NULL;
		$headers = array();
		if($method === self::API_METHOD_PUT) {
			$put_data = json_encode($parameters);
			$headers = array(CURLOPT_HTTPHEADER=>array('Content-Type: application/json'));
			$parameters = NULL;
		}
		$oauth_request = new \OAuthRequester($endpoint, $method, $parameters, $put_data);
		$response = $oauth_request->doRequest(0,$headers);
		return array(
			self::RESPONSE_CODE => $response['code'],
			self::RESPONSE_BODY => $response['body']
		);
	}
	
	/**
	 * Updates a device based on a CarmaLinkDevice object
	 * @todo finish method
	 * @param 		CarmaLinkDevice		Object representing a CarmaLink 
	 * @return bool
	 */
	public function updateDevice($device)
	{
		$configsToUpdate = array(
			ConfigType::CONFIG_ENGINE_FAULT,
			ConfigType::CONFIG_HARD_BRAKING,
			ConfigType::CONFIG_HARD_ACCEL,
			ConfigType::CONFIG_IDLING,
			ConfigType::CONFIG_OVERSPEEDING
		);

		foreach ($configsToUpdate as $config_type) {
			$configParams = Config::getConfigArray($device, $config_type);	
			if($configParams === false)
			{
				if(!$this->deleteConfig($device->id, $config_type))
				{
					// If a 404 is returned here I think it simply means no config was set.
					//	throw new Exception('Could not delete '.$config_type.' config for '.$device->id);
				}	
			}
			else 
			{
				$this->putConfig((int)$device->id, $configParams, $config_type);
			}
		}
		return true;	
	}
	
}

} // End of namespace CarmaLink