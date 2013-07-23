require 'spec_helper'
require 'oauth'

module CarmaLinkSDK

  describe API, "wrapper class for CarmaLink API" do

    vcr_options_config = { :cassette_name => "configs", :record => :new_episodes }
    vcr_options_report = { :cassette_name => "reports", :record => :new_episodes }

    before(:all) do
      @api = API.new(Spec[:key],Spec[:secret],true)
    end

    describe ".new" do
      context "given less than two parameters" do
        it "raises an exception" do
          expect{API.new}.to raise_error
          expect{API.new('MY_KEY')}.to raise_error
        end
      end
      context "given two parameters" do
        it "raises an exception when nil is sent for either" do
          expect{API.new(nil,'asdfsfd')}.to raise_error
          expect{API.new('asdf',nil)}.to raise_error
        end
        it "returns new instance when sent a valid API key and secret" do
          @api.should be_an_instance_of API
        end
        it "raises exception when sent empty string as either parameter" do
          expect{API.new('','asdfsfd')}.to raise_error
          expect{API.new('f','')}.to raise_error
        end
      end
      context "given three parameters" do
        it "returns a new instance of CarmaLinkAPI" do
          @api.should be_an_instance_of API
        end
      end
      context "given four parameters" do
        subject { API.new('KEY','SECRET',true,true) }
        it { should be_an_instance_of API }
      end
    end #.new

    describe "#get_root_uri" do
      it "returns specific URI in accordance with API constants" do
        proto = @api.ssl ? 'https' : 'http'
        API::get_root_uri(@api.ssl).should eq "#{proto}://api.carmalink.com:8282/v1"
      end
    end ##get_root_uri

    describe ".sanitize_serials" do
      pending
      context "valid serials sent as parameters" do
        it "is true"
      end
      context "invalid serials sent as parameters" do
        it "raises error"
      end
    end #.sanitize_serials

    describe ".get_report", :vcr => vcr_options_report do
      before(:all) do
        @overspeed_config = Config.new(0,0,:overspeeding,true) 
      end
     
      context "with zero or one parameters" do
        it "raises an exception" do
          expect{ @api.get_report }.to raise_error
          expect{ @api.get_report("434") }.to raise_error
        end
      end
      # these do should be re-written / dry
      context "with three parameters" do
        it "return response status and status text"  do
          res_three_params = @api.get_report("541",@overspeed_config,{ "limit" => 5 })
          res_three_params.should have_key(:code) 
          res_three_params.should have_key(:body) 
          res_three_params[:code].should eq 200
          res_three_params[:body].should_not be_empty
        end
      end
      context "with two parameters" do
        it "return response status and status text"  do
          res_two_params = @api.get_report(541,@overspeed_config)
          res_two_params.should have_key(:code) 
          res_two_params[:code].should eq 200
          res_two_params.should have_key(:body) 
          res_two_params[:body].should_not be_empty
        end
      end
    end #.get_report
    
    describe ".get_config", :vcr => vcr_options_config do
      it "raises error when no parameters are sent" do
        expect{@api.get_config}.to raise_error
      end
      context "when parameter is a Config" do
        let(:overspeed_config) { Config.new(0,0,:overspeeding) }
        let(:res_config) { @api.get_config(534,overspeed_config) }
        it("returns code 200") do
          res_config[:code].to_i.should eq 200
        end
        it("is not be nil") do
          res_config.should_not be_nil
        end
        it("returns a JSON object") do
          res_config[:body].should_not be_nil
        end
      end
    end #.get_config

    describe ".put_config", :vcr => vcr_options_config do
      context "when sent no or one parameters" do
        it "raises an ArgumentError" do
          expect{@api.put_config}.to raise_error(ArgumentError)
          expect{@api.put_config(500)}.to raise_error(ArgumentError)
        end
      end
      context "when sent an invalid Config" do
        pending
      end
      context "when sent a valid Config object and serial" do 
        it "returns code 204" do
          put_response = @api.put_config(541,Config.new(10,0,:hard_accel,true))
          put_response.should have_key(:code)
          put_response[:code].should eq 204
        end
      end
    end

    describe ".delete_config" do
      pending
    end

    describe ".api" do
      it "raises an error if an endpoint isn't sent as parameter" do
        expect{@api.api}.to raise_error(ArgumentError)
      end
      it "raises an error if sent empty string for endpoint" do
        expect{@api.api(' ')}.to raise_error(ArgumentError)
      end
      it "raises an error if an invalid HTTP method is sent" do
        expect{@api.api('/some/endpoint',:NOT_A_VALID_METHOD)}.to raise_error(ArgumentError)
      end
      it "raises an error if sent an invalid hash for parameters" do
        not_a_hash = ['something']
        expect{@api.api('/some/endpoint',:get,not_a_hash)}.to raise_error(ArgumentError)
      end
    end #.api

  end #CarmaLinkAPI

end #module namespace
