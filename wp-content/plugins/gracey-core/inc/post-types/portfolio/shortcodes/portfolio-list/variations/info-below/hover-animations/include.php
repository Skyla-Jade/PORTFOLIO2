<?php

include_once GRACEY_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-list/variations/info-below/hover-animations/hover-animations.php';

foreach ( glob( GRACEY_CORE_CPT_PATH . '/portfolio/shortcodes/portfolio-list/variations/info-below/hover-animations/*/include.php' ) as $animation ) {
	include_once $animation;
}
