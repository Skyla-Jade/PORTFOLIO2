<?php

if ( ! function_exists( 'gracey_core_add_side_area_opener_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function gracey_core_add_side_area_opener_widget( $widgets ) {
		$widgets[] = 'GraceyCore_Side_Area_Opener_Widget';

		return $widgets;
	}

	add_filter( 'gracey_core_filter_register_widgets', 'gracey_core_add_side_area_opener_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class GraceyCore_Side_Area_Opener_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_base( 'gracey_core_side_area_opener' );
			$this->set_name( esc_html__( 'Gracey Side Area Opener', 'gracey-core' ) );
			$this->set_description( esc_html__( 'Display a "hamburger" icon that opens the side area', 'gracey-core' ) );
			$this->set_widget_option(
				array(
					'field_type'  => 'text',
					'name'        => 'sidea_area_opener_margin',
					'title'       => esc_html__( 'Opener Margin', 'gracey-core' ),
					'description' => esc_html__( 'Insert margin in format: top right bottom left', 'gracey-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'color',
					'name'       => 'side_area_opener_color',
					'title'      => esc_html__( 'Opener Color', 'gracey-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'color',
					'name'       => 'side_area_opener_hover_color',
					'title'      => esc_html__( 'Opener Hover Color', 'gracey-core' ),
				)
			);
		}

		public function render( $atts ) {
			$styles = array();

			if ( ! empty( $atts['side_area_opener_color'] ) ) {
				$styles[] = 'color: ' . $atts['side_area_opener_color'] . ';';
			}

			if ( ! empty( $atts['sidea_area_opener_margin'] ) ) {
				$styles[] = 'margin: ' . $atts['sidea_area_opener_margin'];
			}

			gracey_core_get_opener_icon_html(
				array(
					'option_name'  => 'side_area',
					'custom_class' => 'qodef-side-area-opener',
					'inline_style' => $styles,
					'inline_attr'  => qode_framework_get_inline_attr( $atts['side_area_opener_hover_color'], 'data-hover-color' ),
				)
			);
		}
	}
}
