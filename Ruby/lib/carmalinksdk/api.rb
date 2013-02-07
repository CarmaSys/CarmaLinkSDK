require 'oauth'
require 'JSON'

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

  #workhorse
  def api(endpoint = nil, method = :get, params = nil)
    raise(ArgumentError,"must be called with a relative endpoint") unless 
      endpoint.is_a?(String) && !endpoint.strip.empty?
    raise(ArgumentError,"params must be a valid hash") unless 
      params == nil || (params !=nil && params.instance_of?(Hash))
    
    params = method == :put ? JSON.generate(params) : params
    headers = method == :put ? { 'Content-Type' => 'application/json' } : nil

    res = @oauth_consumer.request(method,endpoint,nil,{},params,headers)
    
    { :code => res.code.to_i, :body => res.body }
  end

  def _check_get_params(serial, config)
    raise(ArgumentError, "must be called with a valid CarmaLink serial number") unless 
      serial.to_s.is_number? 
    raise(ArgumentError, "must be called with a valid Config object") unless 
      config.instance_of?(CarmaLinkSDK::Config)
  end

  def _generate_endpoint(serial, config,type = :data)
    '/' << serial.to_s << '/' << type.to_s << '/' << config.config_type.to_s
  end

  def get_config(serial, config)
    _check_get_params(serial,config)
    params = config.id != 0 ? { "id" => config.id } : nil
    get(_generate_endpoint(serial, config, :report_config), params)
  end

  def put_config(serial, config)
    config_hash = config.to_h
    config_hash.delete(:id)
    config_hash.delete(:config_type)
    put(_generate_endpoint(serial, config, :report_config), config_hash)
  end

  def get_report(serial, config, params = nil)
    _check_get_params(serial,config)
    get(_generate_endpoint(serial, config), params)
  end

  def get(endpoint, params = nil)
    if(params && !params.empty?)
      endpoint = endpoint << "?#{URI.encode_www_form(params)}"
    end
    api(endpoint, :get)
  end

  def put(endpoint, params = nil)
    api(endpoint, :put, params)
  end

  def delete(endpoint)
    api(endpoint,:delete)
  end

end