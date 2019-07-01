<?php

use DevLog\DevLog;
use DevLog\DevLogController;

if ( ! defined( "DEV_LOG" ) ) {
	define( "DEV_LOG", true );
}

if ( ! defined( "DEV_LOG_IP_ADDRESSES" ) ) {
	define( "DEV_LOG_IP_ADDRESSES", [ '*' ] );
}

if ( ! defined( "DEV_LOG_DEBUGGER" ) ) {
	define( "DEV_LOG_DEBUGGER", true );
}

if ( DEV_LOG != false ) {
	include "DevLogHelper.php";
	include "DevLog.php";
}


if ( DEV_LOG_DEBUGGER != false ) {
	include "DevLogController.php";
	if ( new DevLogController( DEV_LOG_IP_ADDRESSES ) ) {
		DevLog::register();
	}
} else {
	DevLog::register();
}