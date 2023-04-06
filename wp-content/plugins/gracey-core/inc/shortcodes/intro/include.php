<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/intro/class-graceycore-intro-shortcode.php';

foreach ( glob( GRACEY_CORE_SHORTCODES_PATH . '/intro/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
