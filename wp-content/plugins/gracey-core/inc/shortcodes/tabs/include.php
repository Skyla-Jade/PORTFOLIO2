<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/tabs/class-graceycore-tab-shortcode.php';
include_once GRACEY_CORE_SHORTCODES_PATH . '/tabs/class-graceycore-tab-child-shortcode.php';

foreach ( glob( GRACEY_CORE_SHORTCODES_PATH . '/tabs/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
