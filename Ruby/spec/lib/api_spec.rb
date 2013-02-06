require 'spec_helper'
require 'oauth'

module CarmaLinkSDK

  describe API, "wrapper class for CarmaLink API" do

    before(:all) do
      @api = API.new(CarmaLinkSDK::Spec[:key],CarmaLinkSDK::Spec[:secret],true)
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
    end

    describe "#get_root_uri" do
      it "returns specific URI in accordance with API constants" do
        proto = @api.ssl ? 'https' : 'http'
        API::get_root_uri(@api.ssl).should eq "#{proto}://api.carmalink.com:8282/v1"
      end
    end

    describe ".sanitize_serials" do
      pending
      context "valid serials sent as parameters" do
        it "is true"
      end
      context "invalid serials sent as parameters" do
        it "raises error"
      end
    end

    describe ".get_report" do
      before(:all) do
        config = Config.new(0,10,:overspeeding,true)
        @res_three_params = @api.get_report("400",config,{ "limit" => 5 })
        @res_two_params = @api.get_report("400",config)
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
          subject { @res_three_params }
          it { should have_key(:code) }
          it { shoudl have_key(:response_text) }
          @res_three_params[:code].should.eq "200"
          @res_three_params[:response_text].should_not be_empty
        end
      end
      context "with two parameters" do
        it "return response status and status text"  do
          subject { @res_two_params }
          it { should have_key(:code) }
          it { shoudl have_key(:response_text) }
          @res_two_params[:code].should.eq "200"
          @res_two_params[:response_text].should_not be_empty
        end
      end
    end
    
    vcr_options = { :cassette_name => "configs", :record => :new_episodes }
    
    describe ".get_config", :vcr => vcr_options do
      it "raises error when no parameters are sent" do
        expect{@api.get_config}.to raise_error
      end
      context "when parameter is a Config" do
        before(:all) do
          @result = @api.get_config(534,Config.new(0,0,:overspeeding))
        end
        it("returns code 200") do
          @result[:code].should eq 200
        end
      end

    end

    describe ".put_config" do
      pending
    end

    describe ".delete_config" do
      pending
    end

    describe ".get" do
      pending
    end

    describe ".put" do
      pending
    end

    describe ".delete" do
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
        not_a_hash = Array.new('something')
        expect(@api.api('/some/endpoint',:get,not_a_hash)).to raise_error(ArgumentError)
      end

    end

  end #CarmaLinkAPI

end #module namespace
