
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
	
	private 	Integer 		threshold;
	private 	Double			allowance;
	private 	BuzzerVolume	buzzer;	
	private 	Boolean			location;
	private 	Status			status;
	private		ConfigType		configType;

	public Config(Integer threshold, Double allowance) {
		this(threshold, allowance, null, null);
	}
	
	public Config(Integer threshold, Double allowance, Boolean location) {
		this(threshold, allowance, location, null);
	}
	
	public Config(Integer threshold, Double allowance, Boolean location, ConfigType configType) {
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
		String stringRep =  "Config { " +
				"threshold="+this.getThreshold()+","+
				"allowance="+this.getAllowance()+","+
				"location="+this.getLocation();
		stringRep += (configType.usesBuzzer()) ? ",buzzer="+this.getBuzzer().toString()+"}":"}";
		return stringRep;
	}
	
	/**
	 * @return the allowance
	 */
	public Double getAllowance() {
		return allowance;
	}
	/**
	 * @param allowance the allowance to set
	 */
	public void setAllowance(Double allowance) {
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
	public Integer getThreshold() {
		return threshold;
	}
	/**
	 * @param threshold the threshold to set
	 */
	public void setThreshold(Integer threshold) {
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
