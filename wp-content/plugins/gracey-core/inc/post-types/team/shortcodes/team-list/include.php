<?php

include_once GRACEY_CORE_CPT_PATH . '/team/shortcodes/team-list/class-graceycore-team-list-shortcode.php';

foreach ( glob( GRACEY_CORE_CPT_PATH . '/team/shortcodes/team-list/variations/*/include.php' ) as $variation ) {
	include_once $variation;
}
