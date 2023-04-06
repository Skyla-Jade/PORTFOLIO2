<?php

include_once GRACEY_CORE_SHORTCODES_PATH . '/interactive-link-showcase/class-graceycore-interactive-link-showcase-shortcode.php';

foreach ( glob( GRACEY_CORE_SHORTCODES_PATH . '/interactive-link-showcase/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
