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
		public function setID($id) {
			if ($this -> id === $id)
				return;
			$this -> id = (int)$id;
		}

		/**
		 * CarmaLink's serial / ID
		 * @return int
		 */
		public function getID() {
			return $this -> id;
		}

		
		/**
		 * Getter for vehcileHealthConditions
		 *
		 * @return array|bool
		 */
		public function getVehicleHealthConditions()
		{
			if(!isset($this -> vehicleHealthConditions) || count($this->vehicleHealthConditions) === 0) {
				$conditions = Array();
				$index = 0;
				if($this->getUseTirePressure()) {
					$conditions[$index] = Config::TIRE_PRESSURE_CHANGE;	
					$index= $index + 1;
				} 
				if($this->getUseEmissionMonitors())
				{
					$conditions[$index] = Config::EMISSION_MONITORS;
					$index= $index + 1;
				}
				if(empty($conditions))
					return FALSE;
				else
					$this -> setVehicleHealthConditions($conditions);
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
			if(!$conditions) {
				throw new CarmaLinkAPIException("Trying to set vehicleHealthConditions NULL");
			}
		    $this->vehicleHealthConditions = is_array($conditions) ? $conditions : array($conditions);
		}
		
		/**
		 * Getter for useEmissionMonitors
		 *
		 * @return bool
		 */
		public function getUseEmissionMonitors()
		{
		    return $this->useEmissionMonitors;
		}
		
		/**
		 * Setter for useEmissionMonitors
		 *
		 * @param bool $use Value to set
		 * @return void
		 */
		public function setUseEmissionMonistors($use = TRUE)
		{
		    $this->useEmissionMonitors = $use;
		}
		
		/**
		 * Getter for useFuelLevel
		 *
		 * @return bool
		 */
		public function getUseFuelLevel()
		{
		    return $this->useFuelLevel;
		}
		
		/**
		 * Setter for useFuelLevel
		 *
		 * @param bool $use Value to set
		 * @return void
		 */
		public function setUseFuelLevel($use = TRUE)
		{
		    $this->useFuelLevel = $use;
		}
	
	
		/**
		 * Getter for useNextServiceDuration
		 *
		 * @return bool
		 */
		public function getUseNextServiceDuration()
		{
		    return $this->useNextServiceDuration;
		}
		
		/**
		 * Setter for useNextServiceDuration
		 *
		 * @param bool $use Value to set
		 * @return void
		 */
		public function setUseNextServiceDuration($use = TRUE)
		{
		    $this->useNextServiceDuration = $use;
		}
		/**
		 * Getter for useNextServiceDistance
		 *
		 * @return bool
		 */
		public function getUseNextServiceDistance()
		{
		    return $this->useNextServiceDistance;
		}
		
		/**
		 * Setter for useNextServiceDistance
		 *
		 * @param bool $use Value to set
		 * @return void
		 */
		public function setUseNextServiceDistance($use = TRUE)
		{
		    $this->useNextServiceDistance = $use;
		}
		
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
		public function getUseOdometer()
		{
		    return $this->useOdometer;
		}
		
		/**
		 * Setter for useOdometer
		 *
		 * @param bool $Use Value to set
		 * @return void
		 */
		public function setUseOdometer($use)
		{
		    $this->useOdometer = $use;
		}

		/**
		 * Set CarmaLink engine fault
		 * @param bool		checkEngineLight	Use engine fault
		 * @return void
		 */
		public function setCheckEngineLight($checkEngineLight = TRUE) {
			$this -> checkEngineLight = (bool)$checkEngineLight;
		}

		/**
		 * Get CarmaLink engine fault config
		 * @return bool
		 */
		public function getCheckEngineLight() {
			return $this -> checkEngineLight;
		}

		/**
		 * Set CarmaLink global buzzer volume
		 * Can be used to override when setting a configuration which supports buzzer.
		 * @param BuzzerVolume	buzzerVolume	HIGH/MED/OFF
		 * @return void
		 */
		public function setBuzzerVolume($buzzerVolume = BuzzerVolume::BUZZER_OFF) {
			$this -> buzzerVolume = $buzzerVolume;
		}

		/**
		 * Get global CarmaLink volume setting
		 * @return BuzzerVolume	HIGH/MED/OFF
		 */
		public function getBuzzerVolume() {
			return $this -> buzzerVolume;
		}

		/**
		 * Set CarmaLink location tracking / GPS functionality
		 * @param bool	useGPS	On/Off
		 * @return void
		 */
		public function setUseGPS($useGPS) {
			$this -> useGPS = (bool)$useGPS;
		}

		/**
		 * Get CarmaLink location functionality
		 * @return bool
		 */
		public function getUseGPS() {
			return $this -> useGPS;
		}

		/**
		 * Set CarmaLink low tire pressure report
		 * @param bool	useTP	On/Off
		 * @return void
		 */
		public function setUseTirePressure($useTP = TRUE) {
			$this -> useTP = (bool)$useTP;
		}

		/**
		 * Get CarmaLink low tire pressure report enabled
		 * @return bool
		 */
		public function getUseTirePressure() {
			return $this -> useTP;
		}

		/**
		 * Sets the CarmaLink's update interval
		 * @param int	pingTime	The update interval in milliseconds
		 * @return void
		 */
		public function setPingTime($pingTime = 5000) {
			$this -> pingTime = (int)$pingTime;
		}

		/**
		 * Gets the CarmaLink's update interval
		 * @return int	milliseconds
		 */
		public function getPingTime() {
			return $this -> pingTime;
		}

		/**
		 * Set CarmaLink speed limit
		 * @param int		speedLimit		Speed in Km/h
		 * @return void
		 */
		public function setSpeedLimit($speedLimit = 0) {
			$this -> speedLimit = (int)$speedLimit;
		}

		/**
		 * Get CarmaLink speed limit
		 * @return int	Km/h limit
		 */
		public function getSpeedLimit() {
			return $this -> speedLimit;
		}

		/**
		 * Set CarmaLink speed limit allowance
		 * @param float		allowance		allowance time in ms
		 * @return void
		 */
		public function setSpeedLimitAllowance($allowance = 0.0) {
			$this -> speedLimitAllowance = (float)$allowance;
		}

		/**
		 * Get CarmaLink speed limit allowance
		 * @return float allowance time in ms
		 */
		public function getSpeedLimitAllowance() {
			return $this -> speedLimitAllowance;
		}

		/**
		 * Set CarmaLink parking brake limit
		 * @param int|bool		speedLimit		Speed in Km/h
		 * @return void
		 */
		public function setParkingBrakeLimit($speedLimit = 0) {
			$this -> parkingBrakeLimit = ($speedLimit === FALSE) ? FALSE : (int)$speedLimit;
		}

		/**
		 * Get CarmaLink parking brake limit
		 * @return int|bool	Km/h limit or false if disabled
		 */
		public function getParkingBrakeLimit() {
			return ($this -> parkingBrakeLimit === FALSE || $this-> parkingBrakeLimit < 0) ? FALSE : (int)$this->parkingBrakeLimit;
		}

		/**
		 * Set CarmaLink parking brake allowance
		 * @param float		allowance		allowance time in ms
		 * @return void
		 */
		public function setParkingBrakeLimitAllowance($allowance = 0.0) {
			$this -> parkingBrakeLimitAllowance = (float)$allowance;
		}

		/**
		 * Get CarmaLink parking brake allowance
		 * @return float allowance time in ms
		 */
		public function getParkingBrakeLimitAllowance() {
			return $this -> parkingBrakeLimitAllowance;
		}

		/**
		 * Set CarmaLink seatbelt limit
		 * @param int|bool		speedLimit		Speed in Km/h
		 * @return void
		 */
		public function setSeatbeltLimit($speedLimit = 0) {
			$this -> seatbeltLimit = ($speedLimit === FALSE) ? FALSE : (int)$speedLimit;
		}

		/**
		 * Get CarmaLink seatbelt limit
		 * @return int|bool	Km/h limit or false if disabled
		 */
		public function getSeatbeltLimit() {
			return ($this -> seatbeltLimit === FALSE || $this-> seatbeltLimit < 0) ? FALSE : (int)$this->seatbeltLimit;
		}

		/**
		 * Set CarmaLink seatbelt allowance
		 * @param float		allowance		allowance time in ms
		 * @return void
		 */
		public function setSeatbeltLimitAllowance($allowance = 0.0) {
			$this -> seatbeltLimitAllowance = (float)$allowance;
		}

		/**
		 * Get CarmaLink seatbelt allowance
		 * @return float allowance time in ms
		 */
		public function getSeatbeltLimitAllowance() {
			return $this -> seatbeltLimitAllowance;
		}


		/**
		 * Set CarmaLink reverse speed limit
		 * @param int|bool	reverseLimit		Speed in Km/h or FALSE to disable report
		 * @return void
		 */
		public function setReverseLimit($reverseLimit = 0) {
			if($reverseLimit < 0)
				$reverseLimit = FALSE;
			$this -> reverseLimit = $reverseLimit;
		}

		/**
		 * Get CarmaLink speed limit
		 * @return int|bool		Km/h limit or FALSE if report disabled
		 */
		public function getReverseLimit() {
			return $this -> reverseLimit;
		}

		/**
		 * Set CarmaLink reverse speed limit allowance
		 * @param float		allowance		allowance time in ms
		 * @return void
		 */
		public function setReverseLimitAllowance($allowance = 0.0) {
			$this -> reverseLimitAllowance = (float)$allowance;
		}

		/**
		 * Get CarmaLink reverse speed limit allowance
		 * @return float allowance time in ms
		 */
		public function getReverseLimitAllowance() {
			return $this -> reverseLimitAllowance;
		}

		/**
		 * Set CarmaLink brake limit
		 * @param float		brakeLimit		Limit in G's
		 * @return void
		 */
		public function setBrakeLimit($brakeLimit = 0.0) {
			$this -> brakeLimit = (float)$brakeLimit;
		}

		/**
		 * Get CarmaLink brake limit
		 * @return float	In G's
		 */
		public function getBrakeLimit() {
			return $this -> brakeLimit;
		}

		/**
		 * Set CarmaLink brake limit allowance
		 * @param float		allowance		allowance time in ms
		 * @return void
		 */
		public function setBrakeLimitAllowance($allowance = 0.0) {
			$this -> brakeLimitAllowance = (float)$allowance;
		}

		/**
		 * Get CarmaLink brake limit allowance
		 * @return float allowance time in ms
		 */
		public function getBrakeLimitAllowance() {
			return $this -> brakeLimitAllowance;
		}
		
		/**
		 * Set CarmaLink hard conering limit
		 * @param float		cornerLimit		Limit in G's
		 * @return void
		 */
		public function setCorneringLimit($cornerLimit = 0.0) {
			$this -> corneringLimit = (float)$cornerLimit;
		}

		/**
		 * Get CarmaLink hard cornering limit
		 * @return float	In G's
		 */
		public function getCorneringLimit() {
			return $this -> corneringLimit;
		}

		/**
		 * Set CarmaLink hard cornering allowance
		 * @param float		allowance		allowance time in ms
		 * @return void
		 */
		public function setCorneringLimitAllowance($allowance = 0.0) {
			$this -> brakeLimitAllowance = (float)$allowance;
		}

		/**
		 * Get CarmaLink hard cornering allowance
		 * @return float allowance time in ms
		 */
		public function getCorneringLimitAllowance() {
			return $this -> brakeLimitAllowance;
		}

		/**
		 * Set CarmaLink acceleration limit
		 * @param float		accelLimit		Limit in G's
		 * @return void
		 */
		public function setAccelLimit($accelLimit = 0.0) {
			$this -> accelLimit = (float)$accelLimit;
		}

		/**
		 * Get CarmaLink acceleration limit
		 * @return float	In G's
		 */
		public function getAccelLimit() {
			return $this -> accelLimit;
		}
		
		/**
		 * Set CarmaLink accel limit allowance
		 * @param float		allowance		allowance time in ms
		 * @return void
		 */
		public function setAccelLimitAllowance($allowance = 0.0) {
			$this -> accelLimitAllowance = (float)$allowance;
		}

		/**
		 * Get CarmaLink accel limit allowance
		 * @return float allowance time in ms
		 */
		public function getAccelLimitAllowance() {
			return $this -> accelLimitAllowance;
		}

		/**
		 * Set CarmaLink idle time limit
		 * @param int	idleTimeLimit	in milliseconds
		 * @return void
		 */
		public function setIdleTimeLimit($idleTimeLimit = 0) {
			$this -> idleTimeLimit = (int)$idleTimeLimit;
		}

		/**
		 * Get CarmaLink idle time limit
		 * @return int	milliseconds
		 */
		public function getIdleTimeLimit() {
			return $this -> idleTimeLimit;
		}

		/**
		 * Set attached automobile's fuel type
		 * @param CarmaLink\FuelType fuel type
		 * @return void
		 */
		public function setFuelType($fuelType) {
			$this -> fuelType = $fuelType;
		}
		
		/**
		 * Get attached automobile's fuel type
		 * @return CarmaLink\FuelType
		 */
		public function getFuelType() {
			return $this -> fuelType;
		}

		/**
		 * Set attached auto's engine displacement
		 * @param float	engine displacement in litres
		 * @return void
		 */
		public function setDisplacement($displacement = 2.0) {
			$this -> displacement = $displacement;
		}

		/**
		 * Get attached auto's engine displacement
		 * @return float litres
		 */
		public function getDisplacement() {
			return $this -> displacement;
		}
		
	}
	