require 'spec_helper'

module CarmaLinkSDK

  describe Device, "A CarmaLink device" do
  
    before(:all) do
      Config::ConfigType.send(:remove_const, 'ConfigTypes')
      Config::ConfigType::ConfigTypes = [
        :foo,
        :bar,
        :fud,
        :general_config
      ]

      Config::ConfigType.send(:remove_const, 'BuzzerTypes')
      Config::ConfigType::BuzzerTypes = [
        :foo,
        :fud
      ]

      Config::ConfigType.send(:remove_const, 'LocationTypes')
      Config::ConfigType::LocationTypes = [
        :bar
      ]

      Device.send(:remove_const, 'PING_DEFAULT')
      Device::PING_DEFAULT = 10

      @device = Device.new(1)
      @device_blank = Device.new
    end

    describe ".new" do
      context "with single numeric parameter for ID" do
        it "returns a new instance of Device" do
          @device.should be_instance_of Device
        end
        it "has a default ping" do
          @device.ping_time.should eq Device::PING_DEFAULT
        end
      end
      context "with no parameters" do
        it "returns a new instance of Device" do
          @device_blank.should be_instance_of Device
        end
      end
    end

    describe ".get_config" do 
      it "should return a valid config object when sent a valid type as parameter" do
        valid_configs = Config::ConfigType::ConfigTypes.each do |type|
          @device.get_config(type).should respond_to(:status)
        end
      end
    end

    describe ".set_config" do
      context "with valid general configuration" do
        it "does not raise errors" do
          gen_config = GeneralConfig.new
          expect{@device.set_config(gen_config)}.not_to raise_error
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
