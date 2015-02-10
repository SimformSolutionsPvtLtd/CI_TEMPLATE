<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| System Configurations
|--------------------------------------------------------------------------
|
*/
$config['system_default_timezone'] = 'UTC';

define("USER_LOCATION_CHECK", TRUE);
define("USER_STATUS_CHECK", TRUE);
define("USER_UNIQUE_DEVICE", TRUE);

//define("SYSTEM_PROXY_SERVER", "192.168.1.1:808");

define("GET_NEWS_DEFAULT_AROUND", 100000);
define("UNIT_MILE_METER", 1609.344);

define("PAYMENT_WAY_PAYPAL", "paypal");
define("PAYMENT_WAY_CASH", "cash");

define("WOOF_STATS_NEW", "New");
define("WOOF_STATS_PROGRESS", "In Progress");
define("WOOF_STATS_COMPLETED", "Completed");
define("WOOF_STATS_CANCELED", "Canceled");

define("FETCH_STATS_FETCHED", "Fetched");
define("FETCH_STATS_ACCEPTED", "Accepted");
define("FETCH_STATS_COMPLETED", "Completed");
define("FETCH_STATS_WIDDRAW", "Widdraw");
define("FETCH_STATS_REJECTED", "Rejected");
define("FETCH_STATS_CANCELED", "Canceled");
define("FETCH_STATS_INVITED", "Invited");

define("NOTIFICATION_TYPE_WOOF", "woof");
define("NOTIFICATION_TYPE_FETCH", "fetch");
define("NOTIFICATION_TYPE_ACCEPT", "accept");
define("NOTIFICATION_TYPE_CHAT", "chat");
define("NOTIFICATION_TYPE_MESSAGE", "message");
define("NOTIFICATION_TYPE_BUDDY", "buddy");
define("NOTIFICATION_TYPE_SNIFFER", "sniffer");




