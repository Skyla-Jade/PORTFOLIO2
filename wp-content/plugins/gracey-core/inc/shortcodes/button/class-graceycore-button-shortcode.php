<?php

if ( ! function_exists( 'gracey_core_add_button_shortcode' ) ) {
	/**
	 * Function that isadding shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes - Array of registered shortcodes
	 *
	 * @return array
	 */
	function gracey_core_add_button_shortcode( $shortcodes ) {
		$shortcodes[] = 'GraceyCore_Button_Shortcode';

		return $shortcodes;
	}

	add_filter( 'gracey_core_filter_register_shortcodes', 'gracey_core_add_button_shortcode', 9 );
}

if ( class_exists( 'GraceyCore_Shortcode' ) ) {
	class GraceyCore_Button_Shortcode extends GraceyCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'gracey_core_filter_button_layouts', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( GRACEY_CORE_SHORTCODES_URL_PATH . '/button' );
			$this->set_base( 'gracey_core_button' );
			$this->set_name( esc_html__( 'Button', 'gracey-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays button with provided parameters', 'gracey-core' ) );
			$this->set_category( esc_html__( 'Gracey Core', 'gracey-core' ) );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'gracey-core' ),
				)
			);

			$options_map = gracey_core_get_variations_options_map( $this->get_layouts() );

			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'button_layout',
					'title'         => esc_html__( 'Layout', 'gracey-core' ),
					'options'       => $this->get_layouts(),
					'default_value' => $options_map['default_value'],
					'visibility'    => array(
						'map_for_page_builder' => $options_map['visibility'],
						'map_for_widget'       => $options_map['visibility'],
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'size',
					'title'      => esc_html__( 'Size', 'gracey-core' ),
					'options'    => array(
						''      => esc_html__( 'Normal', 'gracey-core' ),
						'small' => esc_html__( 'Small', 'gracey-core' ),
						'large' => esc_html__( 'Large', 'gracey-core' ),
						'full'  => esc_html__( 'Normal Full Width', 'gracey-core' ),
					),
					'dependency' => array(
						'hide' => array(
							'button_layout' => array(
								'values'        => 'textual',
								'default_value' => 'filled',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'text',
					'title'      => esc_html__( 'Button Text', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'link',
					'title'      => esc_html__( 'Button Link', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'target',
					'title'         => esc_html__( 'Target', 'gracey-core' ),
					'options'       => gracey_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'color',
					'title'      => esc_html__( 'Text Color', 'gracey-core' ),
					'group'      => esc_html__( 'Style', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'name'       => 'hover_color',
					'field_type' => 'color',
					'title'      => esc_html__( 'Text Hover Color', 'gracey-core' ),
					'group'      => esc_html__( 'Style', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'background_color',
					'title'      => esc_html__( 'Background Color', 'gracey-core' ),
					'group'      => esc_html__( 'Style', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'hover_background_color',
					'title'      => esc_html__( 'Background Hover Color', 'gracey-core' ),
					'group'      => esc_html__( 'Style', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'border_color',
					'title'      => esc_html__( 'Border Color', 'gracey-core' ),
					'group'      => esc_html__( 'Style', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'hover_border_color',
					'title'      => esc_html__( 'Border Hover Color', 'gracey-core' ),
					'group'      => esc_html__( 'Style', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'margin',
					'title'      => esc_html__( 'Margin', 'gracey-core' ),
					'group'      => esc_html__( 'Style', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'padding',
					'title'      => esc_html__( 'Padding', 'gracey-core' ),
					'group'      => esc_html__( 'Style', 'gracey-core' ),
				)
			);
			$this->set_option( array(
				'field_type' => 'text',
				'name'       => 'font_size',
				'title'      => esc_html__( 'Font Size', 'gracey-core' ),
				'group'      => esc_html__( 'Typography', 'gracey-core' ),
			) );
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'font_weight',
					'title'      => esc_html__( 'Font Weight', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'font_weight' ),
					'group'      => esc_html__( 'Typography', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'text_transform',
					'title'      => esc_html__( 'Text Transform', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'text_transform' ),
					'group'      => esc_html__( 'Typography', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'html_type',
					'title'         => esc_html__( 'HTML Type', 'gracey-core' ),
					'options'       => array(
						'default' => esc_html__( 'Default', 'gracey-core' ),
						'input'   => esc_html__( 'Input', 'gracey-core' ),
						'submit'  => esc_html__( 'Submit', 'gracey-core' ),
					),
					'default_value' => 'default',
					'visibility'    => array(
						'map_for_page_builder' => false,
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'input_name',
					'title'      => esc_html__( 'Input Name', 'gracey-core' ),
					'visibility' => array(
						'map_for_page_builder' => false,
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'array',
					'name'       => 'custom_attrs',
					'title'      => esc_html__( 'Custom Data Attributes', 'gracey-core' ),
					'visibility' => array(
						'map_for_page_builder' => false,
					),
				)
			);
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'gracey_core_button', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function render( $options, $content = null ) {

			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['data_attrs']     = $this->get_data_attrs( $atts );
			$atts['styles']         = $this->get_styles( $atts );

			return gracey_core_get_template_part( 'shortcodes/button', 'variations/' . $atts['button_layout'] . '/templates/' . $atts['html_type'], '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-button';
			$holder_classes[] = ! empty( $atts['button_layout'] ) ? 'qodef-layout--' . $atts['button_layout'] : '';
			$holder_classes[] = ! empty( $atts['size'] ) ? 'qodef-size--' . $atts['size'] : '';
			$holder_classes[] = 'default' === $atts['html_type'] ? 'qodef-html--link' : '';

			return implode( ' ', $holder_classes );
		}

		private function get_data_attrs( $atts ) {
			$data = array();

			if ( ! empty( $atts['hover_color'] ) ) {
				$data['data-hover-color'] = $atts['hover_color'];
			}

			if ( ! empty( $atts['hover_background_color'] ) ) {
				$data['data-hover-background-color'] = $atts['hover_background_color'];
			}

			if ( ! empty( $atts['hover_border_color'] ) ) {
				$data['data-hover-border-color'] = $atts['hover_border_color'];
			}

			if ( ! empty( $atts['custom_attrs'] ) && is_array( $atts['custom_attrs'] ) ) {
				$data = array_merge( $data, $atts['custom_attrs'] );
			}

			return $data;
		}

		private function get_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['color'] ) ) {
				$styles[] = 'color: ' . $atts['color'];
			}

			if ( ! empty( $atts['background_color'] ) && 'outlined' !== $atts['button_layout'] && 'textual' !== $atts['button_layout'] ) {
				$styles[] = 'background-color: ' . $atts['background_color'];
			}

			if ( ! empty( $atts['border_color'] ) && 'textual' !== $atts['button_layout'] ) {
				$styles[] = 'border-color: ' . $atts['border_color'];
			}

			if ( ! empty( $atts['font_size'] ) ) {
				if ( qode_framework_string_ends_with_typography_units( $atts['font_size'] ) ) {
					$styles[] = 'font-size: ' . $atts['font_size'];
				} else {
					$styles[] = 'font-size: ' . intval( $atts['font_size'] ) . 'px';
				}
			}

			if ( ! empty( $atts['font_weight'] ) ) {
				$styles[] = 'font-weight: ' . $atts['font_weight'];
			}

			if ( ! empty( $atts['text_transform'] ) ) {
				$styles[] = 'text-transform: ' . $atts['text_transform'];
			}

			if ( '' !== $atts['margin'] ) {
				$styles[] = 'margin: ' . $atts['margin'];
			}

			if ( '' !== $atts['padding'] ) {
				$styles[] = 'padding: ' . $atts['padding'];
			}

			return $styles;
		}
	}
}
