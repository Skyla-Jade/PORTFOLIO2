<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/icon-with-text/class-graceycore-icon-with-text-shortcode.php';

foreach ( glob( GRACEY_CORE_SHORTCODES_PATH . '/icon-with-text/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
