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
		const API_VERSION = "1.6.0";

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
		const API_RECORD_LIMIT  = 50;

		const API_METHOD_GET    = 'GET';
		const API_METHOD_PUT    = 'PUT';
		const API_METHOD_DELETE = 'DELETE';

		const RESPONSE_CODE     = 'response_code';
		const RESPONSE_BODY     = 'response_body';

		const API_METHOD_PUT_SUCCESS = 204;
		const API_METHOD_SUCCESS     = 200;

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
		public $isHttps = false;

		/**
		 * @access public
		 * @var bool	Whether to use debug, should be false for production.
		 */
		public $isDebugMode = false;

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
			if (!self::$_logger) { self::setLogger(); }
			return self::$_logger;
		}

		protected static function setLogger($path = NULL) {
			$logfilePath = ($path === NULL) ? self::API_LOG_FILE_DIR."/".self::API_NAME.".log" : $path;
				
			// Attempt to open the file or create if it doesn't exist. 
			$handle = fopen($logfilePath,"a+");
			
			if (!$handle || !fclose($handle)) { throw new CarmaLinkAPIException("Could not create or open log file at path - ".$logfilePath); }
			
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
		public function __construct($consumer_key = null, $consumer_secret = null, $server_options = array(), $is_debug_mode = false, $log_path = NULL) {
			if (!$consumer_key || !$consumer_secret || strlen($consumer_key) === 0 || strlen($consumer_secret) === 0) {
				throw new CarmaLinkAPIException(CarmaLinkAPIException::INVALID_API_KEYS_PROVIDED);
			}

			$this->host        = isset($server_options['HOST']) ? $server_options['HOST'] : null;
			$this->port        = isset($server_options['PORT']) ? $server_options['PORT'] : null;
			$this->isHttps     = isset($server_options['HTTPS']) ? (bool)$server_options['HTTPS'] : false;
			$this->isDebugMode = $is_debug_mode;
			
			if ($this->isDebugMode) { self::setLogger($log_path); }

			\OAuthStore::instance("2Leg", array('consumer_key' => $consumer_key, 'consumer_secret' => $consumer_secret));
		}

		/**
		 * Gets the relative path to the root endpoint of the API
		 * @return string
		 */
		public static function getEndpointRelativeRoot() { return 'v' . self::API_LEVEL; }

		/**
		 * Gets the root URI for and API endpoint
		 * @return string
		 */
		public function getEndpointRootURI() { return 'http' . ($this->isHttps ? 's' : '') . '://' . $this->host . ':' . $this->port; }

		/**
		 * If parameter is an array it will join it using "."
		 * @example sanitizeSerials(array("204",209,300)) // "204.209.300"
		 * @todo Verify serial string is valid
		 * @param int|string|array 		serials		Serial numbers to parse
		 * @return string
		 */
		private function sanitizeSerials($serials) { return (is_array($serials)) ? implode(".", $serials) : $serials; }

		/**
		 * Shortcut to getReportData w/ TRUE for the returnAllData param
		 * @param string|int|array 	serials			Serial number(s) of CarmaLink
		 * @param string 			report_type 	Report/view type to query
		 * @param array 			parameters		Key=>value parameters for data filtering to be added to the query string
		 * @return array 			Assoc. array of HTTP response code and HTTP body content
		 */
		public function getReportDataArray($serials, $report_type, $parameters) { return $this->getReportData($serials, $report_type, $parameters, TRUE); }

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
			if ($serials === 0 || empty($serials)) { throw new CarmaLinkAPIException("Missing valid serial number for querying API for report data (given:".$serials.")"); }
			if(!ConfigType::isValidReportConfig($report_type)) { throw new CarmaLinkAPIException('API getReportData can only operate on valid report configs.'); }
			$serials = $this->sanitizeSerials($serials);
			
			
			$uri = $this->getEndpointRootURI()."/".$this->getEndpointRelativeRoot()."/".$serials."/data/".$report_type;
			$response_data = $this->get($uri, $parameters);
			
			if ($returnAllData === TRUE) { return $response_data; }

			if ((int)$response_data[self::RESPONSE_CODE] !== self::API_METHOD_SUCCESS) { return FALSE; }
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
			$config_resource = "";
			if     (ConfigType::isValidReportConfigType($config_type) ) { $config_resource = "report_config"; }
			else if(ConfigType::isValidGeneralConfigType($config_type)) { $config_resource = "config"; }
			else { throw new CarmaLinkAPIException("API does not support config type ".$config_type); }
			
			$serials = $this->sanitizeSerials($serials);
			$endpoint = $this->getEndpointRootURI()."/".$this->getEndpointRelativeRoot()."/".$serials."/".$config_resource."/".$config_type;
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
			if ($serial === 0) { return false; }
			
			$configs = array();
			foreach (ConfigType::$valid_report_config_types as $config_type) {
				$new_config = ReportConfig::Factory($this->getConfig($serial, $config_type), $config_type);
				$configs[] = array($config_type => $new_config);
			}
			//one resource for general config.
			$configs[] = array("general_config" => GeneralConfig::Factory($this->getConfig($serial, ConfigType::CONFIG_GENERAL)));
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
			if ($serials === 0 || empty($serials)) { return false; }

			$endpoint = "";
			$params = ($configId === 0) ? NULL : array("id" => $configId);
			
			$this->setupConfigCall($serials, $endpoint, $config_type);
			$response_data = $this->get($endpoint, $params);
			if ((int)$response_data[self::RESPONSE_CODE] !== self::API_METHOD_SUCCESS) { return false; }
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
			if ($response_data === NULL) { return false; }

			switch ((int)$response_data[self::RESPONSE_CODE]) {
			// For single queries
			case self::API_METHOD_PUT_SUCCESS: return true;
			// For multiple queries a JSON object is always returned with embedded data
			case self::API_METHOD_SUCCESS :
				$body = $response_data[self::RESPONSE_BODY];
				return (strlen($body) > 0) ? $response_data[self::RESPONSE_BODY] : true;
			// Otherwise there was an error
			default: return false;
			}
		}

		/**
		 * Put / send a CarmaLink a new configuration
		 *
		 * @param string|int|array		serials			Serial number(s) of the CarmaLink(s)
		 * @param array|Config 			config			Config object or Array representation
		 * @param string				config_type 	Valid configuration type
		 * @return bool
		 */
		public function putConfig($serials = 0, $config, $config_type) {
			if ($serials === 0 || empty($serials)) { return false; }
			$endpoint = "";
			$this->setupConfigCall($serials, $endpoint, $config_type);
			
			if(ConfigType::isValidGeneralConfigType($config_type)) {
				if(ConfigType::isValidWritableGeneralConfigType($config_type)) {
					$config = ($config instanceof GeneralConfig) ? $config->getPartialArrayFromGeneralConfigType($config_type) : $config;
				} else if ($config_type === ConfigType::CONFIG_GENERAL) { //special breakup check for the all config, just to make things easier for everyone.
					//create array of all 3 general configs contaied in GET ALL.
					$responseArray = array(
						ConfigType::CONFIG_GENERAL_ENGINE       => $this->getProperResponse($this->putConfig($serials, $config, ConfigType::CONFIG_GENERAL_ENGINE)),
						ConfigType::CONFIG_GENERAL_CONNECTIVITY => $this->getProperResponse($this->putConfig($serials, $config, ConfigType::CONFIG_GENERAL_CONNECTIVITY)),
						ConfigType::CONFIG_GENERAL_OPERATION    => $this->getProperResponse($this->putConfig($serials, $config, ConfigType::CONFIG_GENERAL_OPERATION)),
					);
					return $responseArray;
				}
				else {
					throw new CarmaLinkAPIException("API putConfig config parameter of '$config_type' was not a valid writable config type");
				}
			} else if(ConfigType::isValidWritableReportConfigType($config_type)) {
				$config = ($config instanceof ReportConfig) ? $config->toArray() : $config;
			} else {
				throw new CarmaLinkAPIException("API putConfig config parameter of '$config_type' was not a valid writable config type.");
			}
			// If config is instance of CarmaLink\Config then convert to associative array, otherwise use given argument assuming array.
			

			if (!is_array($config) && empty($config) || !$config_type) {
				throw new CarmaLinkAPIException('API putConfig config parameter was not of type array or not a valid configuration type.');
			}
			return $this->getProperResponse($this->put($endpoint, $config));
		}

		/**
		 * Delete a configuration from a CarmaLink
		 * @param string|int|array		serials			Serial number of the CarmaLink
		 * @param string 				config_type		Valid configuration type
		 * @return bool
		 */
		public function deleteConfig($serials = 0, $config_type) {
			if ($serials === 0 || empty($serials)) { return false; }
			if (!ConfigType::isValidWritableReportConfigType) { throw new CarmaLinkAPIException('API deleteConfig config parameter must be a valid report config only'); }
			$endpoint = "";
			$this->setupConfigCall($serials, $endpoint, $config_type);
			$response_data = $this->delete($endpoint);
			switch ((int)$response_data[self::RESPONSE_CODE]) {
			// For single queries
			case self::API_METHOD_PUT_SUCCESS: return true;
			// For multiple queries a JSON object is always returned with embedded data
			case self::API_METHOD_SUCCESS: return $response_data[self::RESPONSE_BODY];
			// Otherwise there was an error
			default: return false;
			}
		}

		/**
		 * Performs GET request to API
		 * @param string		endpoint
		 * @param array 		parameters		Any query string parameters to send
		 * @return array
		 */
		public function get($endpoint, $parameters = NULL) {
			return $this->api($endpoint, self::API_METHOD_GET, $parameters);
		}

		/**
		 * Performs PUT request to API
		 * @param string		endpoint
		 * @param array 		parameters		Associative array of options to send
		 * @return array
		 */
		public function put($endpoint, $parameters = NULL) {
			return $this->api($endpoint, self::API_METHOD_PUT, $parameters);
		}

		/**
		 * Performs DELETE request to API
		 * @param string		endpoint
		 * @return array
		 */
		public function delete($endpoint) {
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
		private function api($endpoint, $method = self::API_METHOD_GET, $parameters = NULL, $options = array()) {
			$put_data = NULL;
			$curl_options = $this->use_curl_options ? self::$CURL_OPTS : array();
			if ($method === self::API_METHOD_PUT) {
				$put_data = json_encode($parameters);
				// if no data was being put.
				if ($put_data == NULL) { return array(self::RESPONSE_CODE => 202, self::RESPONSE_BODY => "Nothing to put, no request sent"); }
				$curl_options[CURLOPT_HTTPHEADER] = array('Content-Type: application/json');
				$parameters = NULL;
			}
			
			if ($this->isDebugMode) {
				if      (is_array($parameters))                     { $debugParams = $parameters; }
				else if ($parameters === NULL && strlen($put_data)) { $debugParams = json_decode($put_data,TRUE); }
				else                                                { $debugParams = array(); } 
				self::getLogger()->addDebug("Request - ".$method." ".$endpoint." ",$debugParams);
				unset($debugParams);
			}
			
			$oauth_request = new \OAuthRequester($endpoint, $method, $parameters, $put_data);
			$response = $oauth_request->doRequest(0, $curl_options);
			if ($this->isDebugMode) { self::getLogger()->addDebug("Response - ".$response['code']." body: ".$response['body']); }	
			
			return array(self::RESPONSE_CODE => $response['code'], self::RESPONSE_BODY => $response['body']);
		}
	} // End of class CarmaLinkAPI
?>
