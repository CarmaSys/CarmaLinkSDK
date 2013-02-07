require 'vcr'

VCR.configure do |c| 
  c.ignore_request do | request| 
    URI.split(request.uri)[5] == '/v1/some/endpoint'
  end
  c.cassette_library_dir = 'spec/fixtures/vcr_cassettes'
	c.hook_into :webmock
  c.default_cassette_options = { :record => :new_episodes }
  c.configure_rspec_metadata!
end
