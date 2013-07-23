
package com.carmasys.carmalinksdk;

import java.util.HashMap;
import com.carmasys.carmalinksdk.CarmaLink.BuzzerVolume;
import com.google.gson.Gson;

/**
 * @author Christopher Najewicz <chris.najewicz@carmasys.com>
 *
 */
public class Config {
	
	public enum Status {
		UNKNOWN_STATUS,
		PENDING_ACTIVATION,
		ACTIVATED,
		PENDING_DEACTIVATION,
		DEACTIVATED;
	}
	
	private Float threshold;
	private Float allowance;
	private BuzzerVolume buzzer;	
	private Boolean location;
	private Status status;
	private	transient ConfigType configType;

	public Config(Float threshold, Float allowance) {
		this(threshold, allowance, null, null);
	}
	
	public Config(Float threshold, Float allowance, Boolean location) {
		this(threshold, allowance, location, null);
	}
	
	public Config(Float threshold, Float allowance, Boolean location, ConfigType configType) {
		this.threshold = threshold;
		this.allowance = allowance;
		this.location = location;
		this.configType = configType;
	}
	
	public String toJSON() {
		Gson gson = new Gson();
		return gson.toJson(this);
	}
	
	@Override
	public String toString() {
		
		StringBuilder stringRep = 
			(new StringBuilder("Config { "))
		    	.append("threshold=")
		        .append(this.getThreshold())
		        .append(",")
		        .append("allowance=")
		        .append(this.getAllowance())
		        .append(",")
		        .append("location=")
		        .append(this.getLocation());
		
		if(configType.usesBuzzer()) {
			stringRep.append(",buzzer=").append(this.getBuzzer().toString());
		}
		
		stringRep.append("}");
		return stringRep.toString();
	}
	
	/**
	 * @return the allowance
	 */
	public Float getAllowance() {
		return allowance;
	}
	/**
	 * @param allowance the allowance to set
	 */
	public void setAllowance(Float allowance) {
		this.allowance = allowance;
	}
	/**
	 * @return the buzzer
	 */
	public BuzzerVolume getBuzzer() {
		return buzzer;
	}
	/**
	 * @param buzzer the buzzer to set
	 */
	public void setBuzzer(BuzzerVolume buzzer) {
		this.buzzer = buzzer;
	}
	/**
	 * @return the location
	 */
	public Boolean getLocation() {
		return location;
	}
	/**
	 * @param location the location to set
	 */
	public void setLocation(Boolean location) {
		this.location = location;
	}
	/**
	 * @return the threshold
	 */
	public Float getThreshold() {
		return threshold;
	}
	/**
	 * @param threshold the threshold to set
	 */
	public void setThreshold(Float threshold) {
		this.threshold = threshold;
	}
	/**
	 * @return the status
	 */
	public Status getStatus() {
		return status;
	}
	/**
	 * @param status the status to set
	 */
	public void setStatus(Status status) {
		this.status = status;
	}
	/**
	 * @return the configType
	 */
	public ConfigType getConfigType() {
		return configType;
	}
	/**
	 * @param configType the configType to set
	 */
	public void setConfigType(ConfigType configType) {
		this.configType = configType;
	}

}
