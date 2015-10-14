<?php
/**
	 * CarmaLink Device Class
	 * 
	 * 
	 */
namespace CarmaLink;
/**
	 * "Abstract" class representing minimum properties of a CarmaLink
	 *
	 * This class represents a possible starting point for an abstraction
	 * of a CarmaLink. The getters/setters below are required for some of
	 * the functionality in this SDK.
	 *
	 * @class CarmaLink
	 */
	abstract class CarmaLink {
		/**
		 * Set CarmaLink serial number
		 * @param int	serialNumber of CarmaLink
		 * @return void
		 */
		public function setSerialNumber($serialNumber) { if ($this->serialNumber !== $serialNumber) { $this->serialNumber = (int)$serialNumber; } }

		/**
		 * CarmaLink's serial
		 * @return int
		 */
		public function getSerialNumber() { return $this->serialNumber; }

		/**
		 * Set CarmaLink location tracking / GPS functionality
		 * @param bool	useGps	On/Off
		 * @return void
		 */
		public function setUseGps($useGps) { $this->useGps = (bool)$useGps; }

		/**
		 * Get CarmaLink location functionality
		 * @return bool
		 */
		public function getUseGps() { return $this->useGps; }


		//functions that are being called to perform all of the above functions.
		/*
		 * Sets threshold of values passed in based on configuration type.
		 * @param	ConfigType	configType	valid config type to change
		 * @param	int|float	value	value to set threshold too.
		 */
		public function setThreshold($configType, $value = 0.0) {
			if(!is_numeric($value)) { throw new CarmaLinkAPIException("Error: setThreshold for ".$configType." expected value to be numeric, ".$value." received"); }
			switch($configType) {
			case ConfigType::CONFIG_OVERSPEEDING:
				$this->speedLimit_kmph = (float)$value;
				break;
			case ConfigType::CONFIG_IDLING:
				$this->idleTimeLimit_kmph = (float)$value;
				break;
			case ConfigType::CONFIG_HARD_ACCEL:
				$this->accelLimit_Mpss = (float)$value;
				break;
			case ConfigType::CONFIG_HARD_BRAKING:
				$this->brakeLimit_Mpss = (float)$value;
				break;
			case ConfigType::CONFIG_HARD_CORNERING:
				$this->corneringLimit_Mpss = (float)$value;
				break;
			case ConfigType::CONFIG_ENGINE_OVERSPEED:
				$this->engineSpeedLimit_rpm = (int)$value;
				break;
			case ConfigType::CONFIG_PARKING_BRAKE:
				$this->parkingBrakeLimit_kmph = (float)$value;
				break;
			case ConfigType::CONFIG_SEATBELT:
				$this->seatbeltLimit_kmph = (float)$value;
				break;
			case ConfigType::CONFIG_PARKING:
				$this->parkingTimeoutThreshold_Msec = (int)$value;
				break;
			case ConfigType::CONFIG_TRANSPORTED:
				$this->transportedPingTime_Msec = (int)$value;	
				break;
			case ConfigType::CONFIG_STATUS:
				$this->statusPingTime_Msec = (int)$value;
				break;
			case ConfigType::CONFIG_HEALTH:
			case ConfigType::CONFIG_TRIP_REPORT:
			case ConfigType::CONFIG_DIGITAL_INPUT_0:
			case ConfigType::CONFIG_DIGITAL_INPUT_1:
			case ConfigType::CONFIG_DIGITAL_INPUT_2:
			case ConfigType::CONFIG_DIGITAL_INPUT_3:
			case ConfigType::CONFIG_DIGITAL_INPUT_4:
			case ConfigType::CONFIG_DIGITAL_INPUT_5:
			case ConfigType::CONFIG_DIGITAL_INPUT_6:
			case ConfigType::CONFIG_DRIVER_LOG:
			case ConfigType::CONFIG_GREEN_BAND:
				throw new CarmaLinkAPIException("Error: setThreshold for '".$configType."' is illegal, as it does not support the threshold parameter.");
				break;
			default:
				throw new CarmaLinkAPIException("Error: setThreshold for '".$configType."' has failed since '".$configType."' is not recognized as valid.");
			}
		}
		
		/*
		 * Gets threshold for config type
		 * @return null|int|float	null if not supported, otherwise expect a numeral
		 */
		public function getThreshold($configType) {
			switch($configType) {
			case ConfigType::CONFIG_OVERSPEEDING:
				return $this->speedLimit_kmph;
			case ConfigType::CONFIG_IDLING:
				return $this->idleTimeLimit_kmph;
			case ConfigType::CONFIG_HARD_ACCEL:
				return $this->accelLimit_Mpss;
			case ConfigType::CONFIG_HARD_BRAKING:
				return $this->brakeLimit_Mpss;
			case ConfigType::CONFIG_HARD_CORNERING:
				return $this->corneringLimit_Mpss;
			case ConfigType::CONFIG_ENGINE_OVERSPEED:
				return $this->engineSpeedLimit_rpm;
			case ConfigType::CONFIG_PARKING_BRAKE:
				return $this->parkingBrakeLimit_kmph;
			case ConfigType::CONFIG_SEATBELT:
				return $this->seatbeltLimit_kmph;
			case ConfigType::CONFIG_PARKING:
				return $this->parkingTimeoutThreshold_Msec;
			case ConfigType::CONFIG_TRANSPORTED:
				return $this->transportedPingTime_Msec;	
			case ConfigType::CONFIG_STATUS:
				return $this->statusPingTime_Msec;
			case ConfigType::CONFIG_HEALTH:
			case ConfigType::CONFIG_TRIP_REPORT:
			case ConfigType::CONFIG_DIGITAL_INPUT_0:
			case ConfigType::CONFIG_DIGITAL_INPUT_1:
			case ConfigType::CONFIG_DIGITAL_INPUT_2:
			case ConfigType::CONFIG_DIGITAL_INPUT_3:
			case ConfigType::CONFIG_DIGITAL_INPUT_4:
			case ConfigType::CONFIG_DIGITAL_INPUT_5:
			case ConfigType::CONFIG_DIGITAL_INPUT_6:
			case ConfigType::CONFIG_DRIVER_LOG:
			case ConfigType::CONFIG_GREEN_BAND:
				return NULL;
				break;
			default:
				throw new CarmaLinkAPIException("Error: getThreshold for '".$configType."' has failed since '".$configType."' is not recognized as valid.");
			}
		}
		
		/*
		 * Sets allowance of values passed in based on configuration type.
		 * @param	ConfigType	configType	valid config type to change
		 * @param	int	value	value to set allowance too.
		 */
		public function setAllowance($configType, $value = 0) {
			if(!is_integer($value)) { throw new CarmaLinkAPIException("Error: setAllowance for ".$configType." expected value to be integer, ".$value." received"); }
			switch($configType) {
			case ConfigType::CONFIG_OVERSPEEDING:
				$this->speedLimitAllowance_Msec = (int)$value;
				break;
			case ConfigType::CONFIG_IDLING:
				$this->idleTimeLimitAllowance_Msec = (int)$value;
				break;
			case ConfigType::CONFIG_HARD_ACCEL:
				$this->accelLimitAllowance_Msec = (int)$value;
				break;
			case ConfigType::CONFIG_HARD_BRAKING:
				$this->brakeLimitAllowance_Msec = (int)$value;
				break;
			case ConfigType::CONFIG_HARD_CORNERING:
				$this->corneringLimitAllowance_Msec = (int)$value;
				break;
			case ConfigType::CONFIG_ENGINE_OVERSPEED:
				$this->engineSpeedLimitAllowance_Msec = (int)$value;
				break;
			case ConfigType::CONFIG_PARKING_BRAKE:
				$this->parkingBrakeLimitAllowance_Msec = (int)$value;
				break;
			case ConfigType::CONFIG_SEATBELT:
				$this->seatbeltLimitAllowance_Msec = (int)$value;
				break;
			case ConfigType::CONFIG_PARKING:
				$this->parkingTimeoutAllowance_Msec = (int)$value;
				break;
			case ConfigType::CONFIG_TRANSPORTED:
				$this->transportedPingTimeAllowance_Msec = (int)$value;	
				break;
			case ConfigType::CONFIG_STATUS:
				$this->statusPingTimeAllowance_Msec = (int)$value;
				break;
			case ConfigType::CONFIG_HEALTH:
			case ConfigType::CONFIG_TRIP_REPORT:
			case ConfigType::CONFIG_DIGITAL_INPUT_0:
			case ConfigType::CONFIG_DIGITAL_INPUT_1:
			case ConfigType::CONFIG_DIGITAL_INPUT_2:
			case ConfigType::CONFIG_DIGITAL_INPUT_3:
			case ConfigType::CONFIG_DIGITAL_INPUT_4:
			case ConfigType::CONFIG_DIGITAL_INPUT_5:
			case ConfigType::CONFIG_DIGITAL_INPUT_6:
			case ConfigType::CONFIG_DRIVER_LOG:
			case ConfigType::CONFIG_GREEN_BAND:
				throw new CarmaLinkAPIException("Error: setAllowance for '".$configType."' is illegal, as it does not support the allowance parameter.");
				break;
			default:
				throw new CarmaLinkAPIException("Error: setAllowance for '".$configType."' has failed since '".$configType."' is not recognized as valid.");
			}
		}
		
		
		/*
		 * Gets allowance for config type
		 * @return null|int	null if not supported, otherwise expect an int
		 */
		public function getAllowance($configType) {
			switch($configType) {
			case ConfigType::CONFIG_OVERSPEEDING:
				return $this->speedLimitAllowance_Msec;
			case ConfigType::CONFIG_IDLING:
				return $this->idleTimeLimitAllowance_Msec;
			case ConfigType::CONFIG_HARD_ACCEL:
				return $this->accelLimitAllowance_Msec;
			case ConfigType::CONFIG_HARD_BRAKING:
				return $this->brakeLimitAllowance_Msec;
			case ConfigType::CONFIG_HARD_CORNERING:
				return $this->corneringLimitAllowance_Msec;
			case ConfigType::CONFIG_ENGINE_OVERSPEED:
				return $this->engineSpeedLimitAllowance_Msec;
			case ConfigType::CONFIG_PARKING_BRAKE:
				return $this->parkingBrakeLimitAllowance_Msec;
			case ConfigType::CONFIG_SEATBELT:
				return $this->seatbeltLimitAllowance_Msec;
			case ConfigType::CONFIG_PARKING:
				return $this->parkingTimeoutAllowance_Msec;
			case ConfigType::CONFIG_TRANSPORTED:
				return $this->transportedPingTimeAllowance_Msec;
			case ConfigType::CONFIG_STATUS:
				return $this->statusPingTimeAllowance_Msec;
			case ConfigType::CONFIG_HEALTH:
			case ConfigType::CONFIG_TRIP_REPORT:
			case ConfigType::CONFIG_DIGITAL_INPUT_0:
			case ConfigType::CONFIG_DIGITAL_INPUT_1:
			case ConfigType::CONFIG_DIGITAL_INPUT_2:
			case ConfigType::CONFIG_DIGITAL_INPUT_3:
			case ConfigType::CONFIG_DIGITAL_INPUT_4:
			case ConfigType::CONFIG_DIGITAL_INPUT_5:
			case ConfigType::CONFIG_DIGITAL_INPUT_6:
			case ConfigType::CONFIG_DRIVER_LOG:
			case ConfigType::CONFIG_GREEN_BAND:
				return NULL;
			default:
				throw new CarmaLinkAPIException("Error: getAllowance for '".$configType."' has failed since '".$configType."' is not recognized as valid.");
			}
		}

		/*
		 * Sets buzzer volume for use by report events, is called by other functions.
		 * @param	ConfigType	configType	valid config type to change
		 * @param	BuzzerVolume	value	valid buzzer volume to set.
		 */
		public function setBuzzerVolume($configType, $value) {
			switch($value) {
			case BuzzerVolume::HIGH:
			case BuzzerVolume::MED:
			case BuzzerVolume::OFF:
				break;
			default:
				throw new CarmaLinkAPIException("Error: setBuzzer for ".$configType." expected value to be of type 'BuzzerVolume' - ".$value." received");
			}

			switch($configType) {
			case ConfigType::CONFIG_OVERSPEEDING:
					$this->speedLimitBuzzer_Volume = $value;
				break;
			case ConfigType::CONFIG_IDLING:
				$this->idleTimeLimitBuzzer_Volume = $value;
				break;
			case ConfigType::CONFIG_HARD_ACCEL:
				$this->accelLimitBuzzer_Volume = $value;
				break;
			case ConfigType::CONFIG_HARD_BRAKING:
				$this->brakeLimitBuzzer_Volume = $value;
				break;
			case ConfigType::CONFIG_HARD_CORNERING:
				$this->corneringLimitBuzzer_Volume = $value;
				break;
			case ConfigType::CONFIG_ENGINE_OVERSPEED:
				$this->engineSpeedLimitBuzzer_Volume = $value;
				break;
			case ConfigType::CONFIG_PARKING_BRAKE:
				$this->parkingBrakeLimitBuzzer_Volume = $value;
				break;
			case ConfigType::CONFIG_SEATBELT:
				$this->seatbeltLimitBuzzer_Volume = $value;
				break;
			case ConfigType::CONFIG_PARKING:
			case ConfigType::CONFIG_TRANSPORTED:
			case ConfigType::CONFIG_STATUS:
			case ConfigType::CONFIG_HEALTH:
			case ConfigType::CONFIG_TRIP_REPORT:
			case ConfigType::CONFIG_DIGITAL_INPUT_0:
			case ConfigType::CONFIG_DIGITAL_INPUT_1:
			case ConfigType::CONFIG_DIGITAL_INPUT_2:
			case ConfigType::CONFIG_DIGITAL_INPUT_3:
			case ConfigType::CONFIG_DIGITAL_INPUT_4:
			case ConfigType::CONFIG_DIGITAL_INPUT_5:
			case ConfigType::CONFIG_DIGITAL_INPUT_6:
			case ConfigType::CONFIG_DRIVER_LOG:
			case ConfigType::CONFIG_GREEN_BAND:
				throw new CarmaLinkAPIException("Error: setBuzzerVolume for '".$configType."' ' is illegal, as it does not support the buzzer parameter");
				break;
			default:
				throw new CarmaLinkAPIException("Error: setBuzzer for '".$configType."' has failed since '".$configType."' is not recognized as valid.");
			}
		}
		
		/*
		 * Gets buzzer volume for config type if supported, null if not set or unsupported
		 * @param	ConfigType	configType	valid config type
		 * @return	BuzzerVolume|null	returns buzzer volume if set, otherwise null.
		 */
		public function getBuzzerVolume($configType) {
			switch($configType) {
			case ConfigType::CONFIG_OVERSPEEDING:
				return $this->speedLimitBuzzer_Volume;
			case ConfigType::CONFIG_IDLING:
				return $this->idleTimeLimitBuzzer_Volume;
			case ConfigType::CONFIG_HARD_ACCEL:
				return $this->accelLimitBuzzer_Volume;
			case ConfigType::CONFIG_HARD_BRAKING:
				return $this->brakeLimitBuzzer_Volume;
			case ConfigType::CONFIG_HARD_CORNERING:
				return $this->corneringLimitBuzzer_Volume;
			case ConfigType::CONFIG_ENGINE_OVERSPEED:
				return $this->engineSpeedLimitBuzzer_Volume;
			case ConfigType::CONFIG_PARKING_BRAKE:
				return $this->parkingBrakeLimitBuzzer_Volume;
			case ConfigType::CONFIG_SEATBELT:
				return $this->seatbeltLimitBuzzer_Volume;
			case ConfigType::CONFIG_PARKING:
			case ConfigType::CONFIG_TRANSPORTED:
			case ConfigType::CONFIG_STATUS:
			case ConfigType::CONFIG_HEALTH:
			case ConfigType::CONFIG_TRIP_REPORT:
			case ConfigType::CONFIG_DIGITAL_INPUT_0:
			case ConfigType::CONFIG_DIGITAL_INPUT_1:
			case ConfigType::CONFIG_DIGITAL_INPUT_2:
			case ConfigType::CONFIG_DIGITAL_INPUT_3:
			case ConfigType::CONFIG_DIGITAL_INPUT_4:
			case ConfigType::CONFIG_DIGITAL_INPUT_5:
			case ConfigType::CONFIG_DIGITAL_INPUT_6:
			case ConfigType::CONFIG_DRIVER_LOG:
			case ConfigType::CONFIG_GREEN_BAND:
				return NULL;
				break;
			default:
				throw new CarmaLinkAPIException("Error: setBuzzer for '".$configType."' has failed since '".$configType."' is not recognized as valid.");
			}
		}

		/*
		 * Sets optional parameters for use by report events
		 * @param	ConfigType	configType	valid config type to change
		 * @param	array	valueArray	array object of all optional parameters.
		 */
		public function setOptionalParameters($configType, $valueArray) {
			if(!is_array($valueArray)) { throw new CarmaLinkAPIException("Error: setOptionalParameters for '".$configType."' must be of type array."); }
			
			$properFormattedArray;
			if(isset($valueArray[0]) && is_string($valueArray[0]) && !is_bool($valueArray[0])) {
				$properFormattedArray = array();
				foreach($valueArray as $value) {
					$properFormattedArray[$value] = true;
				}
				//convert to proper array.
			} else{
				$properFormattedArray = $valueArray;
			}
			switch($configType) {
			case ConfigType::CONFIG_OVERSPEEDING:
				$this->speedLimitOptionalParameters = $properFormattedArray;
				break;
			case ConfigType::CONFIG_IDLING:
				$this->idleTimeLimitOptionalParameters = $properFormattedArray;
				break;
			case ConfigType::CONFIG_HARD_ACCEL:
				$this->accelLimitOptionalParameters = $properFormattedArray;
				break;
			case ConfigType::CONFIG_HARD_BRAKING:
				$this->brakeLimitOptionalParameters = $properFormattedArray;
				break;
			case ConfigType::CONFIG_HARD_CORNERING:
				$this->corneringLimitOptionalParameters = $properFormattedArray;
				break;
			case ConfigType::CONFIG_ENGINE_OVERSPEED:
				$this->engineSpeedLimitOptionalParameters = $properFormattedArray;
				break;
			case ConfigType::CONFIG_PARKING_BRAKE:
				$this->parkingBrakeLimitOptionalParameters = $properFormattedArray;
				break;
			case ConfigType::CONFIG_SEATBELT:
				$this->seatbeltLimitOptionalParameters = $properFormattedArray;
				break;
			case ConfigType::CONFIG_PARKING:
				$this->parkingTimeoutOptionalParameters = $properFormattedArray;
				break;
			case ConfigType::CONFIG_TRANSPORTED:
				$this->transportedPingTimeOptionalParameters = $properFormattedArray;
				break;
			case ConfigType::CONFIG_STATUS:
				$this->statusPingTimeOptionalParameters = $properFormattedArray;
				break;
			case ConfigType::CONFIG_HEALTH:
				$this->healthOptionalParameters = $properFormattedArray;
				break;
			case ConfigType::CONFIG_TRIP_REPORT:
				$this->tripOptionalParameters = $properFormattedArray;
				break;
			case ConfigType::CONFIG_DIGITAL_INPUT_0:
			case ConfigType::CONFIG_DIGITAL_INPUT_1:
			case ConfigType::CONFIG_DIGITAL_INPUT_2:
			case ConfigType::CONFIG_DIGITAL_INPUT_3:
			case ConfigType::CONFIG_DIGITAL_INPUT_4:
			case ConfigType::CONFIG_DIGITAL_INPUT_5:
			case ConfigType::CONFIG_DIGITAL_INPUT_6:
			case ConfigType::CONFIG_DRIVER_LOG:
			case ConfigType::CONFIG_GREEN_BAND:
				throw new CarmaLinkAPIException("Error: setOptionalParameters for '".$configType."' ' is illegal, as it does not support optional parameters");
				break;
			default:
				throw new CarmaLinkAPIException("Error: setOptionalParameters for '".$configType."' has failed since '".$configType."' is not recognized as valid.");
			}
		}
		
		
		/*
		 * Gets optional parameters used by report events
		 * @param	ConfigType	configType	valid config type to get optoinal parameters are
		 * @return	array|null	valueArray	array object of all optional parameters.
		 */
		public function getOptionalParameters($configType) {
			switch($configType) {
			case ConfigType::CONFIG_OVERSPEEDING:
				return $this->speedLimitOptionalParameters;
			case ConfigType::CONFIG_IDLING:
				return $this->idleTimeLimitOptionalParameters;
			case ConfigType::CONFIG_HARD_ACCEL:
				return $this->accelLimitOptionalParameters;
			case ConfigType::CONFIG_HARD_BRAKING:
				return $this->brakeLimitOptionalParameters;
			case ConfigType::CONFIG_HARD_CORNERING:
				return $this->corneringLimitOptionalParameters;
			case ConfigType::CONFIG_ENGINE_OVERSPEED:
				return $this->engineSpeedLimitOptionalParameters;
			case ConfigType::CONFIG_PARKING_BRAKE:
				return $this->parkingBrakeLimitOptionalParameters;
			case ConfigType::CONFIG_SEATBELT:
				return $this->seatbeltLimitOptionalParameters;
			case ConfigType::CONFIG_PARKING:
				return $this->parkingTimeoutOptionalParameters;
			case ConfigType::CONFIG_TRANSPORTED:
				return $this->transportedPingTimeOptionalParameters;
			case ConfigType::CONFIG_STATUS:
				return $this->statusPingTimeOptionalParameters;
			case ConfigType::CONFIG_HEALTH:
				return $this->healthOptionalParameters;
			case ConfigType::CONFIG_TRIP_REPORT:
				return $this->tripOptionalParameters;
			case ConfigType::CONFIG_DIGITAL_INPUT_0:
			case ConfigType::CONFIG_DIGITAL_INPUT_1:
			case ConfigType::CONFIG_DIGITAL_INPUT_2:
			case ConfigType::CONFIG_DIGITAL_INPUT_3:
			case ConfigType::CONFIG_DIGITAL_INPUT_4:
			case ConfigType::CONFIG_DIGITAL_INPUT_5:
			case ConfigType::CONFIG_DIGITAL_INPUT_6:
			case ConfigType::CONFIG_DRIVER_LOG:
			case ConfigType::CONFIG_GREEN_BAND:
				return null;
			default:
				throw new CarmaLinkAPIException("Error: getOptionalParameters for '".$configType."' has failed since '".$configType."' is not recognized as valid.");
			}
		}
		
		/*
		 * Sets optional conditions for use by report events
		 * @param	ConfigType	configType	valid config type to change
		 * @param	array	valueArray	array object of all optional conditions.
		 */
		public function setOptionalConditions($configType, $valueArray) {
			if(!is_array($valueArray)) { throw new CarmaLinkAPIException("Error: setOptionalParameters for '".$configType."' must be of type array."); }
			
			$properFormattedArray;
			if(isset($valueArray[0]) && is_string($valueArray[0]) && !is_bool($valueArray[0])) {
				$properFormattedArray = array();
				foreach($valueArray as $value) {
					$properFormattedArray[$value] = true;
				}
				//convert to proper array.
			} else{
				$properFormattedArray = $valueArray;
			}
			switch($configType) {
			case ConfigType::CONFIG_OVERSPEEDING:
				$this->speedLimitOptionalConditions = $properFormattedArray;
				break;
			case ConfigType::CONFIG_IDLING:
				$this->idleTimeLimitOptionalConditions = $properFormattedArray;
				break;
			case ConfigType::CONFIG_HARD_ACCEL:
				$this->accelLimitOptionalConditions = $properFormattedArray;
				break;
			case ConfigType::CONFIG_HARD_BRAKING:
				$this->brakeLimitOptionalConditions = $properFormattedArray;
				break;
			case ConfigType::CONFIG_HARD_CORNERING:
				$this->corneringLimitOptionalConditions = $properFormattedArray;
				break;
			case ConfigType::CONFIG_ENGINE_OVERSPEED:
				$this->engineSpeedLimitOptionalConditions = $properFormattedArray;
				break;
			case ConfigType::CONFIG_PARKING_BRAKE:
				$this->parkingBrakeLimitOptionalConditions = $properFormattedArray;
				break;
			case ConfigType::CONFIG_SEATBELT:
				$this->seatbeltLimitOptionalConditions = $properFormattedArray;
				break;
			case ConfigType::CONFIG_PARKING:
				$this->parkingTimeoutOptionalConditions = $properFormattedArray;
				break;
			case ConfigType::CONFIG_TRANSPORTED:
				$this->transportedPingTimeOptionalConditions = $properFormattedArray;
				break;
			case ConfigType::CONFIG_STATUS:
				$this->statusPingTimeOptionalConditions = $properFormattedArray;
				break;
			case ConfigType::CONFIG_HEALTH:
				$this->healthOptionalConditions = $properFormattedArray;
				break;
			case ConfigType::CONFIG_TRIP_REPORT:
				$this->tripOptionalConditions = $properFormattedArray;
				break;
			case ConfigType::CONFIG_DIGITAL_INPUT_0:
			case ConfigType::CONFIG_DIGITAL_INPUT_1:
			case ConfigType::CONFIG_DIGITAL_INPUT_2:
			case ConfigType::CONFIG_DIGITAL_INPUT_3:
			case ConfigType::CONFIG_DIGITAL_INPUT_4:
			case ConfigType::CONFIG_DIGITAL_INPUT_5:
			case ConfigType::CONFIG_DIGITAL_INPUT_6:
			case ConfigType::CONFIG_DRIVER_LOG:
			case ConfigType::CONFIG_GREEN_BAND:
				throw new CarmaLinkAPIException("Error: setOptionalConditions for '".$configType."' ' is illegal, as it does not support optional conditions");
				break;
			default:
				throw new CarmaLinkAPIException("Error: setOptionalConditions for '".$configType."' has failed since '".$configType."' is not recognized as valid.");
			}
		}
		
		
		/*
		 * Gets optional conditions used by report events
		 * @param	ConfigType	configType	valid config type to get optoinal conditoins are
		 * @return	array|null	valueArray	array object of all optional conditions.
		 */
		public function getOptionalConditions($configType) {
			switch($configType) {
			case ConfigType::CONFIG_OVERSPEEDING:
				return $this->speedLimitOptionalConditions;
			case ConfigType::CONFIG_IDLING:
				return $this->idleTimeLimitOptionalConditions;
			case ConfigType::CONFIG_HARD_ACCEL:
				return $this->accelLimitOptionalConditions;
			case ConfigType::CONFIG_HARD_BRAKING:
				return $this->brakeLimitOptionalConditions;
			case ConfigType::CONFIG_HARD_CORNERING:
				return $this->corneringLimitOptionalConditions;
			case ConfigType::CONFIG_ENGINE_OVERSPEED:
				return $this->engineSpeedLimitOptionalConditions;
			case ConfigType::CONFIG_PARKING_BRAKE:
				return $this->parkingBrakeLimitOptionalConditions;
			case ConfigType::CONFIG_SEATBELT:
				return $this->seatbeltLimitOptionalConditions;
			case ConfigType::CONFIG_PARKING:
				return $this->parkingTimeoutOptionalConditions;
			case ConfigType::CONFIG_TRANSPORTED:
				return $this->transportedPingTimeOptionalConditions;
			case ConfigType::CONFIG_STATUS:
				return $this->statusPingTimeOptionalConditions;
			case ConfigType::CONFIG_HEALTH:
				return $this->healthOptionalConditions;
			case ConfigType::CONFIG_TRIP_REPORT:
				return $this->tripOptionalConditions;
			case ConfigType::CONFIG_DIGITAL_INPUT_0:
			case ConfigType::CONFIG_DIGITAL_INPUT_1:
			case ConfigType::CONFIG_DIGITAL_INPUT_2:
			case ConfigType::CONFIG_DIGITAL_INPUT_3:
			case ConfigType::CONFIG_DIGITAL_INPUT_4:
			case ConfigType::CONFIG_DIGITAL_INPUT_5:
			case ConfigType::CONFIG_DIGITAL_INPUT_6:
			case ConfigType::CONFIG_DRIVER_LOG:
			case ConfigType::CONFIG_GREEN_BAND:
				return NULL;
			default:
				throw new CarmaLinkAPIException("Error: getOptionalConditions for '".$configType."' has failed since '".$configType."' is not recognized as valid.");
			}
		}

				/*
		 * Sets if the report is enabled or disabled
		 * @param	ConfigType	configType	valid config type to change
		 * @param	bool	value	is report enabled or not?
		 */
		public function setReportEnabled($configType, $value = FALSE) {
			$rVal = ($value === FALSE);
			switch($configType) {
			case ConfigType::CONFIG_OVERSPEEDING:
				$this->speedLimitReportEnabled = $rVal;
				break;
			case ConfigType::CONFIG_IDLING:
				$this->idleTimeLimitReportEnabled = $rVal;
				break;
			case ConfigType::CONFIG_HARD_ACCEL:
				$this->accelLimitReportEnabled = $rVal;
				break;
			case ConfigType::CONFIG_HARD_BRAKING:
				$this->brakeLimitReportEnabled = $rVal;
				break;
			case ConfigType::CONFIG_HARD_CORNERING:
				$this->corneringLimitReportEnabled = $rVal;
				break;
			case ConfigType::CONFIG_ENGINE_OVERSPEED:
				$this->engineSpeedLimitReportEnabled = $rVal;
				break;
			case ConfigType::CONFIG_PARKING_BRAKE:
				$this->parkingBrakeLimitReportEnabled = $rVal;
				break;
			case ConfigType::CONFIG_SEATBELT:
				$this->seatbeltLimitReportEnabled = $rVal;
				break;
			case ConfigType::CONFIG_PARKING:
				$this->parkingTimeoutReportEnabled = $rVal;
				break;
			case ConfigType::CONFIG_TRANSPORTED:
				$this->transportedPingTimeReportEnabled = $rVal;
				break;
			case ConfigType::CONFIG_STATUS:
				$this->statusPingTimeReportEnabled = $rVal;
				break;
			case ConfigType::CONFIG_HEALTH:
				$this->healthReportEnabled = $rVal;
				break;
			case ConfigType::CONFIG_TRIP_REPORT:
				$this->tripReportEnabled = $rVal;
				break;
			case ConfigType::CONFIG_DIGITAL_INPUT_0:
			case ConfigType::CONFIG_DIGITAL_INPUT_1:
			case ConfigType::CONFIG_DIGITAL_INPUT_2:
			case ConfigType::CONFIG_DIGITAL_INPUT_3:
			case ConfigType::CONFIG_DIGITAL_INPUT_4:
			case ConfigType::CONFIG_DIGITAL_INPUT_5:
			case ConfigType::CONFIG_DIGITAL_INPUT_6:
			case ConfigType::CONFIG_DRIVER_LOG:
			case ConfigType::CONFIG_GREEN_BAND:
				throw new CarmaLinkAPIException("Error: setReportEnabled for '".$configType."' ' is illegal, as these reports are not properly implemented.");
				break;
			default:
				throw new CarmaLinkAPIException("Error: setReportEnabled for '".$configType."' has failed since '".$configType."' is not recognized as valid.");
			}
		}
		
		
		/*
		 * Gets optional conditions used by report events
		 * @param	ConfigType	configType	valid config type to get if the report is enabled or not
		 * @return	bool|null	boolean of if the report is enabled, null is report is unset.
		 */
		public function getReportEnabled($configType) {
			switch($configType) {
			case ConfigType::CONFIG_OVERSPEEDING:
				return $this->speedLimitReportEnabled;
			case ConfigType::CONFIG_IDLING:
				return $this->idleTimeLimitReportEnabled;
			case ConfigType::CONFIG_HARD_ACCEL:
				return $this->accelLimitReportEnabled;
			case ConfigType::CONFIG_HARD_BRAKING:
				return $this->brakeLimitReportEnabled;
			case ConfigType::CONFIG_HARD_CORNERING:
				return $this->corneringLimitReportEnabled;
			case ConfigType::CONFIG_ENGINE_OVERSPEED:
				return $this->engineSpeedLimitReportEnabled;
			case ConfigType::CONFIG_PARKING_BRAKE:
				return $this->parkingBrakeLimitReportEnabled;
			case ConfigType::CONFIG_SEATBELT:
				return $this->seatbeltLimitReportEnabled;
			case ConfigType::CONFIG_PARKING:
				return $this->parkingTimeoutReportEnabled;
			case ConfigType::CONFIG_TRANSPORTED:
				return $this->transportedPingTimeReportEnabled;
			case ConfigType::CONFIG_STATUS:
				return $this->statusPingTimeReportEnabled;
			case ConfigType::CONFIG_HEALTH:
				return $this->healthReportEnabled;
			case ConfigType::CONFIG_TRIP_REPORT:
				return $this->tripReportEnabled;
			case ConfigType::CONFIG_DIGITAL_INPUT_0:
			case ConfigType::CONFIG_DIGITAL_INPUT_1:
			case ConfigType::CONFIG_DIGITAL_INPUT_2:
			case ConfigType::CONFIG_DIGITAL_INPUT_3:
			case ConfigType::CONFIG_DIGITAL_INPUT_4:
			case ConfigType::CONFIG_DIGITAL_INPUT_5:
			case ConfigType::CONFIG_DIGITAL_INPUT_6:
			case ConfigType::CONFIG_DRIVER_LOG:
			case ConfigType::CONFIG_GREEN_BAND:
				return NULL;
			default:
				throw new CarmaLinkAPIException("Error: getReportEnabled for '".$configType."' has failed since '".$configType."' is not recognized as valid.");
			}
		}
		
		/**
		 * Set a full config based on a series on inputs.
		 * If a field is null, it is skipped
		 *@uses setThreshold
		 *@uses setAllowance
		 *@uses setBuzzer
		 *@uses setOptionalParameters
		 *@uses setOptionalConditions
		 *@uses setReportEnabled
		 *@param	ConfigType	configType	ConfigType to be updated
		 *@param	float|null	threshold	Optional param of setting threshold
		 *@param	int|null	allowance	Null if skipped, else sets allowance parameter
		 *@param	BuzzerVolume|null	buzzer	Null if skipped, else sets buzzer_volume parameter
		 *@param	array|null	optionalParameters	Null if skipped, else sets OptionalParameters to a proper array.
		 *@param	array|null	optionalConditions	Null if skipped, else sets OptionalConditions to a proper array.
		 *@param	bool|null	reportEnabled	is the report enabled or not?
		 */
		public function setConfig($configType, $threshold = NULL, $allowance = NULL, $buzzer = NULL,
		                          $optionalParameters = NULL, $optionalConditions = NULL, $reportEnabled = NULL) {
		   	if($threshold          !== NULL) { $this->setThreshold($configType, $threshold); }
		   	if($allowance          !== NULL) { $this->setAllowance($configType, $allowance); }
		   	if($buzzer             !== NULL) { $this->setBuzzerVolume($configType, $buzzer); }
		   	if($optionalParameters !== NULL) { $this->setOptionalParameters($configType, $optionalParameters); }
		   	if($optionalConditions !== NULL) { $this->setOptionalConditions($configType, $optionalConditions); }
		   	if($reportEnabled      !== NULL) { $this->setReportEnabled($configType, $reportEnabled); }
		}
		
		
		/*
		 * Gets Object of a conglomoration of the configuration's setting in the device.
		 *@param	ConfigType	configType	configuration to get.
		 *@return StdObj	object containing all relevant configuration information
		 */
		public function getConfig($configType) {
			$obj = new \StdObj();
			$obj->threshold          = $this->getThreshold($configType);
			$obj->allowance          = $this->getAllowance($configType);
			$obj->buzzerVolume       = $this->getBuzzerVolume($configType);
			$obj->optionalParameters = $this->getOptionalParameters($configType);
			$obj->optionalConditions = $this->getOptionalConditions($configType);
			$obj->reportEnabled      = $this->getReportEnabled($configType);
			
			if($obj->threshold === NULL && $obj->allowance === NULL && $obj->buzzerVolume === NULL &&
			   $obj->optionalParameters === NULL && $obj->optionalConditions === NULL && $obj->reportEnabled !== FALSE) {
			   unset($obj);
			   return NULL;
			}
			$obj->configType         = $configType;
			//this setting is global
			$obj->location           = $this->getUseGps();
			
			
			return $obj;
		}

		/**
		 * Set attached automobile's fuel type
		 * @param CarmaLink\FuelType fuel type
		 * @return void
		 */
		public function setFuelType($fuelType) { $this->fuelType = $fuelType; }
		
		/**
		 * Get attached automobile's fuel type
		 * @return CarmaLink\FuelType
		 */
		public function getFuelType() { return $this->fuelType; }

		/**
		 * Set attached auto's engine displacement
		 * @param float	engine displacement in litres
		 * @return void
		 */
		public function setDisplacement_L($displacement_L = 2.0) { $this->displacement_L = $displacement_L; }

		/**
		 * Get attached auto's engine displacement
		 * @return float litres
		 */
		public function getDisplacement_L() { return $this->displacement_L; }
		
		
		/**
		 * Set state of device paused (true = paused, false = not).
		 * @param bool	Is in paused state (true/false). converted to bool if not bool. 
		 * @return void
		 */
		public function setDevicePaused($devicePaused = false) { $this->isPaused = (true && $devicePaused);  }
		/**
		 * Get device state is paused
		 * @return bool isPaused
		 */
		public function getDevicePaused() { return $this->isPaused; }
		
		
		/**
		 * Set state of device connect interval in minutes
		 * @param int connectInterval_Mins
		 * @return void
		 */
		public function setConnectInterval_Mins($connectInterval_Mins = 0) { $this->connectInterval_Mins = $connectInterval_Mins;  }
		/**
		 * Get device connect interval
		 * @return int connectInterval_Mins
		 */
		public function getConnectInterval_Mins() { return $this->connectInterval_Mins; }
		
		
		/**
		 * Set state of device agps connect interval in hours
		 * @param int agpsConnectInterval_Hrs
		 * @return void
		 */
		public function setAGPSConnectInterval_Hrs($agpsConnectInterval_Hrs = 0) { $this->agpsConnectInterval_Hrs = $agpsConnectInterval_Hrs; }
		/**
		 * Get device agps connect interval
		 * @return int agpsConnectInterval_Hrs
		 */
		public function getAGPSConnectInterval_Hrs() { return $this->agpsConnectInterval_Hrs; }
		
		
		/**
		 * Set state of device ping interval in munytes
		 * @param int pingInterval_Mins
		 * @return void
		 */
		public function setPingInterval_Mins($pingInterval_Mins = 0) { $this->pingInterval_Mins = $pingInterval_Mins; }
		/**
		 * Get device agps connect interval
		 * @return int pingInterval_Mins
		 */
		public function getPingInterval_Mins() { return $this->pingInterval_Mins; }
		
		
		/**
		 * Set device charging battery voltage of generalconfig
		 * @param int chargingVoltage_V
		 * @return void
		 */
		public function setChargingVoltage_V($chargingVoltage_V = 0) { $this->chargingVoltage_V = $chargingVoltage_V; }
		/**
		 * Get device charging battery voltage
		 * @return int chargingVoltage_V
		 */
		public function getChargingVoltage_V() { return $this->chargingVoltage_V; }
		
		
		/**
		 * Set device low  battery voltage 
		 * @param int lowBatteryVoltage_V
		 * @return void
		 */
		public function setLowBatteryVoltage_V($lowBatteryVoltage_V = 0) { $this->lowBatteryVoltage_V = $lowBatteryVoltage_V; }
		/**
		 * Get low battery voltage threshold
		 * @return int lowBatteryVoltage_V
		 */
		public function getLowBatteryVoltage_V() { return $this->lowBatteryVoltage_V; }
		
		
		/**
		 * Set device low  battery minutes threshold
		 * @param int lowBatteryMinutes
		 * @return void
		 */
		public function setLowBatteryMinutes($lowBatteryMinutes = 0) { $this->lowBatteryMinutes = $lowBatteryMinutes; }
		/**
		 * Get low battery voltage time threshold (in minutes)
		 * @return int lowBatteryMinutes
		 */
		public function getLowBatteryMinutes() { return $this->lowBatteryMinutes; }
		
		
		/**
		 * Set device minimum run voltage energy
		 * @param int minimumRunVoltageEnergy
		 * @return void
		 */
		public function setMinimumRunVoltageEnergy($minimumRunVoltageEnergy = 0) { $this->minimumRunVoltageEnergy = $minimumRunVoltageEnergy; }
		/**
		 * Get minimum run voltage energy
		 * @return int minimumRunVoltageEnergy
		 */
		public function getMinimumRunVoltageEnergy() { return $this->minimumRunVoltageEnergy; }
		
		
		/**
		 * Set device maximum off voltage energy
		 * @param int maximumOffVoltageEnergy
		 * @return void
		 */
		public function setMaximumOffVoltageEnergy($maximumOffVoltageEnergy = 0) { $this->maximumOffVoltageEnergy = $maximumOffVoltageEnergy; }
		/**
		 * Get maximum off voltage energy
		 * @return int maximumOffVoltageEnergy
		 */
		public function getMaximumOffVoltageEnergy() { return $this->maximumOffVoltageEnergy; }
		
		
		/**
		 * Set device obd detection protocol
		 * @param string|OBDDetectionType obdDetection
		 * @return void
		 */
		public function setOBDDetection($obdDetection = "") { $this->obdDetection = $obdDetection; }
		/**
		 * Get obd detection protocol
		 * @return string|OBDDetectionType obdDetection
		 */
		public function getOBDDetection() { return $this->obdDetection; }
		
		/**
		 * Set device led pattern mode
		 * @param string|LEDModeType ledMode
		 * @return void
		 */
		public function setLEDMode($ledMode = "") { $this->ledMode = $ledMode; }
		/**
		 * Get device led patter mode
		 * @return string|LEDModeType ledMode
		 */
		public function getLEDMode() { return $this->ledMode; }
		
		/**
		 * Set device maximum uptime hours
		 * @param maximumUptimeHours
		 * @return void
		 */
		public function setMaximumUptimeHours($maximumUptimeHours = 0) { $this->maximumUptimeHours = $maximumUptimeHours; }
		/**
		 * Get device maximum uptime hours
		 * @return int maximumUptimeHours
		 */
		public function getMaximumUptimeHours() { return $this->maximumUptimeHours; }
		
	} //End of class CarmaLink
?>
