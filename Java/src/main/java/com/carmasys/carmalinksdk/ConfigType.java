/**
 * 
 */
package com.carmasys.carmalinksdk;

import java.util.EnumSet;

/**
 * @author Christopher Najewicz <chris.najewicz@carmasys.com>
 *
 */

public enum ConfigType {
	
	OVERSPEEDING("overspeeding"),
	HARD_BRAKING("hard_braking"),
	HARD_CORNERING("hard_cornering"),
	IDLING("idling"),
	HARD_ACCEL("hard_accel"),
	TRIP_REPORT("trip_report"),
	STATUS("status"),
	ENGINE_FAULT("engine_fault"),
	NEW_DEPLOYMENT("new_deployment"),
	ALL_ACTIVITY("all_activity"),
	GENERAL_CONFIG("general_config");

	private final String data_type;
	
	private static enum ConfigOrReport { CONFIG, REPORT };

	private static final EnumSet<ConfigType> USE_BUZZER = EnumSet.range(ConfigType.OVERSPEEDING, ConfigType.HARD_ACCEL);
	private static final EnumSet<ConfigType> VALID_CONFIG_TYPES = EnumSet.range(ConfigType.OVERSPEEDING,ConfigType.ENGINE_FAULT);
	private static final EnumSet<ConfigType> VALID_REPORT_TYPES = EnumSet.range(ConfigType.OVERSPEEDING,ConfigType.ALL_ACTIVITY);
	private static final EnumSet<ConfigType> VALID_ENDPOINTS = EnumSet.allOf(ConfigType.class);
	
	ConfigType(String data_type)
	{
		this.data_type = data_type;
	}

	public static Boolean validConfigType(String endpoint) 
	{
		return ConfigType.validEndpoint(endpoint, ConfigOrReport.CONFIG);
	}

	public static Boolean validReportType(String endpoint) 
	{
		return ConfigType.validEndpoint(endpoint, ConfigOrReport.REPORT);
	}
	
	private static Boolean validEndpoint(String endpoint, ConfigOrReport endpoint_type) 
	{
		EnumSet<ConfigType> valid_endpoints = null;
		switch(endpoint_type) {
			case CONFIG : 
				valid_endpoints = ConfigType.VALID_CONFIG_TYPES;
				break;
			case REPORT:
				valid_endpoints = ConfigType.VALID_REPORT_TYPES;
				break;
			default:
				valid_endpoints = ConfigType.VALID_ENDPOINTS;
				break;
		}
		for(final ConfigType data_type : valid_endpoints ) {
			if(data_type.getDataType() == endpoint)
			{
				return true;
			}
		}
		return false;
	}
	
	public final Boolean usesBuzzer() 
	{
		return ConfigType.USE_BUZZER.contains(this);
	}
	
	/**
	 * @return the data_type
	 */
	public String getDataType() 
	{
		return data_type;
	}

	public String toString() 
	{
		return data_type;
	}
}
