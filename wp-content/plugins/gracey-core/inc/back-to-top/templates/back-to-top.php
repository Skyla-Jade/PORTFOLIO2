<?php
$custom_icon    = gracey_core_get_custom_svg_opener_icon_html( 'back_to_top' );
$qodef_back_to_top_stamp = gracey_core_get_option_value( 'admin', 'qodef_back_to_top_stamp' );
$holder_classes = array();
if ( empty( $custom_icon ) && ( $qodef_back_to_top_stamp  != 'yes') ) {
	$holder_classes[] = 'qodef--predefined';
} else if ( $qodef_back_to_top_stamp== 'yes' ) {
	$holder_classes[] = 'qodef--stamp-btt';
}
?>
<a id="qodef-back-to-top" href="#" <?php qode_framework_class_attribute( $holder_classes ); ?>>
	<span class="qodef-back-to-top-icon">
		<?php
		if ( ! empty( $custom_icon ) ) {
			echo gracey_core_get_custom_svg_opener_icon_html( 'back_to_top' );
		} else {
			if ( $qodef_back_to_top_stamp== 'yes' ){
				$stamp_params = array(
					'text'          => esc_html__( 'Back To Top Back To Top ', 'gracey-core' ),
					'centered_icon' => 'arrow-up'
				);
				echo GraceyCore_Stamp_Shortcode::call_shortcode( $stamp_params );
			} else {
				echo qode_framework_icons()->get_specific_icon_from_pack( 'back-to-top', 'elegant-icons' );
			}
		}
		?>
	</span>
</a>
