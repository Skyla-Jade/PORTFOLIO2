<?php

include_once GRACEY_CORE_INC_PATH . '/search/class-graceycore-search.php';
include_once GRACEY_CORE_INC_PATH . '/search/helper.php';
include_once GRACEY_CORE_INC_PATH . '/search/dashboard/admin/search-options.php';

foreach ( glob( GRACEY_CORE_INC_PATH . '/search/layouts/*/include.php' ) as $layout ) {
	include_once $layout;
}
