require 'spec_helper'
require 'oauth'

module CarmaLinkSDK

  describe API, "wrapper class for CarmaLink API" do

    before(:each) do
      @api = API.new('KEY','SECRET')
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
          @api.should be_an_instance_of CarmaLinkAPI
        end
        it "raises exception when sent empty string as either parameter" do
          expect{API.new('','asdfsfd')}.to raise_error
          expect{API.new('f','')}.to raise_error
        end
        it "has debugging disabled by default" do
          @api.debug.should eq false
        end
        it "has SSL enabled by default" do
          @api.ssl.should eq true
        end
      end

      context "given three parameters" do
        it "returns a new instance of CarmaLinkAPI" do
          api = API.new('KEY','SECRET',true)
          api.should be_an_instance_of CarmaLinkAPI
        end
        context "third parameter is true" do
          it "has SSL enabled" do
            api = API.new('KEY','SECRET',true)
            api.ssl.should eq true
          end
        end
      end

      context "given four parameters" do
        it "returns new instance of CarmaLinkAPI" do
          expect{API.new('KEY','SECRET',true,true)}.to be_an_instance_of CarmaLinkAPI
        end
        it "sets debugging accordingly" do
          expect{API.new('KEY','SECRET',true,true)}.debug.to eq true
        end
        it "sets SSL accordingly" do
          expect{API.new('KEY','SECRET',true,true)}.ssl.to eq true
        end
      end
    end

    describe ".get_root_uri" do
      it "returns specific URI in accordance with API constant" do
        root_uri = API::get_root_uri
        ssl_str = @api.ssl ? "s" : ""
        root_uri.should eq "http#{ssl_str}://#{OPTIONS[:host]}:#{OPTIONS[:port]}"
      end
    end

    describe ".get_version_string" do
      it "is 'v1'" do
        API::get_version_string.should eq "v1"
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
      pending
      context "with three parameters" do
        it "returns a response object"
        it "raises exception when sent an invalid report type"
      end
      context "with two parameters" do
        it "return a response object" 
      end
    end

    describe ".get_config" do
      pending
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
      pending
    end

  end #CarmaLinkAPI

end #module ref
