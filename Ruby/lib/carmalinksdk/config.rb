module CarmaLinkSDK

	class BaseConfig

		attr_accessor :status 
		
		STATUS = { 
			:unknown => 0,
			:pending_activation => 1,
			:activated => 2,
			:pending_deactivation => 3,
			:deactivated => 4
		}

		def initialize
			@status = STATUS[:unknown]
		end
	end

	class Config < BaseConfig

		CONFIGTYPE = { 
			:overspeeding => "overspeeding",
			:idling	=> "idling",
			:status => "status",
			:enginefault => "engine_fault",
			:hard_braking => "hard_braking",
			:hard_accel => "hard_accel",
			:trip_report => "trip_report",
			:new_deployment => "new_deployment",
			:general => "general_config"
		}

		BUZZER_CONFIGTYPES = [ 
			CONFIGTYPE[:overspeeding],
			CONFIGTYPE[:hard_braking],
			CONFIGTYPE[:hard_accel],
			CONFIGTYPE[:overspeeding]
		]

		LOCATION_CONFIGTYPES = [ 
			CONFIGTYPE[:overspeeding],
			CONFIGTYPE[:hard_braking],
			CONFIGTYPE[:hard_accel],
			CONFIGTYPE[:overspeeding],
			CONFIGTYPE[:status],
			CONFIGTYPE[:idling]
		]
		
		def initialize(threshold = 0,allowance = 0,location = false,config_type = nil) 
			super()
			@threshold = threshold,
			@allowance = allowance,
			@location = location,
			@config_type = config_type
		end

		def is_valid_config?
			CONFIGTYPE.has_value?(@config_type)
		end

		def uses_location?
			LOCATION_CONFIGTYPES.count(@config_type) == 1
		end

		def uses_buzzer?
			BUZZER_CONFIGTYPES.count(@config_type) == 1
		end

	end

	class GeneralConfig  < BaseConfig
		FUELTYPE = {
			:gasoline => "FUEL_GASOLINE",
			:diesel => "FUEL_DIESEL"
		}
	end

end