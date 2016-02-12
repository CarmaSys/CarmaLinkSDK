Carma Systems Inc. CarmaLinkSDK 1.8.1
===============================

CarmaLink is a vehicle telematics device providing users with programmable access to their car's onboard data through OBD2, Unified Diagnostic Service (UDS) and other manufacturer specific protocols. CarmaLink also contains onboard GPS and accelerometer chipsets providing users with high quality up to the second data about vehicles and their driver's behavior. 

Also included is an audible live feedback mechanism to notify drivers of unwanted behavior. CarmaLink utilizes a wireless high-speed (currently 3G) cellular network connection to communicate with its backend data processing and warehousing systems known as CarmaLinkAPI. Users are given access to their CarmaLink(s) through the CarmaLinkAPI.

The CarmaLinkSDK represents a layer of abstraction for interfacing the CarmaLinkAPI which utilizes
a RESTful style interface over HTTPS. Authentication is handled by a two-legged OAuth 1.0a implementation.

The latest CarmaLinkAPI documentation can be found ([here](https://github.com/CarmaSys/CarmaLinkAPI/tree/master))

The SDK currently supports the following languages: 

* PHP >= 5.4 ([docs](http://carmasys.github.io/CarmaLinkSDK/))

Future releases aim to support: 

* Ruby
* C#/.NET
* Node.js
* Python
* Java

Getting Started
---------------

* Download the SDK as a zip or clone it locally using the public GitHub URL.
* Obtain your CarmaLinkAPI Key and Secret by emailing a request to support@carmasys.com
* Create a new instance of the CarmaLinkAPI class sending in required arguments (see language-specific documentation) 

```PHP
$carmaLinkAPI = new CarmaLink\CarmaLinkAPI(CARMALINK_KEY, CARMALINK_SECRET, HOST_INFO_ARRAY, DEBUG);
``` 

* Using a valid serial and the report 'all_activity' as arguments, make an API request using the getReportData method. 

```PHP
$result = $carmaLinkAPI->getReportData("517","all_activity");
```

* This will return a JSON encoded string representing the activity for the given CarmaLink serial. 

```javascript
{
  "statusReports": [
    {
      "configId": 491,
      "serial": 517,
      "eventStart": 1350512037502,
      "reportTimestamp": 1350513187373,
      "duration": 1149871,
      "location": {
        "longitude": -73.7788637,
        "latitude": 42.6692501,
        "accuracy": 1.9810001,
        "heading": 215.39035,
        "speed": 0
      },
      "vehicleVoltage": 13.594035,
      "gsmSignalStrength": -77,
    },
    {
      "configId": 491,
      "serial": 517,
      "eventStart": 1350512037502,
      "reportTimestamp": 1350513173783,
      "duration": 1136281,
      "location": {
        "longitude": -73.7787286,
        "latitude": 42.6691727,
        "accuracy": 1.9520001,
        "heading": 300.98834,
        "speed": 9
      },
      "vehicleVoltage": 14.085941,
      "gsmSignalStrength": -77,
    }
  ],
  "faultReports": [],
  "accelerationReports": [],
  "hardBrakingReports": [],
  "idlingReports": [
    {
      "configId": 493,
      "serial": 517,
      "eventStart": 1350512097220,
      "reportTimestamp": 1350512110210,
      "duration": 12990,
      "location": {
        "longitude": -73.8228948,
        "latitude": 42.6262894,
        "accuracy": 3.2250001,
        "heading": 67.06507,
        "speed": 5
      },
      "fuelConsumed": null
    }
  ],
  "overspeedingReports": [],
  "summaryReports": [
    {
      "configId": 489,
      "serial": 517,
      "eventStart": 1350512037160,
      "reportTimestamp": 1350513186969,
      "duration": 1149809,
      "location": {
        "longitude": -73.7788637,
        "latitude": 42.6692501,
        "accuracy": 1.9810001,
        "heading": 215.39035,
        "speed": 0
      },
      "fuelConsumed": null,
      "distance": 17.099472,
      "voltage": 14.284793,
      "inProgress": false
    }
  ]
}
```

Need help?
----------------------
If you need help using the SDK or have an issue, please email support@carmasys.com.
