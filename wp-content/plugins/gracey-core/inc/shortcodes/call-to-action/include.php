<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/call-to-action/class-graceycore-call-to-action-shortcode.php';

foreach ( glob( GRACEY_CORE_SHORTCODES_PATH . '/call-to-action/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
