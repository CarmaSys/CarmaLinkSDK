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

/**
 * @author Christopher Najewicz <chris.najewicz@carmasys.com>
 *
 */
public class CarmaLinkAPI extends java.lang.Object {

	
	public static final String API_VERSION 	= "1";
	public static final String API_REPORT_PATH	= "data";
	public static final String API_CONFIG_PATH	= "report_config";
	
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
	
	private String generateEndpoint(String serials, String path, ConfigType data_type)
	{
		return this.getEndpointURIRoot() + "/" + this.getEndpointRelativeRoot() + "/" + serials + "/" + path + "/" + data_type.toString();
	}
	
	protected final String getEndpointRelativeRoot()
	{
		return "v" + CarmaLinkAPI.API_VERSION.toString();
	}
	
	protected final String getEndpointURIRoot()
	{
		return "http" + (this.getSSL() ? "s" : "") + "://"  + this.getHost() + ":" + this.getPort();
	}
	
	protected Response get(String endpoint, HashMap<String,Object> params) {
		return this.api(endpoint, Verb.GET, params);
	}
	
	
	protected Response api(String endpoint, Verb verb, HashMap<String,Object> params){
		Array put_data = null;
		Array headers = null;
		Response res = null;
		OAuthRequest req = new OAuthRequest(verb, endpoint);
		this.service.signRequest(Token.empty(), req);
		
		if(verb == Verb.PUT)
		{
			
		}
		try {
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
