<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/info-section/class-graceycore-info-section-shortcode.php';

foreach ( glob( GRACEY_CORE_SHORTCODES_PATH . '/info-section/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
