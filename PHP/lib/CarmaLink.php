<?php
namespace CarmaLink;
	/**
	 * "Abstract" class representing minimum properties of a CarmaLink
	 *
	 * This class represents a possible starting point for an abstraction
	 * of a CarmaLink. The getters/setters below are required for some of
	 * the functionality in this SDK.
	 *
	 * @deprecated As of CarmaLinkAPI v1.5.0
	 * Please define your own interface
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
		 * Getter for vehcileHealthConditions
		 *
		 * @return array|bool
		 */
		public function getVehicleHealthConditions()
		{
			if (!isset($this->vehicleHealthConditions) || count($this->vehicleHealthConditions) === 0) {
				$conditions = Array();
				$index = 0;
				if ($this->getUseTirePressure())     { $conditions[$index] = Config::TIRE_PRESSURE_CHANGE; $index++; } 
				if ($this->getUseEmissionMonitors()) { $conditions[$index] = Config::EMISSION_MONITORS;    $index++; }

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
		 * @param bool	useTP	On/Off
		 * @return void
		 */
		public function setUseTirePressure($useTP = TRUE) { $this->useTP = (bool)$useTP; }

		/**
		 * Get CarmaLink low tire pressure report enabled
		 * @return bool
		 */
		public function getUseTirePressure() { return $this->useTP; }

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
		 * @param int		speedLimit_Kmph		Speed in Km/h
		 * @return void
		 */
		public function setSpeedLimit_Kmph($speedLimit_Kmph = 0) { $this->speedLimit_Kmph = (int)$speedLimit_Kmph; }

		/**
		 * Get CarmaLink speed limit
		 * @return int	Km/h limit
		 */
		public function getSpeedLimit_Kmph() { return $this->speedLimit_Kmph; }

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
		 * Set CarmaLink parking brake limit
		 * @param int|bool		speedLimit_Kmph		Speed in Km/h
		 * @return void
		 */
		public function setParkingBrakeLimit_Kmph($speedLimit_Kmph = 0) { $this->parkingBrakeLimit_Kmph = ($speedLimit_Kmph === FALSE) ? FALSE : (int)$speedLimit_Kmph; }

		/**
		 * Get CarmaLink parking brake limit
		 * @return int|bool	Km/h limit or false if disabled
		 */
		public function getParkingBrakeLimit_Kmph() { return ($this->parkingBrakeLimit_Kmph === FALSE || $this->parkingBrakeLimit_Kmph < 0) ? FALSE : (int)$this->parkingBrakeLimit_Kmph; }

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
		 * @param int|bool		speedLimit_Kmph		Speed in Km/h
		 * @return void
		 */
		public function setSeatbeltLimit_Kmph($speedLimit_Kmph = 0) { $this->seatbeltLimit_Kmph = ($speedLimit_Kmph === FALSE) ? FALSE : (int)$speedLimit_Kmph; }

		/**
		 * Get CarmaLink seatbelt limit
		 * @return int|bool	Km/h limit or false if disabled
		 */
		public function getSeatbeltLimit_Kmph() { return ($this->seatbeltLimit_Kmph === FALSE || $this->seatbeltLimit_Kmph < 0) ? FALSE : (int)$this->seatbeltLimit_Kmph; }

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
		public function setReverseLimit_Kmph($reverseLimit_Kmph = 0) { $this->reverseLimit_Kmph = ($reverseLimit_Kmph < 0) ? FALSE : $reverseLimit_Kmph; }

		/**
		 * Get CarmaLink speed limit
		 * @return int|bool		Km/h limit or FALSE if report disabled
		 */
		public function getReverseLimit_Kmph() { return $this->reverseLimit_Kmph; }

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
		 * @param float		brakeLimit		Limit in G's
		 * @return void
		 */
		public function setBrakeLimit_Gs($brakeLimit_Gs = 0.0) { $this->brakeLimit_Gs = (float)$brakeLimit_Gs; }

		/**
		 * Get CarmaLink brake limit
		 * @return float	In G's
		 */
		public function getBrakeLimit_Gs() { return $this->brakeLimit_Gs; }

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
		 * @param float		cornerLimit		Limit in G's
		 * @return void
		 */
		public function setCorneringLimit_Gs($corneringLimit_Gs = 0.0) { $this->corneringLimit_Gs = (float)$corneringLimit_Gs; }

		/**
		 * Get CarmaLink hard cornering limit
		 * @return float	In G's
		 */
		public function getCorneringLimit_Gs() { return $this->corneringLimit_Gs; }

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
		 * @param float		accelLimit		Limit in G's
		 * @return void
		 */
		public function setAccelLimit_Gs($accelLimit_Gs = 0.0) { $this->accelLimit_Gs = (float)$accelLimit_Gs; }

		/**
		 * Get CarmaLink acceleration limit
		 * @return float	In G's
		 */
		public function getAccelLimit_Gs() { return $this->accelLimit_Gs; }
		
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
	}
	