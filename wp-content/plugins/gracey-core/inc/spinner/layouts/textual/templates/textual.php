<?php
$spinner_text = gracey_core_get_post_value_through_levels( 'qodef_page_spinner_text' );
$stamp_params = array(
	'text'          => $spinner_text,
	'centered_icon' => 'predefined'
);
?>

<div class="qodef-m-textual">
	<?php echo GraceyCore_Stamp_Shortcode::call_shortcode( $stamp_params ); ?>
</div>