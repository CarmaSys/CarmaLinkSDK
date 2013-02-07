Carma Systems Inc. CarmaLinkSDK 1.3.0
===============================

The CarmaLinkSDK represents a layer of abstraction for interfacing the CarmaLinkAPI which utilizes
a RESTful style interface over HTTPS. Authentication is handled by a two-legged OAuth 1.0a implementation.

The SDK currently supports the following languages: 

* PHP >= 5.3 ([docs](http://carmasys.github.com/CarmaLinkSDK/))
* Ruby >= 1.9

Future releases aim to support: 

* C#/.NET
* Node.js
* Python
* Java

Getting Started
---------------

* Download the SDK as a zip or clone it locally using the public GitHub URL.
* Obtain your CarmaLinkAPI Key and Secret by opening a ticket @ https://support.carmasys.com
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
If you need help using the SDK or have an issue, please [submit a support ticket](https://support.carmasys.com/anonymous_requests/new).
