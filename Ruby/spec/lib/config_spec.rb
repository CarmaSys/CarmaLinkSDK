require 'spec_helper'

module CarmaLinkSDK

  describe BaseConfig, "A base abstraction of a configuration for a CarmaLink" do

    describe ".new" do
      context "takes no parameters" do
        it "should raise an exception" do
          expect{BaseConfig.new}.to raise_error
        end
      end
      context "takes a single parameter of a valid config type" do
        it "should return a instance of BaseConfig" do
          config = BaseConfig.new(:general_config)
          config.should be_instance_of BaseConfig
        end
      end
    end

  end #end BaseConfig

  describe GeneralConfig, "A general configuration for a CarmaLink" do
    before(:all) do
      GeneralConfig.send(:remove_const, 'FUELTYPE')
      GeneralConfig::FUELTYPE = {
        :gas => "gas",
        :mr_fusion => "fusion"
      }
    end
    before(:each) do
      @general_config = GeneralConfig.new(GeneralConfig::FUELTYPE[:mr_fusion],5.0)
      @general_config_blank = GeneralConfig.new
    end

    describe ".new" do
      context "takes no parameters" do
        it "creates and returns new instance of GeneralConfig" do
          @general_config_blank.should be_instance_of GeneralConfig
        end
      end
      context "takes two parameters" do
        it "takes two parameters and returns new instance of GeneralConfig" do
          @general_config.should be_instance_of GeneralConfig
          @general_config.fuel_type.should eq GeneralConfig::FUELTYPE[:mr_fusion]
          @general_config.engine_displacement.should eq 5.0
        end
      end
    end

  end

  describe Config, "A report configuration for a CarmaLink" do

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
      @config = Config.new(1.0,203.4,:foo)
    end

    describe ".new" do
      context "with no parameters" do
        it "takes no parameters and raises error" do
          expect{Config.new}.to raise_error
        end
      end
      context "with three parameters" do
        it "takes three parameters and returns a Config object" do
          @config.should be_an_instance_of Config
        end
      end
      context "with invalid config" do
        it "non-buzzer type with buzzer volume on should raise error" do
          expect{Config.new(1.0,0,:bar,true,Config::BUZZERVOLUME[:high])}.to raise_error
        end
        it "non-location type with location on should raise error" do
          expect{Config.new(1.0,0,:fud,true)}.to raise_error
        end
        it "made up config type should raise error" do
          expect{Config.new(0.0,0,:ijustmadethisup)}.to raise_error
        end
      end

    end

    describe ".uses_buzzer?" do
      context "configtype uses buzzer" do
        it "returns true" do
          @config.uses_buzzer?.should eq true
        end
      end
      context "doesn't use buzzer" do
        it "returns false" do
          config = Config.new(0,0,:bar,false)
          config.uses_buzzer?.should eq false
        end
      end
    end

    describe ".uses_location?" do
      it "determines if an instance's configuration uses the location flag" do
        config = Config.new(0,0,:bar,true)
        config.uses_location?.should eq true
      end
      it "determines if an instance's configuration shouldn't use the location flag" do
        config = Config.new(0,0,:bar,true)
        config.config_type = :foo
        config.uses_location?.should eq false
      end
    end

    describe ".is_valid?" do
      context "valid config" do
        it "should return true when using a location type and location enabled" do
          config_w_location = Config.new(1.0,0,:bar)
          config_w_location.is_valid?.should eq true
        end
        it "should return true when using a buzzer type and buzzer volume is on" do
          config_w_buzzer = Config.new(1.0,0,:fud,false,Config::BUZZERVOLUME[:medium])
          config_w_buzzer.is_valid?.should eq true
        end
      end
    end

  end
end
