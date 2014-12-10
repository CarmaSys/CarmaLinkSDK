<?php
namespace CarmaLink;
	/**
	 * "Abstract" class representing minimum properties of a VehicleCarmaLink
	 *
	 * This class represents a possible starting point for an abstraction
	 * of a VehicleCarmaLink. The getters/setters below are required for some of
	 * the functionality in this SDK.
	 *
	 * @class VehicleCarmaLink
	 */
	abstract class VehicleCarmaLink extends CarmaLink {
		
		/**
		 * Getter for vehcileHealthConditions
		 *
		 * @return array|bool
		 */
		public function getVehicleHealthConditions()
		{
			if (!isset($this->vehicleHealthConditions) || count($this->vehicleHealthConditions) === 0) {
				$conditions = array();
				$index = 0;
				if ($this->getUseTirePressure())     { $conditions[$index] = Config::TIRE_PRESSURE_LOW;   $index++; } 
				if ($this->getUseEmissionMonitors()) { $conditions[$index] = Config::EMISSION_MONITORS;   $index++; }
				if ($this->getUseBatteryVoltage())   { $conditions[$index] = Config::BATTERY_VOLTAGE_LOW; $index++; }
				if (empty($conditions)) { return FALSE; }
				$this->setVehicleHealthConditions($conditions);
			}
		    return $this->vehicleHealthConditions;
		}
		
		/**
		 * Setter for useVehicleHealthReport
		 *
		 * @param array|string conditions A string or array representing any conditions to set on the vehicle health report
		 * @return void
		 */
		public function setVehicleHealthConditions($conditions = NULL)
		{
			if (!$conditions) { throw new CarmaLinkAPIException("Trying to set vehicleHealthConditions NULL"); }
		    $this->vehicleHealthConditions = is_array($conditions) ? $conditions : array($conditions);
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
		 * Getter for useFuelLevel
		 *
		 * @return bool
		 */

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
	}
	
