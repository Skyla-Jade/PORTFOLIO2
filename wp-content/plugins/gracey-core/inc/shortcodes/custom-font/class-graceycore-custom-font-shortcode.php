<?php

if ( ! function_exists( 'gracey_core_add_custom_font_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function gracey_core_add_custom_font_shortcode( $shortcodes ) {
		$shortcodes[] = 'GraceyCore_Custom_Font_Shortcode';

		return $shortcodes;
	}

	add_filter( 'gracey_core_filter_register_shortcodes', 'gracey_core_add_custom_font_shortcode' );
}

if ( class_exists( 'GraceyCore_Shortcode' ) ) {
	class GraceyCore_Custom_Font_Shortcode extends GraceyCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'gracey_core_filter_custom_font_layouts', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( GRACEY_CORE_SHORTCODES_URL_PATH . '/custom-font' );
			$this->set_base( 'gracey_core_custom_font' );
			$this->set_name( esc_html__( 'Custom Font', 'gracey-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays custom font with provided parameters', 'gracey-core' ) );
			$this->set_category( esc_html__( 'Gracey Core', 'gracey-core' ) );

			$options_map = gracey_core_get_variations_options_map( $this->get_layouts() );

			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'layout',
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
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'title',
					'title'      => esc_html__( 'Title Text', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'distort_animation',
					'title'      => esc_html__( 'Enable Distort Animation', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'no_yes', 'false' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'distort_animation_speed',
					'title'      => esc_html__( 'Distort Animation Speed', 'gracey-core' ),
					'options'    => array(
						''     => esc_html__( 'Normal', 'gracey-core' ),
						'slow' => esc_html__( 'Slow', 'gracey-core' ),
					),
					'dependency'  => array(
						'show' => array(
							'distort_animation' => array(
								'values'        => 'yes',
								'default_value' => 'no'
							)
						)
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'custom_o_animation',
					'title'      => esc_html__( 'Enable Custom Animation For Letter "O', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'no_yes', false ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'title_tag',
					'title'         => esc_html__( 'Title Tag', 'gracey-core' ),
					'options'       => gracey_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => 'p',
					'group'         => esc_html__( 'Typography', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'color',
					'title'      => esc_html__( 'Color', 'gracey-core' ),
					'group'      => esc_html__( 'Typography', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'font_family',
					'title'      => esc_html__( 'Font Family', 'gracey-core' ),
					'group'      => esc_html__( 'Typography', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'font_size',
					'title'      => esc_html__( 'Font Size', 'gracey-core' ),
					'group'      => esc_html__( 'Typography', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'line_height',
					'title'      => esc_html__( 'Line Height', 'gracey-core' ),
					'group'      => esc_html__( 'Typography', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'letter_spacing',
					'title'      => esc_html__( 'Letter Spacing', 'gracey-core' ),
					'group'      => esc_html__( 'Typography', 'gracey-core' ),
				)
			);
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
					'name'       => 'font_style',
					'title'      => esc_html__( 'Font Style', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'font_style' ),
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
					'field_type' => 'text',
					'name'       => 'margin',
					'title'      => esc_html__( 'Margin', 'gracey-core' ),
					'group'      => esc_html__( 'Typography', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'font_size_1440',
					'title'       => esc_html__( 'Font Size', 'gracey-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 1440', 'gracey-core' ),
					'group'       => esc_html__( 'Screen Size 1440', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'line_height_1440',
					'title'       => esc_html__( 'Line Height', 'gracey-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 1440', 'gracey-core' ),
					'group'       => esc_html__( 'Screen Size 1440', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'letter_spacing_1440',
					'title'       => esc_html__( 'Letter Spacing', 'gracey-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 1440', 'gracey-core' ),
					'group'       => esc_html__( 'Screen Size 1440', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'font_size_1024',
					'title'       => esc_html__( 'Font Size', 'gracey-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 1024', 'gracey-core' ),
					'group'       => esc_html__( 'Screen Size 1024', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'line_height_1024',
					'title'       => esc_html__( 'Line Height', 'gracey-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 1024', 'gracey-core' ),
					'group'       => esc_html__( 'Screen Size 1024', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'letter_spacing_1024',
					'title'       => esc_html__( 'Letter Spacing', 'gracey-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 1024', 'gracey-core' ),
					'group'       => esc_html__( 'Screen Size 1024', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'font_size_768',
					'title'       => esc_html__( 'Font Size', 'gracey-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 768', 'gracey-core' ),
					'group'       => esc_html__( 'Screen Size 768', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'line_height_768',
					'title'       => esc_html__( 'Line Height', 'gracey-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 768', 'gracey-core' ),
					'group'       => esc_html__( 'Screen Size 768', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'letter_spacing_768',
					'title'       => esc_html__( 'Letter Spacing', 'gracey-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 768', 'gracey-core' ),
					'group'       => esc_html__( 'Screen Size 768', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'font_size_680',
					'title'       => esc_html__( 'Font Size', 'gracey-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 680', 'gracey-core' ),
					'group'       => esc_html__( 'Screen Size 680', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'line_height_680',
					'title'       => esc_html__( 'Line Height', 'gracey-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 680', 'gracey-core' ),
					'group'       => esc_html__( 'Screen Size 680', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'letter_spacing_680',
					'title'       => esc_html__( 'Letter Spacing', 'gracey-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 680', 'gracey-core' ),
					'group'       => esc_html__( 'Screen Size 680', 'gracey-core' ),
				)
			);
		}
		
		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'gracey_core_custom_font', $params );
			$html = str_replace( "\n", '', $html );
			
			return $html;
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['unique_class']   = 'qodef-custom-font-' . rand( 0, 1000 );
			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['holder_styles']  = $this->get_holder_styles( $atts );
			$this->set_responsive_styles( $atts );

			return gracey_core_get_template_part( 'shortcodes/custom-font', 'variations/' . $atts['layout'] . '/templates/custom-font', '', $atts );
		}
		
		public function load_assets() {
			$atts = $this->get_atts();
			
			if ($atts['distort_animation'] == 'yes') {
				wp_register_script( 'blotter', GRACEY_CORE_INC_URL_PATH . '/shortcodes/custom-font/assets/js/plugins/blotter.min.js', array ( 'jquery' ), false, true );
				wp_register_script( 'blotter-material', GRACEY_CORE_INC_URL_PATH . '/shortcodes/custom-font/assets/js/plugins/materials/liquidDistortMaterial.js', array ( 'jquery' ), false, true );
				wp_enqueue_script( 'blotter' );
				wp_enqueue_script( 'blotter-material' );
			}
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-custom-font-holder';
			$holder_classes[] = $atts['unique_class'];
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';
			$holder_classes[] = ! empty( $atts['distort_animation'] ) && 'yes' === $atts['distort_animation'] ? 'qodef--distort-text-animation' : '';
			$holder_classes[] = ! empty( $atts['distort_animation_speed'] ) ? 'qodef--distort-text-animation--'. $atts['distort_animation_speed'] : '';
			$holder_classes[] = ! empty( $atts['custom_o_animation'] ) &&  'yes' === $atts['custom_o_animation'] ? 'qodef--custom-o-animation' : '';

			return implode( ' ', $holder_classes );
		}

		private function get_holder_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['color'] ) ) {
				$styles[] = 'color: ' . $atts['color'];
			}

			if ( ! empty( $atts['font_family'] ) ) {
				$styles[] = 'font-family: ' . $atts['font_family'];
			}

			$font_size = $atts['font_size'];
			if ( ! empty( $font_size ) ) {
				if ( $this->string_ends_with_typography_units( $font_size ) ) {
					$styles[] = 'font-size: ' . $font_size;
				} else {
					$styles[] = 'font-size: ' . intval( $font_size ) . 'px';
				}
			}

			$line_height = $atts['line_height'];
			if ( ! empty( $line_height ) ) {
				if ( qode_framework_string_ends_with_typography_units( $line_height ) ) {
					$styles[] = 'line-height: ' . $line_height;
				} else {
					$styles[] = 'line-height: ' . intval( $line_height ) . 'px';
				}
			}

			$letter_spacing = $atts['letter_spacing'];
			if ( '' !== $letter_spacing ) {
				if ( qode_framework_string_ends_with_typography_units( $letter_spacing ) ) {
					$styles[] = 'letter-spacing: ' . $letter_spacing;
				} else {
					$styles[] = 'letter-spacing: ' . intval( $letter_spacing ) . 'px';
				}
			}

			if ( ! empty( $atts['font_weight'] ) ) {
				$styles[] = 'font-weight: ' . $atts['font_weight'];
			}

			if ( ! empty( $atts['font_style'] ) ) {
				$styles[] = 'font-style: ' . $atts['font_style'];
			}

			if ( ! empty( $atts['text_transform'] ) ) {
				$styles[] = 'text-transform: ' . $atts['text_transform'];
			}

			if ( '' !== $atts['margin'] ) {
				$styles[] = 'margin: ' . $atts['margin'];
			}

			return $styles;
		}

		private function set_responsive_styles( $atts ) {
			$unique_class = '.' . $atts['unique_class'];
			$screen_sizes = array( '1440', '1024', '768', '680' );
			$option_keys  = array( 'font_size', 'line_height', 'letter_spacing' );

			foreach ( $screen_sizes as $screen_size ) {
				$styles = array();

				foreach ( $option_keys as $option_key ) {
					$option_value = $atts[ $option_key . '_' . $screen_size ];
					$style_key    = str_replace( '_', '-', $option_key );

					if ( '' !== $option_value ) {
						if ( $this->string_ends_with_typography_units( $option_value ) ) {
							$styles[ $style_key ] = $option_value . '!important';
						} else {
							$styles[ $style_key ] = intval( $option_value ) . 'px !important';
						}
					}
				}

				if ( ! empty( $styles ) ) {
					add_filter( 'gracey_core_filter_add_responsive_' . $screen_size . '_inline_style_in_footer', function ( $style ) use ( $unique_class, $styles ) {
						$style .= qode_framework_dynamic_style( $unique_class, $styles );

						return $style;
					} );
				}
			}
		}

		private function string_ends_with_typography_units( $haystack ) {
            $result  = false;
            $needles = array( 'px', 'em', 'rem', 'vh', 'vw' );

            if ( '' !== $haystack ) {
                foreach ( $needles as $needle ) {
                    if ( qode_framework_string_ends_with( $haystack, $needle ) ) {
                        $result = true;
                    }
                }
            }

            return $result;
        }
	}
}
