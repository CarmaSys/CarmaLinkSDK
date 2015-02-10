<?php
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
		 * Set CarmaLink ID or serial number
		 * @param int	id	serial number of CarmaLink
		 * @return void
		 */
		public function setId($id) { if ($this->id !== $id) { $this->id = (int)$id; } }

		/**
		 * CarmaLink's serial / ID
		 * @return int
		 */
		public function getId() { return $this->id; }
		

		/**
		 * Getter for useTrips
		 *
		 * @return bool
		 */
		public function getUseTrips() { return $this->useTrips; }
		
		/**
		 * Shortcut to set useTrips
		 *
		 * @param bool $use Value to set
		 * @return void
		 */
		public function setUseTrips($use) { $this->useTrips = $use; }


		/**
		 * Getter for useHealth
		 *
		 * @return bool
		 */
		public function getUseHealth() { return $this->useHealth; }
		
		/**
		 * Shortcut to set useHealth
		 *
		 * @param bool $use Value to set
		 * @return void
		 */
		public function setUseHealth($use) { $this->useHealth = $use; }
		/**
		 * Getter for HealthConditions
		 *
		 * @return array|bool
		 */


		public function getHealthConditions()
		{
			if (!$this->healthConditions) { //small check.
				$this->setHealthConditions(array());
			}
		    return $this->healthConditions;
		}
		
		/**
		 * Setter for useHealthConditions
		 *
		 * @param array|string conditions A string or array representing any conditions to set on the health report
		 * @return void
		 */
		public function setHealthConditions($conditions = NULL)
		{
			if (!$conditions) { throw new CarmaLinkAPIException("Trying to set healthConditions NULL"); }
		    $this->healthConditions = is_array($conditions) ? $conditions : array($conditions);
		}
		
		/**
		 * Getter for useBatteryVoltage
		 *
		 * @return bool
		 */
		public function getUseBatteryVoltage() { return $this->useBatteryVoltage; }
		
		/**
		 * Setter for useBatteryVoltage
		 *
		 * @param bool $use Value to set
		 * @return void
		 */
		public function setUseBatteryVoltage($use = TRUE) { $this->useBatteryVoltage = $use; }
		
		/**
		 * Getter for useEmissionMonitors
		 *
		 * @return bool
		 */
		public function getUseEmissionMonitors() { return $this->useEmissionMonitors; }
		
		/**
		 * Setter for useEmissionMonitors
		 *
		 * @param bool $use Value to set
		 * @return void
		 */
		public function setUseEmissionMonistors($use = TRUE) { $this->useEmissionMonitors = $use; }
		
		/**
		 * Getter for useFuelLevel
		 *
		 * @return bool
		 */
		public function getUseFuelLevel() { return $this->useFuelLevel; }
		
		/**
		 * Setter for useFuelLevel
		 *
		 * @param bool $use Value to set
		 * @return void
		 */
		public function setUseFuelLevel($use = TRUE) { $this->useFuelLevel = $use; }
	
		/**
		 * Getter for useFuelRate
		 *
		 * @return bool
		 */
		public function getUseFuelRate() { return $this->useFuelRate; }
		
		/**
		 * Setter for useFuelRate
		 *
		 * @param bool $use Value to set
		 * @return void
		 */
		public function setUseFuelRate($use = TRUE) { $this->useFuelRate = TRUE; }
	
		/**
		 * Getter for useNextServiceDuration
		 *
		 * @return bool
		 */
		public function getUseNextServiceDuration() { return $this->useNextServiceDuration; }
		
		/**
		 * Setter for useNextServiceDuration
		 *
		 * @param bool $use Value to set
		 * @return void
		 */
		public function setUseNextServiceDuration($use = TRUE) { $this->useNextServiceDuration = $use; }

		/**
		 * Getter for useNextServiceDistance
		 *
		 * @return bool
		 */
		public function getUseNextServiceDistance() { return $this->useNextServiceDistance; }
		
		/**
		 * Setter for useNextServiceDistance
		 *
		 * @param bool $use Value to set
		 * @return void
		 */
		public function setUseNextServiceDistance($use = TRUE) { $this->useNextServiceDistance = $use; }
		
		/**
		 * Shortcut to set useNextService(s)
		 *
		 * @param bool $use Value to set
		 * @return void
		 */
		public function setUseNextService($use)
		{
		    $this->useNextServiceDistance = $use;
  		    $this->useNextServiceDuration = $use;
		}
		
		/**
		 * Getter for useOdometer
		 *
		 * @return bool
		 */
		public function getUseOdometer() { return $this->useOdometer; }
		
		/**
		 * Setter for useOdometer
		 *
		 * @param bool $Use Value to set
		 * @return void
		 */
		public function setUseOdometer($use) { $this->useOdometer = $use; }

		/**
		 * Set CarmaLink engine fault
		 * @param bool		checkEngineLight	Use engine fault
		 * @return void
		 */
		public function setCheckEngineLight($checkEngineLight = TRUE) { $this->checkEngineLight = (bool)$checkEngineLight; }

		/**
		 * Get CarmaLink engine fault config
		 * @return bool
		 */
		public function getCheckEngineLight() { return $this->checkEngineLight; }

		/**
		 * Set CarmaLink global buzzer volume
		 * Can be used to override when setting a configuration which supports buzzer.
		 * @param BuzzerVolume	buzzerVolume	HIGH/MED/OFF
		 * @return void
		 */
		public function setBuzzerVolume($buzzerVolume = BuzzerVolume::BUZZER_OFF) { $this->buzzerVolume = $buzzerVolume; }

		/**
		 * Get global CarmaLink volume setting
		 * @return BuzzerVolume	HIGH/MED/OFF
		 */
		public function getBuzzerVolume() { return $this->buzzerVolume; }

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

		/**
		 * Set CarmaLink low tire pressure report
		 * @param bool	useTirePressure	On/Off
		 * @return void
		 */
		public function setUseTirePressure($useTirePressure = TRUE) { $this->useTirePressure = (bool)$useTirePressure; }

		/**
		 * Get CarmaLink low tire pressure report enabled
		 * @return bool
		 */
		public function getUseTirePressure() { return $this->useTirePressure; }

		/**
		 * Sets the CarmaLink's update interval
		 * @param int	pingTime_Msec	The update interval in milliseconds
		 * @return void
		 */
		public function setPingTime_Msec($pingTime_Msec = 5000) { $this->pingTime_Msec = (int)$pingTime_Msec; }

		/**
		 * Gets the CarmaLink's update interval
		 * @return int	milliseconds
		 */
		public function getPingTime_Msec() { return $this->pingTime_Msec; }

		/**
		 * Set CarmaLink speed limit
		 * @param int		speedLimit_kmph		Speed in Km/h
		 * @return void
		 */
		public function setSpeedLimit_kmph($speedLimit_kmph = 0) { $this->speedLimit_kmph = (int)$speedLimit_kmph; }

		/**
		 * Get CarmaLink speed limit
		 * @return int	Km/h limit
		 */
		public function getSpeedLimit_kmph() { return $this->speedLimit_kmph; }

		/**
		 * Set CarmaLink speed limit allowance
		 * @param float		allowance		allowance time in ms
		 * @return void
		 */
		public function setSpeedLimitAllowance_Msec($allowance_Msec = 0.0) { $this->speedLimitAllowance_Msec = (float)$allowance_Msec; }

		/**
		 * Get CarmaLink speed limit allowance
		 * @return float allowance time in ms
		 */
		public function getSpeedLimitAllowance_Msec() { return $this->speedLimitAllowance_Msec; }

		/**
		 * Set CarmaLink engine speed limit
		 * @param int		engineSpeedLimit_rpm		Speed in Rotations per minute
		 * @return void
		 */
		public function setEngineSpeedLimit_rpm($engineSpeedLimit_rpm = 0) { $this->engineSpeedLimit_rpm = (int)$engineSpeedLimit_rpm; }

		/**
		 * Get CarmaLink engine speed limit
		 * @return int	Rotations per Minute limit
		 */
		public function getEngineSpeedLimit_rpm() { return $this->engineSpeedLimit_rpm; }

		/**
		 * Set CarmaLink engine speed limit allowance
		 * @param float		allowance		allowance time in ms
		 * @return void
		 */
		public function setEngineSpeedLimitAllowance_Msec($allowance_Msec = 0.0) { $this->engineSpeedLimitAllowance_Msec = (float)$allowance_Msec; }

		/**
		 * Get CarmaLink speed limit allowance
		 * @return float allowance time in ms
		 */
		public function getEngineSpeedLimitAllowance_Msec() { return $this->engineSpeedLimitAllowance_Msec; }

		/**
		 * Set CarmaLink parking brake limit
		 * @param int|bool		speedLimit_kmph		Speed in Km/h
		 * @return void
		 */
		public function setParkingBrakeLimit_kmph($speedLimit_kmph = 0) { $this->parkingBrakeLimit_kmph = ($speedLimit_kmph === FALSE) ? FALSE : (int)$speedLimit_kmph; }

		/**
		 * Get CarmaLink parking brake limit
		 * @return int|bool	Km/h limit or false if disabled
		 */
		public function getParkingBrakeLimit_kmph() { return ($this->parkingBrakeLimit_kmph === FALSE || $this->parkingBrakeLimit_kmph < 0) ? FALSE : (int)$this->parkingBrakeLimit_kmph; }

		/**
		 * Set CarmaLink parking brake allowance
		 * @param float		allowance		allowance time in ms
		 * @return void
		 */
		public function setParkingBrakeLimitAllowance_Msec($allowance_Msec = 0.0) { $this->parkingBrakeLimitAllowance_Msec = (float)$allowance_Msec; }

		/**
		 * Get CarmaLink parking brake allowance
		 * @return float allowance time in ms
		 */
		public function getParkingBrakeLimitAllowance_Msec() { return $this->parkingBrakeLimitAllowance_Msec; }

		/**
		 * Set CarmaLink seatbelt limit
		 * @param int|bool		speedLimit_kmph		Speed in Km/h
		 * @return void
		 */
		public function setSeatbeltLimit_kmph($speedLimit_kmph = 0) { $this->seatbeltLimit_kmph = ($speedLimit_kmph === FALSE) ? FALSE : (int)$speedLimit_kmph; }

		/**
		 * Get CarmaLink seatbelt limit
		 * @return int|bool	Km/h limit or false if disabled
		 */
		public function getSeatbeltLimit_kmph() { return ($this->seatbeltLimit_kmph === FALSE || $this->seatbeltLimit_kmph < 0) ? FALSE : (int)$this->seatbeltLimit_kmph; }

		/**
		 * Set CarmaLink seatbelt allowance
		 * @param float		allowance		allowance time in ms
		 * @return void
		 */
		public function setSeatbeltLimitAllowance_Msec($allowance_Msec = 0.0) { $this->seatbeltLimitAllowance_Msec = (float)$allowance_Msec; }

		/**
		 * Get CarmaLink seatbelt allowance
		 * @return float allowance time in ms
		 */
		public function getSeatbeltLimitAllowance_Msec() { return $this->seatbeltLimitAllowance_Msec; }


		/**
		 * Set CarmaLink reverse speed limit
		 * @param int|bool	reverseLimit		Speed in Km/h or FALSE to disable report
		 * @return void
		 */
		public function setReverseLimit_kmph($reverseLimit_kmph = 0) { $this->reverseLimit_kmph = ($reverseLimit_kmph < 0) ? FALSE : $reverseLimit_kmph; }

		/**
		 * Get CarmaLink speed limit
		 * @return int|bool		Km/h limit or FALSE if report disabled
		 */
		public function getReverseLimit_kmph() { return $this->reverseLimit_kmph; }

		/**
		 * Set CarmaLink reverse speed limit allowance
		 * @param float		allowance		allowance time in ms
		 * @return void
		 */
		public function setReverseLimitAllowance_Msec($allowance_Msec = 0.0) { $this->reverseLimitAllowance_Msec = (float)$allowance_Msec; }

		/**
		 * Get CarmaLink reverse speed limit allowance
		 * @return float allowance time in ms
		 */
		public function getReverseLimitAllowance_Msec() { return $this->reverseLimitAllowance_Msec; }

		/**
		 * Set CarmaLink brake limit
		 * @param float		brakeLimit		Limit in Meters per second^2
		 * @return void
		 */
		public function setBrakeLimit_Mpss($brakeLimit_Mpss = 0.0) { $this->brakeLimit_Mpss = (float)$brakeLimit_Mpss; }

		/**
		 * Get CarmaLink brake limit
		 * @return float	In Meters per second^2
		 */
		public function getBrakeLimit_Mpss() { return $this->brakeLimit_Mpss; }

		/**
		 * Set CarmaLink brake limit allowance
		 * @param float		allowance		allowance time in ms
		 * @return void
		 */
		public function setBrakeLimitAllowance_Msec($allowance_Msec = 0.0) { $this->brakeLimitAllowance_Msec = (float)$allowance_Msec; }

		/**
		 * Get CarmaLink brake limit allowance
		 * @return float allowance time in ms
		 */
		public function getBrakeLimitAllowance_Msec() { return $this->brakeLimitAllowance_Msec; }
		
		/**
		 * Set CarmaLink hard conering limit
		 * @param float		cornerLimit		Limit in Meters per second^2
		 * @return void
		 */
		public function setCorneringLimit_Mpss($corneringLimit_Mpss = 0.0) { $this->corneringLimit_Mpss = (float)$corneringLimit_Mpss; }

		/**
		 * Get CarmaLink hard cornering limit
		 * @return float	In Meters per second^2
		 */
		public function getCorneringLimit_Mpss() { return $this->corneringLimit_Mpss; }

		/**
		 * Set CarmaLink hard cornering allowance
		 * @param float		allowance		allowance time in ms
		 * @return void
		 */
		public function setCorneringLimitAllowance_Msec($allowance_Msec = 0.0) { $this->corneringLimitAllowance_Msec = (float)$allowance_Msec; }

		/**
		 * Get CarmaLink hard cornering allowance
		 * @return float allowance time in ms
		 */
		public function getCorneringLimitAllowance_Msec() { return $this->corneringLimitAllowance_Msec; }

		/**
		 * Set CarmaLink acceleration limit
		 * @param float		accelLimit		Limit in Meters per second^2
		 * @return void
		 */
		public function setAccelLimit_Mpss($accelLimit_Mpss = 0.0) { $this->accelLimit_Mpss = (float)$accelLimit_Mpss; }

		/**
		 * Get CarmaLink acceleration limit
		 * @return float	In Meters per second^2
		 */
		public function getAccelLimit_Mpss() { return $this->accelLimit_Mpss; }
		
		/**
		 * Set CarmaLink accel limit allowance
		 * @param float		allowance		allowance time in ms
		 * @return void
		 */
		public function setAccelLimitAllowance_Msec($allowance_Msec = 0.0) { $this->accelLimitAllowance_Msec = (float)$allowance_Msec; }

		/**
		 * Get CarmaLink accel limit allowance
		 * @return float allowance time in ms
		 */
		public function getAccelLimitAllowance_Msec() { return $this->accelLimitAllowance_Msec; }

		/**
		 * Set CarmaLink idle time limit
		 * @param int	idleTimeLimit	in milliseconds
		 * @return void
		 */
		public function setIdleTimeLimit_Msec($idleTimeLimit_Msec = 0) { $this->idleTimeLimit_Msec = (int)$idleTimeLimit_Msec; }

		/**
		 * Get CarmaLink idle time limit
		 * @return int	milliseconds
		 */
		public function getIdleTimeLimit_Msec() { return $this->idleTimeLimit_Msec; }

		/**
		 * Set CarmaLink parking Timeout Threshold_Msec
		 * @param int	parkingTimeoutThreshold_Msec	in milliseconds
		 * @return void
		 */
		public function setParkingTimeoutThreshold_Msec($parkingTimeoutThreshold_Msec = 0) { $this->parkingTimeoutThreshold_Msec = (int)$parkingTimeoutThreshold_Msec; }

		/**
		 * Get CarmaLink parking Timeout Allowance_Msec
		 * @return int	milliseconds
		 */
		public function getParkingTimeoutThreshold_Msec() { return $this->parkingTimeoutThreshold_Msec; }

		/**
		 * Set CarmaLink transport ping
		 * @param int	transportedPingTime_Msec	in milliseconds
		 * @return void
		 */
		public function setTransportedPingTime_Msec($transportedPingTime_Msec = 0) { $this->transportedPingTime_Msec = (int)$transportedPingTime_Msec; }
		
		/**
		 * Get CarmaLink transportedPingTime_Msec
		 * @return int	milliseconds
		 */
		public function getTransportedPingTime_Msec() { return $this->transportedPingTime_Msec; }

		/**
		 * Get CarmaLink transportedPingTimeAllowance_Msec
		 * @return int	milliseconds
		 */
		public function getTransportedPingTimeAllowance_Msec() { return $this->transportedPingTimeAllowance_Msec; }

		/**
		 * Set CarmaLink transport ping allowance
		 * @param int	transportedPingTimeAllowance_Msec	in milliseconds
		 * @return void
		 */
		public function setTransportedPingTimeAllowance_Msec($transportedPingTimeAllowance_Msec = 0) { $this->transportedPingTimeAllowance_Msec = (int)$transportedPingTimeAllowance_Msec; }

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
		
	}
?>
