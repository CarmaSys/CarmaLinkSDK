package com.carmasys.carmalinksdk;

import org.testng.annotations.Test;
import org.testng.annotations.BeforeClass;
import org.testng.Assert;

import com.carmasys.carmalinksdk.CarmaLink.BuzzerVolume;
import com.carmasys.carmalinksdk.Config.Status;

public class ConfigTest {
	private Config configWithBuzzer;

	@BeforeClass
	public void beforeClass() {
		this.configWithBuzzer = new Config(0, 0.0, true, ConfigType.IDLING);
	}

	@Test
	public void ConfigIntegerDouble() {
		try {
			new Config(1, 2.45);
			new Config(43029, 43.43453534343);
			new Config(-2323, -342.23234);
			new Config(434334, 0.2342221109);
		} catch (Exception e) {
			Assert.fail(e.getMessage());
		}
	}

	@Test
	public void ConfigIntegerDoubleBoolean() {
		try {
			new Config(1, 2.9, false);
			new Config(43029, 4.000433, true);
			new Config(-2323, -32.23234, true);
			new Config(434334, 0.2342221109, false);
		} catch (Exception e) {
			Assert.fail(e.getMessage());
		}
	}

	@Test
	public void ConfigIntegerDoubleBooleanConfigType() {
		try {
			new Config(1, 2.9, false, ConfigType.HARD_ACCEL);
			new Config(43029, 4.000433, true, ConfigType.ENGINE_FAULT);
			new Config(-2323, -32.23234, true, ConfigType.HARD_CORNERING);
			new Config(434334, 0.2342221109, false, ConfigType.TRIP_REPORT);
		} catch (Exception e) {
			Assert.fail(e.getMessage());
		}
	}

	@Test
	public void getAllowance() {
		double testDouble = 32.4242323;
		double delta = 0.00001;
		Config test = new Config(1, testDouble);
		Assert.assertEquals(testDouble, test.getAllowance(), delta);
	}

	@Test
	public void getBuzzer() {
		this.configWithBuzzer.setBuzzer(BuzzerVolume.HIGH);
		Assert.assertEquals(this.configWithBuzzer.getBuzzer(),
				BuzzerVolume.HIGH);
	}

	@Test
	public void getConfigType() {
		this.configWithBuzzer.setConfigType(ConfigType.IDLING);
		Assert.assertEquals(this.configWithBuzzer.getConfigType(),
				ConfigType.IDLING);
	}

	@Test
	public void getLocation() {
		Assert.assertTrue(this.configWithBuzzer.getLocation());
	}

	@Test
	public void getStatus() {
		Assert.assertNotNull(this.configWithBuzzer.getStatus());
		
	}

	@Test
	public void getThreshold() {
		throw new RuntimeException("Test not implemented");
	}

	@Test
	public void setAllowance() {
		throw new RuntimeException("Test not implemented");
	}

	@Test
	public void setBuzzer() {
		throw new RuntimeException("Test not implemented");
	}

	@Test
	public void setConfigType() {
		throw new RuntimeException("Test not implemented");
	}

	@Test
	public void setLocation() {
		throw new RuntimeException("Test not implemented");
	}

	@Test
	public void setStatus() {
		try {
			this.configWithBuzzer.setStatus(Status.PENDING_ACTIVATION);
			this.configWithBuzzer.setStatus(Status.ACTIVATED);
		} catch (Exception e) {
			Assert.fail(e.getMessage());
		}
	}

	@Test
	public void setThreshold() {
		
	}

	@Test
	public void toJSON() {
		throw new RuntimeException("Test not implemented");
	}

}
