
module CarmaLinkSDK
	
	class Device

		BUZZERVOLUME = { 
			:medium => "MEDIUM",
			:high => "HIGH",
			:off => "OFF"
		}

		@fuelType = GeneralConfig::FUELTYPE[:gasoline],
		@checkEngineLight = true,
		@buzzerVolume = BUZZERVOLUME[:off],
		@useGPS = false,
		@pingTime = 5000,
		@idleTimeLimit = 60000,
		@speedLimit = 170,
		@brakeLimit,
		@accelLimit,
		@engineDisplacement = 2.0

		def initialize(id)
			@id = id
		end
	
	end

end