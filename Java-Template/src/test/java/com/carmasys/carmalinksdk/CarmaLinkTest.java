package com.carmasys.carmalinksdk;

import org.testng.annotations.Test;
import org.testng.annotations.BeforeClass;
import org.testng.AssertJUnit;
import org.testng.Assert;
import org.testng.annotations.Test;
import org.testng.annotations.BeforeClass;

import com.carmasys.carmalinksdk.CarmaLink.BuzzerVolume;
import com.carmasys.carmalinksdk.CarmaLink.FuelType;

public class CarmaLinkTest {
	private CarmaLink device;

	@BeforeClass
	public void beforeClass() {
		this.device = new CarmaLink();
	}

	@Test
	public void getAccelLimit() {
		float limit = 4.5f;
		this.device.setAccelLimit(limit);
		AssertJUnit.assertEquals(limit, this.device.getAccelLimit());
	}

	@Test
	public void getBrakeLimit() {
		float limit = 24.5f;
		this.device.setBrakeLimit(limit);
		AssertJUnit.assertEquals(limit, this.device.getBrakeLimit());
	}

	@Test
	public void getBuzzerVolume() {
		this.device.setBuzzerVolume(BuzzerVolume.HIGH);
		AssertJUnit.assertEquals(BuzzerVolume.HIGH, this.device.getBuzzerVolume());
	}

	@Test
	public void getCheckEngineLight() {
		this.device.setCheckEngineLight(true);
		Assert.assertTrue(this.device.getCheckEngineLight());
	}

	@Test
	public void getCornerLimit() {
		float limit = -2.5f;
		this.device.setCornerLimit(limit);
		AssertJUnit.assertEquals(limit, this.device.getCornerLimit());
	}

	@Test
	public void getEngineDisplacement() {
		float displacement = 4.2f;
		this.device.setEngineDisplacement(displacement);
		AssertJUnit.assertEquals(displacement, this.device.getEngineDisplacement());

	}

	@Test
	public void getFuelType() {
		this.device.setFuelType(FuelType.FUEL_DIESEL);
		AssertJUnit.assertEquals(FuelType.FUEL_DIESEL, this.device.getFuelType());
	}

	@Test
	public void getId() {
		Integer id = 10;
		this.device.setId(id);
		AssertJUnit.assertEquals(id, this.device.getId());
	}

	@Test
	public void getIdleTimeLimit() {
		Integer idle = 1000;
		this.device.setIdleTimeLimit(idle);
		AssertJUnit.assertEquals(idle, this.device.getIdleTimeLimit());
	}

	@Test
	public void getPingTime() {
		Integer ping = 1000;
		this.device.setPingTime(ping);
		AssertJUnit.assertEquals(ping, this.device.getPingTime());
	}

	@Test
	public void getSpeedLimit() {
		Integer speedLimit = 120;
		this.device.setSpeedLimit(speedLimit);
		AssertJUnit.assertEquals(speedLimit, this.device.getSpeedLimit());
	}

	@Test
	public void getUseGPS() {
		this.device.setUseGPS(true);
		Assert.assertTrue(this.device.getUseGPS());
	}

	@Test
	public void setAccelLimit() {
		try {
			this.device.setAccelLimit(3.0f);
			this.device.setAccelLimit(-4333f);
			this.device.setAccelLimit(3.435629994f);
			this.device.setAccelLimit(23456.4346667f);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setBrakeLimit() {
		try {
			this.device.setBrakeLimit(3.4f);
			this.device.setBrakeLimit(343.4f);
			this.device.setBrakeLimit(3f);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setBuzzerVolume() {
		try {
			this.device.setBuzzerVolume(BuzzerVolume.HIGH);
			this.device.setBuzzerVolume(BuzzerVolume.OFF);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setCheckEngineLight() {
		try {
			this.device.setCheckEngineLight(false);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setCornerLimit() {
		try {
			this.device.setCornerLimit(3.664f);
			this.device.setCornerLimit(33.0f);
			this.device.setCornerLimit(-0.664f);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setEngineDisplacement() {
		try {
			this.device.setEngineDisplacement(4.5f);
			this.device.setEngineDisplacement(-23.4521f);
			this.device.setEngineDisplacement(0.45f);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setFuelType() {
		try {
			this.device.setFuelType(FuelType.FUEL_GASOLINE);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setId() {
		try {
			this.device.setId(2);
			this.device.setId(432);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setIdleTimeLimit() {
		try {
			this.device.setIdleTimeLimit(4000);
			this.device.setIdleTimeLimit(24000);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setPingTime() {
		try {
			this.device.setPingTime(34000);
			this.device.setPingTime(534000);
			this.device.setPingTime(600);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setSpeedLimit() {
		try {
			this.device.setSpeedLimit(20);
			this.device.setSpeedLimit(2005);
			this.device.setSpeedLimit(-1420);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

	@Test
	public void setUseGPS() {
		try {
			this.device.setUseGPS(false);
			this.device.setUseGPS(true);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
	}

}
