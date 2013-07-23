/**
 * 
 */
package com.carmasys.carmalinksdk;

/**
 * @author Christopher Najewicz <chris.najewicz@carmasys.com>
 *
 */
public class CarmaLink {

	public enum BuzzerVolume {
		HIGH("HIGH"),
		MED("MEDIUM"),
		OFF("OFF");
		
		private final String volume;
		private BuzzerVolume(String volume) {
			this.volume = volume;
		}
		/**
		 * @return the volume
		 */
		public String getVolume() {
			return volume;
		}
	}

	public enum FuelType {
		FUEL_GASOLINE("FUEL_GASOLINE"),
		FUEL_DIESEL("FUEL_DIESEL");
		
		private final String fuel_type;
		private FuelType(String fuel_type) {
			this.fuel_type = fuel_type;
		}
		/**
		 * @return the fuel type
		 */
		public String getFuelType() {
			return fuel_type;
		}
	}
	
	private 	Integer 		id;
	private 	Boolean			checkEngineLight;
	private		BuzzerVolume	buzzerVolume;
	private		Boolean			useGPS;
	private		Integer			pingTime;
	private		Integer			speedLimit;
	private 	float			accelLimit;
	private		float			brakeLimit;
	private		float			cornerLimit;
	private		Integer			idleTimeLimit;
	private		FuelType		fuelType;
	private		float			engineDisplacement;
	
	/**
	 * @return the id
	 */
	public Integer getId() {
		return id;
	}
	/**
	 * @param id the id to set
	 */
	public void setId(Integer id) {
		this.id = id;
	}
	/**
	 * @return the checkEngineLight
	 */
	public Boolean getCheckEngineLight() {
		return checkEngineLight;
	}
	/**
	 * @param checkEngineLight the checkEngineLight to set
	 */
	public void setCheckEngineLight(Boolean checkEngineLight) {
		this.checkEngineLight = checkEngineLight;
	}
	/**
	 * @return the buzzerVolume
	 */
	public BuzzerVolume getBuzzerVolume() {
		return buzzerVolume;
	}
	/**
	 * @param buzzerVolume the buzzerVolume to set
	 */
	public void setBuzzerVolume(BuzzerVolume buzzerVolume) {
		this.buzzerVolume = buzzerVolume;
	}
	/**
	 * @return the useGPS
	 */
	public Boolean getUseGPS() {
		return useGPS;
	}
	/**
	 * @param useGPS the useGPS to set
	 */
	public void setUseGPS(Boolean useGPS) {
		this.useGPS = useGPS;
	}
	/**
	 * @return the pingTime
	 */
	public Integer getPingTime() {
		return pingTime;
	}
	/**
	 * @param pingTime the pingTime to set
	 */
	public void setPingTime(Integer pingTime) {
		this.pingTime = pingTime;
	}
	/**
	 * @return the speedLimit
	 */
	public Integer getSpeedLimit() {
		return speedLimit;
	}
	/**
	 * @param speedLimit the speedLimit to set
	 */
	public void setSpeedLimit(Integer speedLimit) {
		this.speedLimit = speedLimit;
	}
	/**
	 * @return the accelLimit
	 */
	public float getAccelLimit() {
		return accelLimit;
	}
	/**
	 * @param accelLimit the accelLimit to set
	 */
	public void setAccelLimit(float accelLimit) {
		this.accelLimit = accelLimit;
	}
	/**
	 * @return the idleTimeLimit
	 */
	public Integer getIdleTimeLimit() {
		return idleTimeLimit;
	}
	/**
	 * @param idleTimeLimit the idleTimeLimit to set
	 */
	public void setIdleTimeLimit(Integer idleTimeLimit) {
		this.idleTimeLimit = idleTimeLimit;
	}
	/**
	 * @return the brakeLimit
	 */
	public float getBrakeLimit() {
		return brakeLimit;
	}
	/**
	 * @param brakeLimit the brakeLimit to set
	 */
	public void setBrakeLimit(float brakeLimit) {
		this.brakeLimit = brakeLimit;
	}
	/**
	 * @return the cornerLimit
	 */
	public float getCornerLimit() {
		return cornerLimit;
	}
	/**
	 * @param cornerLimit the cornerLimit to set
	 */
	public void setCornerLimit(float cornerLimit) {
		this.cornerLimit = cornerLimit;
	}
	/**
	 * @return the fuelType
	 */
	public FuelType getFuelType() {
		return fuelType;
	}
	/**
	 * @param fuelType the fuelType to set
	 */
	public void setFuelType(FuelType fuelType) {
		this.fuelType = fuelType;
	}
	/**
	 * @return the engineDisplacement
	 */
	public float getEngineDisplacement() {
		return engineDisplacement;
	}
	/**
	 * @param engineDisplacement the engineDisplacement to set
	 */
	public void setEngineDisplacement(float engineDisplacement) {
		this.engineDisplacement = engineDisplacement;
	}

}
