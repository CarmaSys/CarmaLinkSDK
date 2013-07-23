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
	GENERAL_CONFIG("general_config"),
	NEW_DEPLOYMENT("new_deployment"),
	ALL_ACTIVITY("all_activity");

	private final String config_type;
	
	private static enum ConfigOrReport { CONFIG, REPORT };

	private static final EnumSet<ConfigType> USE_BUZZER = EnumSet.range(ConfigType.OVERSPEEDING, ConfigType.HARD_ACCEL);
	private static final EnumSet<ConfigType> VALID_CONFIG_TYPES = 
			EnumSet.range(ConfigType.OVERSPEEDING,ConfigType.GENERAL_CONFIG);
	private static final EnumSet<ConfigType> VALID_REPORT_TYPES = 
			EnumSet.complementOf(EnumSet.of(ConfigType.GENERAL_CONFIG));
	private static final EnumSet<ConfigType> VALID_ENDPOINTS = EnumSet.allOf(ConfigType.class);
	
	ConfigType(String config_type)
	{
		this.config_type = config_type;
	}

	public static Boolean validConfigType(ConfigType type) 
	{
		return ConfigType.valid(type, ConfigOrReport.CONFIG);
	}

	public static Boolean validReportType(ConfigType type) 
	{
		return ConfigType.valid(type, ConfigOrReport.REPORT);
	}
	
	private static Boolean valid(ConfigType type, ConfigOrReport configOrReport) 
	{
		EnumSet<ConfigType> valid_types = null;
		switch(configOrReport) {
			case CONFIG : 
				valid_types = ConfigType.VALID_CONFIG_TYPES;
				break;
			case REPORT:
				valid_types = ConfigType.VALID_REPORT_TYPES;
				break;
			default:
				valid_types = ConfigType.VALID_ENDPOINTS;
				break;
		}
		for(final ConfigType checkType : valid_types ) {
			if(checkType == type)
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

	public String toString() 
	{
		return config_type;
	}
}
