<?php

include_once GRACEY_CORE_INC_PATH . '/header/top-area/class-graceycore-top-area.php';
include_once GRACEY_CORE_INC_PATH . '/header/top-area/helper.php';

foreach ( glob( GRACEY_CORE_INC_PATH . '/header/top-area/dashboard/*/*.php' ) as $dashboard ) {
	include_once $dashboard;
}
