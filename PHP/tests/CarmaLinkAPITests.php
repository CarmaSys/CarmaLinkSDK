<?php

namespace CarmaLink;

require_once realpath(__DIR__."/../CarmaLinkAPI.php");

class CarmaLinkAPITest extends \PHPUnit_Framework_TestCase 
{
	
	const API_HOST_KEY 	= 'HOST';
	const API_PORT_KEY 	= 'PORT';
	const API_SSL_KEY 	= 'HTTPS';

	const VALID_API_HOST = 'frontend0';
	const VALID_API_USES_SSL = true;
	const VALID_API_PORT = 8282;
	
	const INVALID_API_HOST 	= 'capecodekashivaselinefixtures.org';
	const INVALID_API_PORT	= 3432;
	
	protected $validAPI, $validAPIDebug;
	protected $invalidAPI, $invalidAPIDebug;
	protected $validOptions, $invalidOptions;
	protected $validKeys, $invalidKeys;
	protected $validSerials, $invalidSerials;
	
	protected function setUp()
	{

		$this->validSerials = array("200",200,"200-201","200.201","all");
		$this->invalidSerials = array("39844",34049,"some","something43434","not","3434-200",
								"asfdasdf.dddda089ajlkja9999999","34+43","434--");

		$this->validOptions = array(
			self::API_HOST_KEY	=> self::VALID_API_HOST,
			self::API_PORT_KEY	=> self::VALID_API_PORT,
			self::API_SSL_KEY	=> self::VALID_API_USES_SSL
		);
		$this->invalidOptions = array(
			self::API_HOST_KEY	=> self::INVALID_API_HOST,
			self::API_PORT_KEY	=> self::INVALID_API_PORT
		);
		
		$this->validKeys = array('key'=>'SOME KEY HERE','secret'=>'SOME SECRET HERE');
		$this->invalidKeys = array('key'=>'asdfasdfasdfasdf','secret'=>'VVERfasDFSFdfDadfdfanbtDFhJytFFDdfdSDdfdF');
		
		$this->validAPI	= new CarmaLinkAPI($this->validKeys['key'],$this->validKeys['secret'],$this->validOptions);
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
		$realEndpoint = 'v' . CarmaLinkAPI::API_VERSION . '/' . CarmaLinkAPI::API_DEVICES;
		$this->assertEquals($realEndpoint, CarmaLinkAPI::getEndpointRelativeRoot() );
	}
	
	/**
	 * @covers CarmaLinkAPI::getEndpointRootURI
	 */
	public function testGetEndpointRootURI() 
	{
		$proto = self::VALID_API_USES_SSL ? "https://" : "http://";
		$this->assertEquals($proto.self::VALID_API_HOST.":".self::VALID_API_PORT, $this->validAPI->getEndpointRootURI());
	}
	
	/**
	 * @covers CarmaLinkAPI::getReportData
	 */
	public function testGetReportData() 
	{
		// invalid serial
		$serial = "sadflkasdfjlkasjdflkjasdflkj";
		$this->assertFalse($this->validAPI->getReportData($serial, ConfigType::CONFIG_IDLING));
		
		// invalid serial
		$serial = 0;
		$this->assertFalse($this->validAPI->getReportData($serial, ConfigType::CONFIG_IDLING));
		
		// serial with known device status data
		$serial = 200;
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
	
	public function testValidSerials()
	{
		foreach ($this->validSerials as $serial) {
			$this->assertTrue($this->validAPI->getReportData($serial, ConfigType::CONFIG_STATUS) !== false);	
		}
	}
	
	public function testInvalidSerials()
	{
		foreach ($this->invalidSerials as $serial) {
			$this->assertFalse($this->validAPI->getReportData($serial, ConfigType::CONFIG_STATUS));	
		}
	}
	
	
}
