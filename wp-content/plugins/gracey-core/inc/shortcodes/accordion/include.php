<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/accordion/class-graceycore-accordion-shortcode.php';
include_once GRACEY_CORE_SHORTCODES_PATH . '/accordion/class-graceycore-accordion-child-shortcode.php';

foreach ( glob( GRACEY_CORE_SHORTCODES_PATH . '/accordion/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
