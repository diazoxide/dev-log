<?php

include "DevLog.php";
include "DevLogController.php";

if ( new DevLogController() ) {
	DevLog::register();
}