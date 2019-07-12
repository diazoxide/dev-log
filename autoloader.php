<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
use DevLog\DevLog;

if ( ! defined( "DEV_LOG" ) ) {
	define( "DEV_LOG", true );
}

if ( ! defined( "DEV_LOG_PATH" ) ) {
	define( "DEV_LOG_PATH", 'dlog' );
}

if ( ! defined( "DEV_LOG_IP_ADDRESSES" ) ) {
	define( "DEV_LOG_IP_ADDRESSES", [ '*' ] );
}

if ( ! defined( "DEV_LOG_DEBUGGER" ) ) {
	define( "DEV_LOG_DEBUGGER", true );
}

if ( ! defined( "DEV_LOG_INLINE_DEBUGGER" ) ) {
	define( "DEV_LOG_INLINE_DEBUGGER", true );
}

if ( ! defined( "DEV_LOG_SERVE_METHOD" ) ) {
	define( "DEV_LOG_SERVE_METHOD", 'file' );
}

if ( DEV_LOG != false ) {
//	include_once "vendor/autoload.php";
//	$db = adoNewConnection($driver); # eg. 'mysqli' or 'oci8'
//	$db->debug = true;
//	$db->connect('localhost', 'swanson', 'Novem9bit', 'swanson');
//	$rs = $db->execute('select * from xIQYyVTl_users');
//	print "<pre>";
//	print_r($rs->getRows());
//	print "</pre>";
//
//	die();
	include_once "DevLogBase.php";
	include_once "DevLog.php";
	DevLog::register();
}
//die();