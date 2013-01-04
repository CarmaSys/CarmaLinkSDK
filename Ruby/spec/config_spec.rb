require 'spec_helper'

module CarmaLinkSDK

	describe BaseConfig, "A base abstraction of a configuration for a CarmaLink" do
		
		before(:each) do
			@base_config = BaseConfig.new
		end

		describe "#new" do
			it "takes no parameters and returns new instance of BaseConfig" do
				@base_config.should be_instance_of BaseConfig
			end
			it "should have a unknown status by default" do
				@base_config.status.should eq BaseConfig::STATUS[:unknown]
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
			@general_config = GeneralConfig.new
		end

		describe "#new" do
			context "takes no parameters" do
				it "creates and returns new instance of GeneralConfig" do
					@general_config.should be_instance_of GeneralConfig
				end
			end
		end


	end


	describe Config, "A report configuration for a CarmaLink" do
		
		before(:all) do
			Config.send(:remove_const, 'CONFIGTYPE')
			Config::CONFIGTYPE = { 
				:foo => "foo",
				:bar => "bar",
				:fud => "fud"
			}

			Config.send(:remove_const, 'BUZZER_CONFIGTYPES')
			Config::BUZZER_CONFIGTYPES = [
				Config::CONFIGTYPE[:foo],
				Config::CONFIGTYPE[:fud]
			]

			Config.send(:remove_const, 'LOCATION_CONFIGTYPES')
			Config::LOCATION_CONFIGTYPES = [
				Config::CONFIGTYPE[:bar]
			]
		end

		before(:each) do 
			@config = Config.new(1.0,203.4,true,Config::CONFIGTYPE[:foo])
			@config_blank = Config.new
		end

		describe "#new" do
			context "with no parameters" do
				it "takes no parameters and returns a Config object" do
					@config_blank.should be_an_instance_of Config
				end
			end
			context "with four parameters" do
				it "takes four parameters and returns a Config object" do
					@config.should be_an_instance_of Config
				end
			end
		end

		describe "#uses_buzzer?" do
				context "configtype uses buzzer" do
					it "returns true" do
						@config.uses_buzzer?.should be true
					end
				end
				context "doesn't use buzzer" do
					it "returns false" do
						config = Config.new(0,0,false,Config::CONFIGTYPE[:bar])
						config.uses_buzzer?.should be false
					end
				end
		end

		describe "#uses_location?" do 
			it "determines if an instance's configuration uses the location flag" do
				config = Config.new(0,0,true,Config::CONFIGTYPE[:bar])
				config.uses_location?.should be true
			end
			it "determines if an instance's configuration doesn't use the location flag" do
				config = Config.new(0,0,true,Config::CONFIGTYPE[:foo])
				config.uses_location?.should be false
			end
		end

		describe "#is_valid_config?" do
			it "determines if an instance has a valid config type" do
				@config.is_valid_config?.should be true
			end
			it "determines if an instance has an invalid config type" do
				@config_blank.is_valid_config?.should be false
			end

		end

	end

end