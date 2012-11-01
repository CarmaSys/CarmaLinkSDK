<?php

namespace CarmaLink;

/**
 * Unit Tests for the CarmaLink PHP SDK
*/
 
require_once realpath(__DIR__."/../CarmaLinkAPI.php");
require_once realpath(__DIR__."/config.inc");

class CarmaLinkAPITest extends \PHPUnit_Framework_TestCase 
{
	const API_HOST_KEY 	= 'HOST';
	const API_PORT_KEY 	= 'PORT';
	const API_SSL_KEY 	= 'HTTPS';

	protected $validAPI, $validAPIDebug;
	protected $invalidAPI, $invalidAPIDebug;
	protected $validOptions, $invalidOptions;
	protected $validKeys, $invalidKeys;
	
	protected function setUp()
	{
		$this->validOptions = array(
			self::API_HOST_KEY	=> CarmaLinkAPITestConfig::VALID_API_HOST,
			self::API_PORT_KEY	=> CarmaLinkAPITestConfig::VALID_API_PORT,
			self::API_SSL_KEY	=> CarmaLinkAPITestConfig::VALID_API_USES_SSL
		);
		$this->invalidOptions = array(
			self::API_HOST_KEY	=> CarmaLinkAPITestConfig::INVALID_API_HOST,
			self::API_PORT_KEY	=> CarmaLinkAPITestConfig::INVALID_API_PORT
		);
		// Enter your valid API keys here
		$this->validKeys = array('key'=>CarmaLinkAPITestConfig::API_KEY,'secret'=>CarmaLinkAPITestConfig::API_SECRET);
		$this->invalidKeys = array('key'=>'ashdf436sfasd43fa7sdfasdf','secret'=>'VVERfasDFSFdfDadfdfanbtDFhJytFFDdfdSDdfdF');
		
		$this->validAPI	= new CarmaLinkAPI($this->validKeys['key'],$this->validKeys['secret'],$this->validOptions);
		$this->validAPI->use_curl_options = CarmaLinkAPITestConfig::VALID_API_TRUST_INSECURE_CERTS;
		
		$this->invalidAPI = new CarmaLinkAPI($this->validKeys['key'],$this->validKeys['secret'],$this->invalidOptions);
	}
	
	/**
	 * @expectedException CarmaLink\CarmaLinkAPIException
	 */
	public function testConstructWithNoParams() 
	{
		// No params
		$newAPI = new CarmaLinkAPI();
	}

	/**
	 * @expectedException CarmaLink\CarmaLinkAPIException
	 */
	public function testConstructWithAPIKeyNoSecret() 
	{
		// No secret
		$newAPI = new CarmaLinkAPI('someAPIkey');
	}

	/**
	 * @expectedException CarmaLink\CarmaLinkAPIException
	 */
	public function testConstructWithEmptyAPIKeyHasSecret() 
	{
		// Empty key
		$newAPI = new CarmaLinkAPI('','somesecretkey');
	}

	/**
	 * @expectedException CarmaLink\CarmaLinkAPIException
	 */
	public function testConstructWithHasAPIKeyEmptySecret() 
	{
		// Empty secret
		$newAPI = new CarmaLinkAPI('someAPIkey','');
	}

	/**
	 * @covers CarmaLinkAPI::getEndpointRelativeRoot
	 */
	public function testGetEndpointRelativeRoot() 
	{
		$realEndpoint = 'v' . CarmaLinkAPI::API_VERSION;
		$this->assertEquals($realEndpoint, CarmaLinkAPI::getEndpointRelativeRoot() );
	}
	
	/**
	 * @covers CarmaLinkAPI::getEndpointRootURI
	 */
	public function testGetEndpointRootURI() 
	{
		$proto = CarmaLinkAPITestConfig::VALID_API_USES_SSL ? "https://" : "http://";
		$this->assertEquals($proto.CarmaLinkAPITestConfig::VALID_API_HOST.":".CarmaLinkAPITestConfig::VALID_API_PORT, $this->validAPI->getEndpointRootURI());
	}
	
	/**
	 * @covers CarmaLinkAPI::getReportData
	 */
	public function testGetReportData() 
	{
		// invalid serial
		$serial = "sadflkasdfjlkasjdflkjasdflkj";
		$this->assertFalse($this->validAPI->getReportData($serial, ConfigType::CONFIG_IDLING));
		
		// serial with known device status data
		$serial = CarmaLinkAPITestConfig::$KNOWN_DEVICE_WITH_STATUS_DATA;
		$this->assertStringStartsWith('[{',$this->validAPI->getReportData($serial, ConfigType::CONFIG_STATUS));

		// invalid endpoint/config type
		$this->assertFalse($this->validAPI->getReportData($serial, 'asdfasdfasdfasdf'));
	}

	/**
	 * Should time-out w/ cURL
	 * @expectedException OAuthException2
	 */	
	public function testInvalidAPIRequests()
	{
		//invalid api credentials
		$this->invalidAPI->getReportData(200, ConfigType::CONFIG_IDLING);
	}
	
	
	
}
