require 'oauth'

class CarmaLinkSDK::API

  attr_accessor :oauth_consumer, :ssl, :debug

  API_HOST = 'api.carmalink.com'
  API_PORT = 8282
  API_VERSION = 1
  
  def self.get_root_uri(use_ssl = true)
    'http' << (use_ssl ? 's' : '') << '://' << self::API_HOST << ':' << self::API_PORT.to_s << '/v' << self::API_VERSION.to_s
  end

  def initialize(api_key = nil,api_secret = nil, use_ssl = true, debug = false)
    raise(ArgumentError, 'API key and API secret must be strings') unless 
      api_key != nil && !api_key.empty?  && api_secret != nil && !api_secret.empty? 
    @ssl = use_ssl
    @debug = debug
    @oauth_consumer = OAuth::Consumer.new(api_key,api_secret, :site => CarmaLinkSDK::API.get_root_uri(@ssl))
  end 

  def api(endpoint = nil, method = :get, parameters = {})
    raise(ArgumentError,"API must be called with a relative endpoint") unless 
      endpoint != nil && !endpoint.empty?
    res = @oauth_consumer.request(method,endpoint)
    { :code => res.code.to_i, :body => res.body }
  end

  
end