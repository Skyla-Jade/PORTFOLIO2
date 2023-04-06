<?php

if ( ! function_exists( 'gracey_core_add_icon_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function gracey_core_add_icon_widget( $widgets ) {
		$widgets[] = 'GraceyCore_Icon_Widget';

		return $widgets;
	}

	add_filter( 'gracey_core_filter_register_widgets', 'gracey_core_add_icon_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class GraceyCore_Icon_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'gracey_core_icon',
				)
			);

			if ( $widget_mapped ) {
				$this->set_base( 'gracey_core_icon' );
				$this->set_name( esc_html__( 'Gracey Icon', 'gracey-core' ) );
				$this->set_description( esc_html__( 'Add a icon element into widget areas', 'gracey-core' ) );
			}
		}

		public function render( $atts ) {

			$params = $this->generate_string_params( $atts );

			echo do_shortcode( "[gracey_core_icon $params]" ); // XSS OK
		}
	}
}
