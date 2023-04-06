<?php

if ( ! function_exists( 'gracey_core_add_instagram_list_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function gracey_core_add_instagram_list_widget( $widgets ) {
		if ( qode_framework_is_installed( 'instagram' ) ) {
			$widgets[] = 'GraceyCore_Instagram_List_Widget';
		}

		return $widgets;
	}

	add_filter( 'gracey_core_filter_register_widgets', 'gracey_core_add_instagram_list_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class GraceyCore_Instagram_List_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'widget_title',
					'title'      => esc_html__( 'Title', 'gracey-core' ),
				)
			);
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'gracey_core_instagram_list',
				)
			);

			if ( $widget_mapped ) {
				$this->set_base( 'gracey_core_instagram_list' );
				$this->set_name( esc_html__( 'Gracey Instagram List', 'gracey-core' ) );
				$this->set_description( esc_html__( 'Add a instagram list element into widget areas', 'gracey-core' ) );
			}
		}

		public function render( $atts ) {
			$params = $this->generate_string_params( $atts );

			echo do_shortcode( "[gracey_core_instagram_list $params]" ); // XSS OK
		}
	}
}
