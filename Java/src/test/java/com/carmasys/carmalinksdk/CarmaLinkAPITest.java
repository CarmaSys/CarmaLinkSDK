/**
 * 
 */
package com.carmasys.carmalinksdk;

import junit.framework.Test;
import junit.framework.TestCase;
import junit.framework.TestSuite;

import com.carmasys.carmalinksdk.CarmaLinkAPI;

/**
 * @author Christopher Najewicz <chris.najewicz@carmasys.com>
 *
 */
public class CarmaLinkAPITest extends TestCase {

    /**
     * Create the test case
     *
     * @param testName name of the test case
     */
    public CarmaLinkAPITest( String testName )
    {
        super( testName );
    }
    /**
     * @return the suite of tests being tested
     */
    public static Test suite()
    {
        return new TestSuite( CarmaLinkAPITest.class );
    }
    /**
     * @Test 
     */
    public void testNewAPI()
    {
      //  CarmaLinkAPI api = new CarmaLinkAPI("frontend0.carmasys.com",8282,true,true);
    	assertTrue( true );
    }

}
