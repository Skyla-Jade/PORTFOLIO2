<?php

include_once GRACEY_CORE_INC_PATH . '/social-share/shortcodes/social-share/class-graceycore-social-share-shortcode.php';

foreach ( glob( GRACEY_CORE_INC_PATH . '/social-share/shortcodes/social-share/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
