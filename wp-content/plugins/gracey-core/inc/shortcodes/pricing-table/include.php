<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/pricing-table/class-graceycore-pricing-table-shortcode.php';

foreach ( glob( GRACEY_CORE_SHORTCODES_PATH . '/pricing-table/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
