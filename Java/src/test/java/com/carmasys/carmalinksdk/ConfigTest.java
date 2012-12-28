package com.carmasys.carmalinksdk;

import org.testng.annotations.Test;
import org.testng.annotations.BeforeClass;
import org.testng.AssertJUnit;
import org.testng.annotations.Test;
import org.testng.annotations.BeforeClass;
import org.testng.Assert;

import com.carmasys.carmalinksdk.CarmaLink.BuzzerVolume;
import com.carmasys.carmalinksdk.Config.Status;

public class ConfigTest {
	private Config configWithBuzzer;

	@BeforeClass
	public void beforeClass() {
		this.configWithBuzzer = new Config(0f, 0f, true, ConfigType.IDLING);
	}

	@Test
	public void ConfigFloatFloat() {
		try {
			new Config(1.2f, 2.45f);
			new Config(43029.24f, 43.43453534343f);
			new Config(-2323f, -342.23234f);
			new Config(434334f, 0.2342221109f);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void ConfigFloatFloatBoolean() {
		try {
			new Config(1.0f, 2.9f, false);
			new Config(43.34f, 4.000433f, true);
			new Config(-2323.0f, -32.23234f, true);
			new Config(434434.345534f, 0.2342221109f, false);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void ConfigFloatFloatBooleanConfigType() {
		try {
			new Config(1f, 2.9f, false, ConfigType.HARD_ACCEL);
			new Config(43029f, 4.000433f, true, ConfigType.ENGINE_FAULT);
			new Config(-2323f, -32.23234f, true, ConfigType.HARD_CORNERING);
			new Config(434334f, 0.2342221109f, false, ConfigType.TRIP_REPORT);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void getAllowance() {
		float testFloat = 32.4242323f;
		double delta = 0.00001;
		Config test = new Config(1f, testFloat);
		AssertJUnit.assertEquals(testFloat, test.getAllowance(), delta);
	}

	@Test
	public void getBuzzer() {
		this.configWithBuzzer.setBuzzer(BuzzerVolume.HIGH);
		AssertJUnit.assertEquals(this.configWithBuzzer.getBuzzer(),
				BuzzerVolume.HIGH);
	}

	@Test
	public void getConfigType() {
		this.configWithBuzzer.setConfigType(ConfigType.IDLING);
		AssertJUnit.assertEquals(this.configWithBuzzer.getConfigType(),
				ConfigType.IDLING);
	}

	@Test
	public void getLocation() {
		Assert.assertTrue(this.configWithBuzzer.getLocation());
	}

	@Test
	public void getStatus() {
		this.configWithBuzzer.setStatus(Status.DEACTIVATED);
		AssertJUnit.assertEquals(Status.DEACTIVATED, this.configWithBuzzer.getStatus());
	}

	@Test
	public void getThreshold() {
		float threshold = 2.5f;
		this.configWithBuzzer.setThreshold(threshold);
		AssertJUnit.assertEquals(threshold, this.configWithBuzzer.getThreshold());
	}

	@Test
	public void setAllowance() {
		try {
			this.configWithBuzzer.setAllowance(2.0f);
			this.configWithBuzzer.setAllowance(-2443.234511f);
			this.configWithBuzzer.setAllowance(-2443.234511f);
			this.configWithBuzzer.setAllowance(0f);
			this.configWithBuzzer.setAllowance(14453f);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setBuzzer() {
		try {
			this.configWithBuzzer.setBuzzer(BuzzerVolume.HIGH);
			this.configWithBuzzer.setBuzzer(BuzzerVolume.MED);
			this.configWithBuzzer.setBuzzer(BuzzerVolume.OFF);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setConfigType() {
		try {
			this.configWithBuzzer.setConfigType(ConfigType.ALL_ACTIVITY);
			this.configWithBuzzer.setConfigType(ConfigType.GENERAL_CONFIG);
			this.configWithBuzzer.setConfigType(ConfigType.HARD_ACCEL);
			this.configWithBuzzer.setConfigType(ConfigType.OVERSPEEDING);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setLocation() {
		try {
			this.configWithBuzzer.setLocation(true);
			this.configWithBuzzer.setLocation(false);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setStatus() {
		try {
			this.configWithBuzzer.setStatus(Status.PENDING_ACTIVATION);
			this.configWithBuzzer.setStatus(Status.ACTIVATED);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setThreshold() {
		try {
			this.configWithBuzzer.setThreshold(3f);
			this.configWithBuzzer.setThreshold(-24233.434f);
			this.configWithBuzzer.setThreshold(78.434f);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void toJSON() {
		// @TODO not sure how to test this exactly.
	}

}
