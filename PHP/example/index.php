<?php
/**
 * This serves as a simple example of how you would utilize the PHP SDK for simple queries / configurations
 * You could run this in a browser or on the command line
 */
 require_once realpath(__DIR__."/../CarmaLinkAPI.php");

 // API key provided by CarmaSys
 define('CARMALINK_KEY','YOUR KEY HERE');
 // API secret provided by CarmaSys
 define('CARMALINK_SECRET','YOUR SUPER SECRET HERE');
 
 // General info about the API URI
 $apiInfo =  array(
 	'HOST'=>'api.somewhere.net',
 	'PORT'=>8282,
 	'HTTPS'=>true
 );

 $carmaLinkAPI = new CarmaLink\CarmaLinkAPI(CARMALINK_KEY, CARMALINK_SECRET, $apiInfo, TRUE);
 
 // Note: serials must be from CarmaLinks owned by the API key used above.
 $serials = array(
 	"single" => "517",
 	"multiple_range" => "10050-10100",
 	"multiple_ranges" => "2000-3000.5000-5500",
 	"nonconsecutive_single" => "10050.10055",
 	"mixed" => "100.104.110-115.200"
 );
 
 $res = $carmaLinkAPI->getReportData($serials["single"],'all_activity');
 print_r($res);
 
 $res = $carmaLinkAPI->getReportData($serials["multiple_range"],'hard_braking',array('limit'=>10));
 print_r($res);
 
 $res = $carmaLinkAPI->getReportData($serials["nonconsecutive_single"],'trip_report',array('limit'=>30,'since'=>1346780257804));
 print_r($res);
 
