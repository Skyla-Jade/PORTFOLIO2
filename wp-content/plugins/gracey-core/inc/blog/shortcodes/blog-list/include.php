<?php

include_once GRACEY_CORE_INC_PATH . '/blog/shortcodes/blog-list/class-graceycore-blog-list-shortcode.php';

foreach ( glob( GRACEY_CORE_INC_PATH . '/blog/shortcodes/blog-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
