package com.carmasys.carmalinksdk;

import org.testng.annotations.AfterClass;
import org.testng.annotations.Test;
import org.testng.annotations.BeforeClass;
import org.testng.AssertJUnit;
import org.testng.Assert;
import org.testng.annotations.Test;
import org.testng.annotations.DataProvider;
import org.testng.annotations.BeforeClass;
import org.testng.annotations.AfterClass;

public class CarmaLinkAPITest {

	private CarmaLinkAPI api;
  @Test(dataProvider = "dp")
  public void f(Integer n, String s) {
  }

  @DataProvider
  public Object[][] dp() {
    return new Object[][] {
      new Object[] { 1, "a" },
      new Object[] { 2, "b" },
    };
  }

  @BeforeClass
  public void beforeClass() {
	  this.api = new CarmaLinkAPI("My_KEY","My_SECRET","api.carmalink.com",8080,false,true);
  }

  @AfterClass
  public void afterClass() {
  }


  @Test
  public void CarmaLinkAPI() {
	  	try {
	  		CarmaLinkAPI api = new CarmaLinkAPI("My_KEY","My_SECRET","api.carmalink.com",8080, false, true);
		} catch (Exception e) {
			AssertJUnit.fail(e.getMessage());
		}
  }

  @Test
  public void api() {
    throw new RuntimeException("Test not implemented");
  }

  @Test
  public void delete() {
    throw new RuntimeException("Test not implemented");
  }

  @Test
  public void generateEndpoint() {
	
    throw new RuntimeException("Test not implemented");
  }

  @Test
  public void get() {
    throw new RuntimeException("Test not implemented");
  }


  @Test
  public void getEndpointRelativeRoot() {
    throw new RuntimeException("Test not implemented");
  }

  @Test
  public void getEndpointURIRoot() {
    throw new RuntimeException("Test not implemented");
  }

  @Test
  public void getReportData() {
    throw new RuntimeException("Test not implemented");
  }

  @Test
  public void getService() {
    throw new RuntimeException("Test not implemented");
  }

  @Test
  public void put() {
    throw new RuntimeException("Test not implemented");
  }

  @Test
  public void putConfig() {
    throw new RuntimeException("Test not implemented");
  }
}
