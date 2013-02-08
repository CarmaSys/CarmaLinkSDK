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
		 * @return self
		 */
		public function setUseNextServiceDuration($use)
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
		 * @return self
		 */
		public function setUseNextServiceDistance($use)
		{
		    $this->useNextServiceDistance = $use;
		}
		
		/**
		 * Shortcut to set useNextService(s)
		 *
		 * @param bool $use Value to set
		 * @return self
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
		 * @return self
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
		public function setCheckEngineLight($checkEngineLight = false) {
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
	