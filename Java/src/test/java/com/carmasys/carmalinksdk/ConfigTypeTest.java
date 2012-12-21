package com.carmasys.carmalinksdk;

import org.testng.annotations.*;
import org.testng.Assert;

public class ConfigTypeTest {

	private ConfigType hardBraking;
	private ConfigType validConfig;
	private ConfigType invalidConfig;
	private ConfigType validReport;
	private ConfigType invalidReport;
	private ConfigType usesBuzzer;
	private ConfigType doesntUseBuzzer;
	
	@BeforeClass
	public void setup() {
		this.hardBraking = ConfigType.HARD_BRAKING;
		this.validConfig = ConfigType.GENERAL_CONFIG;
		this.invalidConfig = ConfigType.NEW_DEPLOYMENT;
		this.validReport = ConfigType.IDLING;
		this.invalidReport = ConfigType.GENERAL_CONFIG;
		this.usesBuzzer = ConfigType.HARD_ACCEL;
		this.doesntUseBuzzer = ConfigType.STATUS;
	}
	
  @Test
  public void ConfigType() {
    Assert.assertNotNull(this.hardBraking); 
  }

  @Test
  public void toStringTest() {
    Assert.assertEquals("hard_braking",this.hardBraking.toString());
  }

  @Test
  public void usesBuzzer() {
    Assert.assertTrue(this.usesBuzzer.usesBuzzer());
  }

  @Test
  public void doesntUseBuzzer() {
	  Assert.assertFalse(this.doesntUseBuzzer.usesBuzzer());
  }
  
  @Test
  public void validConfigType() {
	  Assert.assertTrue(ConfigType.validConfigType(this.validConfig));
  }

  @Test 
  public void invalidConfigType() {
	  Assert.assertFalse(ConfigType.validConfigType(this.invalidConfig));
  }

  @Test
  public void validReportType() {
	  Assert.assertTrue(ConfigType.validReportType(this.validReport));
  }

  @Test 
  public void invalidReportType() {
	  Assert.assertFalse(ConfigType.validReportType(this.invalidReport));
  }
  
}
