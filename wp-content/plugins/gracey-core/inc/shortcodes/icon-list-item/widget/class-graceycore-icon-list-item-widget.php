<?php

if ( ! function_exists( 'gracey_core_add_icon_list_item_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function gracey_core_add_icon_list_item_widget( $widgets ) {
		$widgets[] = 'GraceyCore_Icon_List_Item_Widget';

		return $widgets;
	}

	add_filter( 'gracey_core_filter_register_widgets', 'gracey_core_add_icon_list_item_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class GraceyCore_Icon_List_Item_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$widget_mapped = $this->import_shortcode_options(
				array(
					'shortcode_base' => 'gracey_core_icon_list_item',
					'exclude'        => array(
						'icon_type',
						'custom_icon',
					),
				)
			);
			if ( $widget_mapped ) {
				$this->set_base( 'gracey_core_icon_list_item' );
				$this->set_name( esc_html__( 'Gracey Icon List Item', 'gracey-core' ) );
				$this->set_description( esc_html__( 'Add a icon list item element into widget areas', 'gracey-core' ) );
			}
		}

		public function render( $atts ) {
			$params = $this->generate_string_params( $atts );

			echo do_shortcode( "[gracey_core_icon_list_item $params]" ); // XSS OK
		}
	}
}
