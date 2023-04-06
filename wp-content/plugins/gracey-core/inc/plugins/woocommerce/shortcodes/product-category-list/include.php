<?php

include_once GRACEY_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/media-custom-fields.php';
include_once GRACEY_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/class-graceycore-product-category-list-shortcode.php';

foreach ( glob( GRACEY_CORE_PLUGINS_PATH . '/woocommerce/shortcodes/product-category-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
