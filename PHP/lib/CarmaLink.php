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
		 * Get CarmaLink Device display name (type of CarmaLink, followed by serial
		 * @return string name
		 */
		public function getDeviceName() { return "CarmaLink-".$this->id; }
		
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
		
		//the following are general configurations that hold true for any and all devices, since the record will always be on every device.
		
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
		 * @param connectInterval_Mins
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
		 * @param agpsConnectInterval_Hrs
		 * @return void
		 */
		public function setAGPSConnectInterval_Mins($agpsConnectInterval_Hrs = 0) { $this->agpsConnectInterval_Hrs = $agpsConnectInterval_Hrs; }
		/**
		 * Get device agps connect interval
		 * @return int agpsConnectInterval_Hrs
		 */
		public function getAGPSConnectInterval_Mins() { return $this->agpsConnectInterval_Hrs; }
		
		
		/**
		 * Set device charging battery voltage of generalconfig
		 * @param chargingVoltage_V
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
		 * @param lowBatteryVoltage_V
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
		 * @param lowBatteryMinutes
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
		 * @param minimumRunVoltageEnergy
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
		 * @param maximumOffVoltageEnergy
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
		 * @param obdDetection
		 * @return void
		 */
		public function setOBDDetection($obdDetection = "") { $this->obdDetection = $obdDetection; }
		/**
		 * Get obd detection protocol
		 * @return string|OBDDetectionType obdDetection
		 */
		public function getOBDDetection() { return $this->obdDetection; }
		
	}
?>
