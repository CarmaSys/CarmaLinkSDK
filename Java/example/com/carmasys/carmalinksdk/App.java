package com.carmasys.carmalinksdk;

import com.carmasys.carmalinksdk.*;
import com.carmasys.carmalinksdk.CarmaLink.BuzzerVolume;
import org.scribe.model.Response;

public class App 
{
    public static void main( String[] args )
    {
    	CarmaLinkAPI api = new CarmaLinkAPI("devfrontend0.carmasys.com",8282,true,true);
    	Response res = api.getReportData("519", ConfigType.ALL_ACTIVITY, null);
    	
    	//Config c = new Config(4,9.343,false);
    	//c.setBuzzer(BuzzerVolume.HIGH);
    	
        System.out.printf("Reponse : %s",res.getBody().toString());
    }
}
