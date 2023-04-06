<?php
$params                      = array();
$params['layout']            = 'list';
$params['icon_font']         = 'kiko';

if ( is_singular( 'post' ) ) {
    $params['title'] = 'Share:';
} else {
    $params['title'] = ' ';
}

if( class_exists( 'GraceyCore_Social_Share_Shortcode' ) ) {
	echo GraceyCore_Social_Share_Shortcode::call_shortcode($params);
}