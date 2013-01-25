require 'spec_helper'

module CarmaLinkSDK

  describe Device, "A CarmaLink device" do
  
    before(:all) do
      Config::ConfigType.send(:remove_const, 'ConfigTypes')
      Config::ConfigType::ConfigTypes = { 
        :foo => "foo",
        :bar => "bar",
        :fud => "fud"
      }

      Config::ConfigType.send(:remove_const, 'BuzzerTypes')
      Config::ConfigType::BuzzerTypes = [
        :foo,
        :fud
      ]

      Config::ConfigType.send(:remove_const, 'LocationTypes')
      Config::ConfigType::LocationTypes = [
        :bar
      ]

      @device = Device.new(1)
      @device_blank = Device.new
    end

    describe "#new" do
      context "with single numeric parameter for ID" do
        it "takes a single parameter and returns a new instance of Device" do
          @device.should be_instance_of Device
        end
        it "should have a 5 second ping time by default" do
          @device.ping_time.should eq Device::PING_DEFAULT
        end
      end
      context "with no parameters" do
        it "takes no parameters returns a new instance of Device" do
          @device_blank.should be_instance_of Device
        end
      end
    end

    describe "#get_config" do 
      it "should return a valid config object when sent a valid type as parameter" do
        valid_configs = Config::ConfigType::ConfigTypes.keys.each do |type|
          @device.get_config(type).should respond_to(:status)
        end
      end
    end

    describe "#set_config" do
      context "with valid configuration" do
        it "should succeed given a valid BaseConfig subclass" do
          gen_config = GeneralConfig.new
          expect{@device.set_config(gen_config)}.not_to raise_error
          config = Config.new(0,0,:foo)
          expect{@device.set_config(config)}.not_to raise_error
        end
      end
      context "with non-buzzer config width buzzer volume set" do
        it "should raise error" do
          config = Config.new(0,0,:foo)
          config.config_type = :bar
          config.buzzer_volume = Config::BUZZERVOLUME[:high]
          expect{@device.set_config(config)}.to raise_error
        end
      end
      context "with nil" do
        it "should raise error" do
          expect{@device.set_config(nil)}.to raise_error
        end
      end
    
    end

  end
end
