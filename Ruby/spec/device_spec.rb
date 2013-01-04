require 'spec_helper'

module CarmaLinkSDK

  describe Device, "A CarmaLink device" do
  
    before(:all) do
      @device = Device.new(1)
      @device_blank = Device.new
    end

    describe "#new" do
      context "with single numeric parameter" do
        it "takes a single parameter and returns a new instance of Device" do
          @device.is_instance_of Device
        end
      end
      context "with no parameters" do
        it "takes no parameters returns a new instance of Device" do
          @device_blank.is_instance_of Device
        end
      end

    end
  end
end
