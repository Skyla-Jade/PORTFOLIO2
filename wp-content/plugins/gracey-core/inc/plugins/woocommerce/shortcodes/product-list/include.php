<?php

include_once GRACEY_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list/class-graceycore-product-list-shortcode.php';

foreach ( glob( GRACEY_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
