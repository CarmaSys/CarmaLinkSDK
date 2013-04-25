<?php
namespace CarmaLink;	

	/**
	 * Monolog for debug/info logging (MIT license)
	 * 
	 * @see https://github.com/Seldaek/monolog.git
	 */
	require_once realpath(__DIR__. '/../monolog/src/Monolog/Logger.php');
	require_once realpath(__DIR__. '/../monolog/src/Monolog/Handler/HandlerInterface.php');
	require_once realpath(__DIR__. '/../monolog/src/Monolog/Handler/AbstractHandler.php');
	require_once realpath(__DIR__. '/../monolog/src/Monolog/Handler/AbstractProcessingHandler.php');
	require_once realpath(__DIR__. '/../monolog/src/Monolog/Handler/StreamHandler.php');
	require_once realpath(__DIR__. '/../monolog/src/Monolog/Formatter/FormatterInterface.php');
	require_once realpath(__DIR__. '/../monolog/src/Monolog/Formatter/NormalizerFormatter.php');
	require_once realpath(__DIR__. '/../monolog/src/Monolog/Formatter/LineFormatter.php');
	
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	/**
	 * Main interface to use the CarmaLink API.
	 *
	 * @class CarmaLinkAPI
	 */
	class CarmaLinkAPI {

		/**
		* @access public
		* @var int
		* The current API level used in construction of CarmaLinkAPI URIs
		*/
		const API_LEVEL = 1;

		/**
		* @access public
		* @var string
		* The current API version
		*/
		const API_VERSION = "1.4.0";

		const API_NAME = "CarmaLinkAPI";
		
		/**
		* @access public
		* @var string
		* This is the *default* path to the log file where API requests/responses will be logged if DEBUG is set to TRUE
		* To specify an alternative path include it in the constructor.
		* @see CarmaLinkAPI::__construct
		*/
		const API_LOG_FILE_DIR = "/var/log/httpd";

		/**
		 * @access public
		 * @var int 
		 * This is the maximum value of the per-request record "limit" API query parameter 
		 */
		const API_RECORD_LIMIT = 50;

		const API_METHOD_GET = 'GET';
		const API_METHOD_PUT = 'PUT';
		const API_METHOD_DELETE = 'DELETE';

		const RESPONSE_CODE = 'response_code';
		const RESPONSE_BODY = 'response_body';

		const API_METHOD_PUT_SUCCESS = 204;
		const API_METHOD_SUCCESS = 200;

		/**
		 * @access private
		 * @var array 	Optional cURL options. Can be set depending on need.
		 */
		private static $CURL_OPTS = array(
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_SSL_VERIFYHOST => 0
		);
		
		/**
		 * @access public
		 * @var bool	Whether to use additional cURL options when sending API requests
		 * @see CarmaLinkAPI::$CURL_OPTIONS
		 */
		public $use_curl_options = false;

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
		 * @access private
		 * @var _logger	Monolog\Logger
		 */
		private static $_logger = NULL;
		
		/**
		 * getLogger gets the static Monolog logging handler if debug is set to true
		 * @access protected
		 * @return Monolog\Logger
		 */
		protected static function getLogger() {
			if(!self::$_logger) {
				self::setLogger();
			}
			return self::$_logger;
		}

		protected static function setLogger($path = NULL) {
			$logfilePath = $path === NULL ? self::API_LOG_FILE_DIR."/".self::API_NAME.".log" : $path;
				
			// Attempt to open the file or create if it doesn't exist. 
			$handle = fopen($logfilePath,"a+");
			
			if(!$handle || !fclose($handle)) {
				throw new CarmaLinkAPIException("Could not create or open log file at path - ".$logfilePath);
			}
			
			self::$_logger = new Logger(self::API_NAME);
			self::$_logger->pushHandler(new StreamHandler($logfilePath,Logger::DEBUG));
		}

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
		public function __construct($consumer_key = null, $consumer_secret = null, $server_options = array(), $debug = false, $log_path = NULL) {
			if (!$consumer_key || !$consumer_secret || strlen($consumer_key) === 0 || strlen($consumer_secret) === 0) {
				throw new CarmaLinkAPIException(CarmaLinkAPIException::INVALID_API_KEYS_PROVIDED);
			}

			$this -> host = isset($server_options['HOST']) ? $server_options['HOST'] : null;
			$this -> port = isset($server_options['PORT']) ? $server_options['PORT'] : null;
			$this -> https = isset($server_options['HTTPS']) ? (bool)$server_options['HTTPS'] : false;
			$this -> debug = $debug;
			
			if($this->debug) {
				self::setLogger($log_path);
			}

			\OAuthStore::instance("2Leg", array('consumer_key' => $consumer_key, 'consumer_secret' => $consumer_secret));
		}

		/**
		 * Gets the relative path to the root endpoint of the API
		 * @return string
		 */
		public static function getEndpointRelativeRoot() {
			return 'v' . self::API_LEVEL;
		}

		/**
		 * Gets the root URI for and API endpoint
		 * @return string
		 */
		public function getEndpointRootURI() {
			return 'http' . ($this -> https ? 's' : '') . '://' . $this -> host . ':' . $this -> port;
		}

		/**
		 * If parameter is an array it will join it using "."
		 * @example sanitizeSerials(array("204",209,300)) // "204.209.300"
		 * @todo Verify serial string is valid
		 * @param int|string|array 		serials		Serial numbers to parse
		 * @return string
		 */
		private function sanitizeSerials($serials) {
			if (is_array($serials)) {
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
		public function getReportDataArray($serials, $report_type, $parameters) {
			return $this -> getReportData($serials, $report_type, $parameters, TRUE);
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
		 * @throws CarmaLink\CarmaLinkAPIException
		 */
		public function getReportData($serials = 0, $report_type, $parameters = array(), $returnAllData = FALSE) {
			if ($serials === 0)
				throw new CarmaLinkAPIException("Missing valid serial number for querying API for report data (given:".$serials.")");
			$serials = $this -> sanitizeSerials($serials);
			
			$uri = $this -> getEndpointRootURI() . '/' . $this -> getEndpointRelativeRoot() . '/' . $serials . '/data/' . $report_type;
			$response_data = $this -> get($uri, $parameters);
			
			if ($returnAllData === TRUE) {
				return $response_data;
			}

			if ((int)$response_data[self::RESPONSE_CODE] !== self::API_METHOD_SUCCESS) {
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
		protected function setupConfigCall(&$serials, &$endpoint, $config_type) {
			$serials = $this -> sanitizeSerials($serials);
			$endpoint = $this -> getEndpointRootURI() . '/' . $this -> getEndpointRelativeRoot() . '/' . $serials . '/report_config/' . $config_type;
		}
		
		/**
		 * Get all configurations given a serial
		 *
		 * @todo this only works for one serial, make it work w/ array of serials
		 *
		 * @param string|int 		serial			Serial number of the CarmaLink
		 * @return array 	Associative array of configurations
		 */
		public function getAllConfigs($serial = 0) {
			if($serial === 0)
				return false;
			
			$configs = array();

			foreach (ConfigType::$valid_config_types as $config_type) {
				$new_config = Config::Factory($this -> getConfig($serial, $config_type), $config_type);
				$configs[] = array($config_type => $new_config);
			}

			return $configs;
		}

		/**
		 * Retrieves a configuration object from the CarmaLink based on parameters
		 *
		 * @param string|int|array		serials		Serial number(s) of the CarmaLink(s)
		 * @param string				config_type	Valid configuration type
		 * @param int					configId	If querying a specific config
		 * @return bool|string On success returns JSON-formatted object, on failure false
		 */
		public function getConfig($serials = 0, $config_type, $configId = 0) {
			if ($serials === 0)
				return false;
			// setup
			$endpoint = '';
			$params = $configId === 0 ? NULL : array('id'=>$configId);
			
			$this -> setupConfigCall($serials, $endpoint, $config_type);
			$response_data = $this -> get($endpoint, $params);
			if ((int)$response_data[self::RESPONSE_CODE] !== self::API_METHOD_SUCCESS) {
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
		private function getProperResponse($response_data = NULL) {
			if ($response_data === NULL)
				return false;
			switch ((int)$response_data[self::RESPONSE_CODE]) {
				// For single queries
				case self::API_METHOD_PUT_SUCCESS :
					return true;
					break;
				// For multiple queries a JSON object is always returned with embedded data
				case self::API_METHOD_SUCCESS :
					$body = $response_data[self::RESPONSE_BODY];
					if (strlen($body) > 0)
						return $response_data[self::RESPONSE_BODY];
					else
						return true;
				// Otherwise there was an error
				default :
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
		public function putConfig($serials = 0, $config_array, $config_type) {
			if ($serials === 0)
				return false;
			$endpoint = '';
			$this -> setupConfigCall($serials, $endpoint, $config_type);
			if (empty($config_array) || !$config_type) {
				throw new CarmaLinkAPIException('API PUT ConfigUpdate was not of type array or not a valid configuration type.');
			}
			if (!is_array($config_array)) {
				throw new CarmaLinkAPIException('API PUT ConfigUpdate was not of type array.');
			}
			return $this -> getProperResponse($this -> put($endpoint, $config_array));
		}

		/**
		 * Delete a configuration from a CarmaLink
		 *
		 * @param string|int|array		serials			Serial number of the CarmaLink
		 * @param string 				config_type		Valid configuration type
		 * @return bool
		 */
		public function deleteConfig($serials = 0, $config_type) {
			if ($serials === 0)
				return false;
			$endpoint = '';
			$this -> setupConfigCall($serials, $endpoint, $config_type);
			$response_data = $this -> delete($endpoint);
			switch ((int)$response_data[self::RESPONSE_CODE]) {
				// For single queries
				case self::API_METHOD_PUT_SUCCESS :
					return true;
					break;
				// For multiple queries a JSON object is always returned with embedded data
				case self::API_METHOD_SUCCESS :
					return $response_data[self::RESPONSE_BODY];
				// Otherwise there was an error
				default :
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
		public function get($endpoint, $parameters = NULL) {
			return $this -> api($endpoint, self::API_METHOD_GET, $parameters);
		}

		/**
		 * Performs PUT request to API
		 * @param string		endpoint
		 * @param array 		parameters		Associative array of options to send
		 * @return array
		 */
		public function put($endpoint, $parameters = NULL) {
			return $this -> api($endpoint, self::API_METHOD_PUT, $parameters);
		}

		/**
		 * Performs DELETE request to API
		 * @param string		endpoint
		 * @return array
		 */
		public function delete($endpoint) {
			return $this -> api($endpoint, self::API_METHOD_DELETE);
		}

		/**
		 * All API requests filter through this method.
		 * @param string		endpoint
		 * @param string 		method			default is 'GET'
		 * @param string[]		parameters		Key=>values to send
		 * @param string[]		options			Array for future consideration
		 * @return (int|string)[]
		 */
		private function api($endpoint, $method = self::API_METHOD_GET, $parameters = NULL, $options = array()) {
			$put_data = NULL;
			$curl_options = $this->use_curl_options ? self::$CURL_OPTS : array();
			if ($method === self::API_METHOD_PUT) {
				$put_data = json_encode($parameters);
				$curl_options[CURLOPT_HTTPHEADER] = array('Content-Type: application/json');
				$parameters = NULL;
			}
			
			if($this->debug) {
				if(is_array($parameters)) {
					$debugParams = $parameters;
				} else if($parameters === NULL && strlen($put_data)) {
					$debugParams = json_decode($put_data,TRUE);
				} else {
					$debugParams = array();
				} 
				self::getLogger() -> addDebug("Request - ".$method." ".$endpoint." ",$debugParams);
				unset($debugParams);
			}
			
			$oauth_request = new \OAuthRequester($endpoint, $method, $parameters, $put_data);
			$response = $oauth_request -> doRequest(0, $curl_options);
			
			if($this->debug) {
				self::getLogger() -> addDebug("Response - ".$response['code']." body: ".$response['body']);
			}	
			
			return array(self::RESPONSE_CODE => $response['code'], self::RESPONSE_BODY => $response['body']);
		}

		/**
		 * Updates a device based on a CarmaLinkDevice object
		 * @deprecated To be deprecated in version 1.5.0
		 *
		 * @param 		CarmaLink\CarmaLink		Object representing a CarmaLink
		 * @param		bool					if true, the method will return an associative array if any
		 * 										updates or deletions had errors
		 * @return 		bool|array  
		 */
		public function updateDevice($device, $return_errors = FALSE) {
			$configs_to_update = array(
			    ConfigType::CONFIG_TRIP_REPORT,
				ConfigType::CONFIG_ENGINE_FAULT, 
				ConfigType::CONFIG_HARD_BRAKING, 
				ConfigType::CONFIG_HARD_ACCEL, 
				ConfigType::CONFIG_IDLING, 
				ConfigType::CONFIG_OVERSPEEDING,
				ConfigType::CONFIG_STATUS,
				ConfigType::CONFIG_GENERAL
			);
			
			$error_data = array();
			
			foreach ($configs_to_update as $config_type) {
				$config_params = Config::getConfigArray($device, $config_type);
				if($config_params === FALSE) {
					if(!$this-> deleteConfig((int)$device -> id, $config_type)) {
						$error_data[$config_type] = "failure to delete configuration.";	
					}
				} else if (!$this -> putConfig((int)$device -> id, $config_params, $config_type)) 
				{
					$error_data[$config_type] = "failure to configure.";
				}
			}
			return $return_errors ? $error_data : (count($error_data) === 0);
		}
	} // End of class CarmaLinkAPI
