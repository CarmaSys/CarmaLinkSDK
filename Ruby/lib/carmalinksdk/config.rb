
class CarmaLinkSDK::BaseConfig
  
  attr_accessor(
    :optional_conditions,
    :optional_params,
    :config_type,
    :status,
    :id
  )
  
  STATUS = [
    :unknown,
    :pending_activation,
    :activated,
    :pending_deactivation,
    :deactivated
  ]
  
  def initialize(config_type = nil,id = 0)
    raise(ArgumentError, 'config_type must not be nil') unless config_type != nil
    @id = id
    @status = :unknown
    @config_type = config_type
    @optional_params = []
    @optional_conditions = []
  end

end

class CarmaLinkSDK::Config < CarmaLinkSDK::BaseConfig

  class ConfigType
    
    ReportTypes = [
      :overspeeding,
      :idling,
      :status,
      :hard_cornering,
      :seatbelt,
      :hard_braking,
      :hard_accel,
      :parking_brake,
      :vehicle_health,
      :trip_report,
      :new_deployment
    ]
    ConfigTypes = [
      :overspeeding,
      :idling,
      :status,
      :seatbelt,
      :parking_brake,      
      :hard_braking,
      :vehicle_health,
      :hard_cornering,
      :hard_accel,
      :trip_report,
      :general_config
    ]
    BuzzerTypes = [
      :overspeeding,
      :seatbelt,
      :parking_brake,      
      :hard_braking,
      :hard_cornering,
      :hard_accel,
      :idling
    ]
    LocationTypes = [
      :overspeeding,
      :parking_brake,      
      :seatbelt,
      :vehicle_health,
      :hard_braking,
      :hard_cornering,
      :hard_accel,
      :overspeeding,
      :status,
      :idling
    ]

    def ConfigType.is_valid?(type)
      ConfigTypes.member?(type)
    end

    def ConfigType.uses_location?(type)
      LocationTypes.member?(type)
    end

    def ConfigType.uses_buzzer?(type)
      BuzzerTypes.member?(type)
    end

  end

  BUZZERVOLUME = {
    :medium => "MEDIUM",
    :high => "HIGH",
    :off => "OFF"
  }

  attr_accessor(
    :threshold,
    :allowance,
    :location,
    :buzzer_volume
  )

  def initialize(
      threshold = 0,
      allowance = 0,
      config_type = nil,
      location = false,
      buzzer_volume = BUZZERVOLUME[:off]
    )
    super(config_type)
    @threshold = threshold
    @allowance = allowance
    @location = location
    @buzzer_volume = buzzer_volume
    if(!is_valid?) then
      raise 'Trying initialize an invalid configuration setup'
    end
  end

  def is_valid?
    if(!uses_location? && @location == true) then
      return false
    end
    if(!uses_buzzer? && @buzzer_volume != BUZZERVOLUME[:off]) then
      return false
    end
    ConfigType.is_valid?(@config_type)
  end

  def uses_location?
    ConfigType.uses_location?(@config_type)
  end

  def uses_buzzer?
    ConfigType.uses_buzzer?(@config_type)
  end

  def to_h
    hash = { 
      :id => id,
      :config_type => config_type,
      :threshold => threshold,
      :allowance => allowance,
    
    }
    if(uses_buzzer?)
      hash[:buzzer] = buzzer_volume
    end
    if(uses_location?)
      hash[:location] = location
    end
    if(!optional_params.empty?)
      hash[:optionalParams] = optional_params
    end
    if(!optional_conditions.empty?)
      hash[:optionalConditions] = optional_conditions
    end
    return hash
  end

end

class CarmaLinkSDK::GeneralConfig  < CarmaLinkSDK::BaseConfig
  attr_accessor(
    :fuel_type,
    :engine_displacement
  )
  FUELTYPE = {
    :gasoline => "FUEL_GASOLINE",
    :diesel => "FUEL_DIESEL"
  }
  def initialize(fuel_type = FUELTYPE[:gasoline], displacement = 2.0)
    super(:general_config)
    @fuel_type = fuel_type
    @engine_displacement = displacement
  end
end
