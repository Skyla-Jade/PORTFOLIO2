<?php

include_once GRACEY_CORE_CPT_PATH . '/clients/helper.php';

foreach ( glob( GRACEY_CORE_CPT_PATH . '/clients/dashboard/meta-box/*.php' ) as $module ) {
	include_once $module;
}
