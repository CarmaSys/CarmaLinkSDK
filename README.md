Carma Systems Inc. CarmaLinkSDK
===============================

The CarmaLinkSDK represents a layer of abstraction for interfacing the CarmaLinkAPI which utilizes
a RESTful style interface over HTTPS. Authentication is handled by a two-legged OAuth 1.0a implementation.

The SDK currently supports the following languages: 

* PHP >= 5.3 ([docs](http://carmasys.github.com/CarmaLinkSDK/))

Future releases aim to support: 

* Java
* C#/.NET
* Node.js
* Python
* Ruby

Getting Started
---------------

* Download the SDK as a zip or clone it locally using the public URL.
* Obtain your CarmaLinkAPI Key and Secret by opening a ticket @ https://support.carmasys.com
* Create a new instance of the CarmaLinkAPI class sending in required arguments (see language-specific documentation)
 such as:
 * API Key
 * API Secret
 * API URI Host
 * API URI Port
 * API URI SSL support
 * Debugging support
 * Using a valid serial make a request using the getReportData method which should return a valid JSON encoded 
 string. 
