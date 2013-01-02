/**
 * 
 */
package com.carmasys.carmalinksdk;

import com.carmasys.carmalinksdk.Config.*;

import org.scribe.builder.ServiceBuilder;
import org.scribe.oauth.OAuthService;
import org.scribe.model.*;

import java.lang.reflect.Array;
import java.util.HashMap;
import java.util.Map;

/**
 * @author Christopher Najewicz <chris.najewicz@carmasys.com>
 *
 */
public class CarmaLinkAPI extends java.lang.Object {

	public static final String API_VERSION 	= "1";
	public static final String API_REPORT_PATH	= "data";
	public static final String API_CONFIG_PATH	= "report_config";
	public static final String API_PUT_PAYLOAD	= "payload";
	
	private final String 		host;
	private final Integer		port;
	private final Boolean		ssl;
	private final Boolean		debug;
	private final OAuthService 	service;
	
	public CarmaLinkAPI(String key, String secret, String host, Integer port, Boolean ssl, Boolean debug)
	{
		this.service = new ServiceBuilder()
			.provider(CarmaLinkAPIProvider.class)
			.apiKey(key)
			.apiSecret(secret)
			.build();
		
		this.host 	= host;
		this.port 	= port;
		this.ssl 	= ssl;
		this.debug 	= debug;
	}
	
	public Response getReportData(String serials, ConfigType data_type, HashMap<String,Object>params)
	{
		String endpoint = this.generateEndpoint(serials, API_REPORT_PATH, data_type);
		return this.get(endpoint, params);
	}
	
	public Response putConfig(String serials, Config config) 
	{
		String endpoint = this.generateEndpoint(serials, API_CONFIG_PATH, config.getConfigType());
		return this.put(endpoint, config);
	}
	
	private String generateEndpoint(String serials, String path, ConfigType data_type)
	{
		return (new StringBuilder(this.getEndpointURIRoot())
		        	.append("/")
		        	.append(this.getEndpointRelativeRoot())
		        	.append("/")
		        	.append(serials)
		        	.append("/")
		        	.append(path)
		        	.append("/")
		        	.append(data_type.toString())).toString();
	}
	
	protected final String getEndpointRelativeRoot()
	{
		return (new StringBuilder("v").append(CarmaLinkAPI.API_VERSION.toString())).toString();
	}
	
	protected final String getEndpointURIRoot()
	{
		return (new StringBuilder("http")
		        	.append((this.getSSL() ? "s" : ""))
		        	.append("://")
		        	.append(this.getHost())
		        	.append(":")
		        	.append(this.getPort())).toString();
	}
	
	protected Response get(String endpoint, HashMap<String,Object> params) {
		return this.api(endpoint, Verb.GET, params);
	}
	
	protected Response put(String endpoint, Config config) {
		HashMap<String,Object> params = new HashMap<String,Object>();
		params.put(API_PUT_PAYLOAD, config.toJSON());
		return this.api(endpoint, Verb.PUT, params);
	}
	
	protected Response delete(String endpoint) {
		return this.api(endpoint, Verb.DELETE, null);
	}
	
	protected Response api(String endpoint, Verb verb, HashMap<String,Object> params){

		Response res = null;
		OAuthRequest req = new OAuthRequest(verb, endpoint);
		if(verb == Verb.PUT)
		{
			req.addHeader("Content-type", "application/json");
			req.addPayload((String)params.get(API_PUT_PAYLOAD));
		} else if(params != null) {
			for(Map.Entry<String, Object> entry : params.entrySet()) {
				req.addQuerystringParameter(entry.getKey(), (String)entry.getValue().toString());	
			}
		}
		
		this.service.signRequest(Token.empty(), req);
		
		try
		{
			res = req.send();
		}
		catch (Exception e)
		{
			System.out.printf("Connection exception: %s", e.toString());
		}
		return res;
	}
	
	
	public String getHost() 
	{
		return this.host;
	}
	public Integer getPort()
	{
		return this.port;
	}
	public Boolean getSSL()
	{
		return this.ssl;
	}
	public Boolean getDebug()
	{
		return this.debug;
	}
	protected OAuthService getService()
	{
		return this.service;
	}

}
