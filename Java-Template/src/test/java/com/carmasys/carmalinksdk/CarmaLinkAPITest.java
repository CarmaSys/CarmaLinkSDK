package com.carmasys.carmalinksdk;

import org.testng.annotations.*;
import org.testng.AssertJUnit;
import org.testng.Assert;


import static org.powermock.api.easymock.PowerMock.createMock;

public class CarmaLinkAPITest {

	private CarmaLinkAPI carmaLinkAPI;
	
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
	  carmaLinkAPI = createMock(CarmaLinkAPI.class);
  }

  @AfterClass
  public void afterClass() {
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
