<?php

include_once GRACEY_CORE_CPT_PATH . '/clients/shortcodes/clients-list/class-graceycore-clients-list-shortcode.php';

foreach ( glob( GRACEY_CORE_CPT_PATH . '/clients/shortcodes/clients-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
