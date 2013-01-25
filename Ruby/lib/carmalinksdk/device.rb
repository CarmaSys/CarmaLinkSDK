
module CarmaLinkSDK
	
	class Device
		attr_accessor(
			:id,
			:ping_time
		)
		PING_DEFAULT = 5000
		def initialize(id = 0)
			@id = id
			@ping_time = PING_DEFAULT

			@configs = {
				:general_config => GeneralConfig.new
			}
			
			Config::ConfigType::ConfigTypes.keys.each do |type|
				if(type == :general_config) then
					next
				end
				@configs[type] = Config.new(0,0,type)
			end
		end

		def set_config(config = nil)
			raise(ArgumentError, 'Config parameter may not be nil') unless 
				config != nil
			raise(ArgumentError, 'Config parameter must be a valid config object') unless
				Config::ConfigType.is_valid?(config.config_type)
			@configs[config.config_type] = config
		end

		def get_config(type)
			@configs[type] 
		end

	end
end