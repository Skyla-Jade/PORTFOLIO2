<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/button/class-graceycore-button-shortcode.php';

foreach ( glob( GRACEY_CORE_SHORTCODES_PATH . '/button/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
