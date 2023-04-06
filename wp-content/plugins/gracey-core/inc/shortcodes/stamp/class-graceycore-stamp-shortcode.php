<?php

if ( ! function_exists( 'gracey_core_add_stamp_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function gracey_core_add_stamp_shortcode( $shortcodes ) {
		$shortcodes[] = 'GraceyCore_Stamp_Shortcode';

		return $shortcodes;
	}

	add_filter( 'gracey_core_filter_register_shortcodes', 'gracey_core_add_stamp_shortcode', 9);
}

if ( class_exists( 'GraceyCore_Shortcode' ) ) {
	class GraceyCore_Stamp_Shortcode extends GraceyCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( GRACEY_CORE_SHORTCODES_URL_PATH . '/stamp' );
			$this->set_base( 'gracey_core_stamp' );
			$this->set_name( esc_html__( 'Stamp', 'gracey-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds stamp element', 'gracey-core' ) );
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
					'name'          => 'stamp_layout',
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
					'field_type' => 'textfield',
					'name'       => 'text',
					'title'      => esc_html__( 'Stamp Text', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'text_color',
					'title'      => esc_html__( 'Text Color', 'gracey-core' ),
					'dependency' => array(
						'hide' => array(
							'text' => array(
								'values' => '',
							),
						),
					),
					'group'      => esc_html__( 'Text Settings', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textfield',
					'name'       => 'text_font_size',
					'title'      => esc_html__( 'Text Font Size (px)', 'gracey-core' ),
					'dependency' => array(
						'hide' => array(
							'text' => array(
								'values' => '',
							),
						),
					),
					'group'      => esc_html__( 'Text Settings', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'centered_icon',
					'title'      => esc_html__( 'Centered Icon', 'gracey-core' ),
					'options'    => array(
						''           => esc_html__( 'None', 'gracey-core' ),
						'arrow-up'   => esc_html__( 'Arrow Up', 'gracey-core' ),
						'arrow-down' => esc_html__( 'Arrow Down', 'gracey-core' ),
						'predefined' => esc_html__( 'Predefined', 'gracey-core' ),
					),
					'default' => ''
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'link',
					'title'      => esc_html__( 'Link', 'gracey-core' ),
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
					'field_type'  => 'textfield',
					'name'        => 'stamp_size',
					'title'       => esc_html__( 'Stamp Size (px)', 'gracey-core' ),
					'description' => esc_html__( 'Default value is 120', 'gracey-core' ),
					'dependency'  => array(
						'hide' => array(
							'text' => array(
								'values' => '',
							),
						),
					),
					'group'       => esc_html__( 'Text Settings', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'disable_stamp',
					'title'      => esc_html__( 'Disable Stamp', 'gracey-core' ),
					'group'      => esc_html__( 'Visibility', 'gracey-core' ),
					'options'    => array(
						''     => esc_html__( 'Never', 'gracey-core' ),
						'1440' => esc_html__( 'Below 1440px', 'gracey-core' ),
						'1280' => esc_html__( 'Below 1280px', 'gracey-core' ),
						'1024' => esc_html__( 'Below 1024px', 'gracey-core' ),
						'768'  => esc_html__( 'Below 768px', 'gracey-core' ),
						'680'  => esc_html__( 'Below 680px', 'gracey-core' ),
						'480'  => esc_html__( 'Below 480px', 'gracey-core' ),
					),
					'dependency' => array(
						'hide' => array(
							'text' => array(
								'values' => '',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'absolute_position',
					'title'      => esc_html__( 'Enable Absolute Position', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'no_yes', false ),
					'dependency' => array(
						'hide' => array(
							'text' => array(
								'values' => '',
							),
						),
					),
					'group'      => esc_html__( 'Visibility', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textfield',
					'name'       => 'top_position',
					'title'      => esc_html__( 'Top Position (px or %)', 'gracey-core' ),
					'dependency' => array(
						'show' => array(
							'absolute_position' => array(
								'values'        => 'yes',
								'default_value' => 'no',
							),
						),
					),
					'group'      => esc_html__( 'Visibility', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textfield',
					'name'       => 'bottom_position',
					'title'      => esc_html__( 'Bottom Position (px or %)', 'gracey-core' ),
					'dependency' => array(
						'show' => array(
							'absolute_position' => array(
								'values'        => 'yes',
								'default_value' => 'no',
							),
						),
					),
					'group'      => esc_html__( 'Visibility', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textfield',
					'name'       => 'left_position',
					'title'      => esc_html__( 'Left Position (px or %)', 'gracey-core' ),
					'dependency' => array(
						'show' => array(
							'absolute_position' => array(
								'values'        => 'yes',
								'default_value' => 'no',
							),
						),
					),
					'group'      => esc_html__( 'Visibility', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'textfield',
					'name'       => 'right_position',
					'title'      => esc_html__( 'Right Position (px or %)', 'gracey-core' ),
					'dependency' => array(
						'show' => array(
							'absolute_position' => array(
								'values'        => 'yes',
								'default_value' => 'no',
							),
						),
					),
					'group'      => esc_html__( 'Visibility', 'gracey-core' ),
				)
			);
		}
		
		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'gracey_core_stamp', $params );
			$html = str_replace( "\n", '', $html );
			
			return $html;
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes']       = $this->getHolderClasses( $atts );
			$atts['holder_styles']        = $this->getHolderStyles( $atts );
			$atts['centered_text_styles'] = $this->getCenteredTextStyles( $atts );
			$atts['holder_data']          = $this->getHolderData( $atts );
			$atts['text_data']            = $this->getModifiedText( $atts );

			return gracey_core_get_template_part( 'shortcodes/stamp', 'templates/stamp', '', $atts );
		}

		private function getHolderClasses( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-stamp';
			$holder_classes[] = ! empty( $atts['disable_stamp'] ) ? 'qodef-hide-on--' . $atts['disable_stamp'] : '';
			$holder_classes[] = 'yes' === $atts['absolute_position'] ? 'qodef--abs' : '';

			return implode( ' ', $holder_classes );
		}

		private function getHolderStyles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['text_color'] ) ) {
				$styles[] = 'color: ' . $atts['text_color'];
			}

			if ( ! empty( $atts['text_font_size'] ) ) {
				$styles[] = 'font-size: ' . intval( $atts['text_font_size'] ) . 'px';
			}
			if ( ! empty( $atts['text_color'] ) ) {
				$styles[] = 'color: ' . $atts['text_color'];
			}

			if ( ! empty( $atts['stamp_size'] ) ) {
				$styles[] = 'width: ' . intval( $atts['stamp_size'] ) . 'px';
				$styles[] = 'height: ' . intval( $atts['stamp_size'] ) . 'px';
			}

			if ( '' !== $atts['top_position'] ) {
				$styles[] = 'top: ' . $atts['top_position'];
			}
			if ( '' !== $atts['bottom_position'] ) {
				$styles[] = 'bottom: ' . $atts['bottom_position'];
			}

			if ( '' !== $atts['left_position'] ) {
				$styles[] = 'left: ' . $atts['left_position'];
			}

			if ( '' !== $atts['right_position'] ) {
				$styles[] = 'right: ' . $atts['right_position'];
			}

			return implode( ';', $styles );
		}

		private function getCenteredtextStyles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['centered_text_font_size'] ) ) {
				$styles[] = 'font-size: ' . intval( $atts['centered_text_font_size'] ) . 'px';
			}
			if ( ! empty( $atts['centered_text_color'] ) ) {
				$styles[] = 'color: ' . $atts['centered_text_color'];
			}

			return implode( ';', $styles );
		}

		private function getHolderData( $atts ) {
			$slider_data = array();

			$slider_data['data-appearing-delay'] = ! empty( $atts['appearing_delay'] ) ? intval( $atts['appearing_delay'] ) : 0;

			return $slider_data;
		}

		private function getModifiedText( $atts ) {
			$text = $atts['text'];
			$data = array(
				'text'  => $this->get_split_text( $text ),
				'count' => count( $this->str_split_unicode( $text ) )
			);

			return $data;
		}

		private function str_split_unicode( $str ) {
			return preg_split( '~~u', $str, - 1, PREG_SPLIT_NO_EMPTY );
		}

		private function get_split_text( $text ) {
			if ( ! empty( $text ) ) {
				$split_text = $this->str_split_unicode( $text );

				foreach ( $split_text as $key => $value ) {
					$split_text[ $key ] = '<span class="qodef-m-character">' . $value . '</span>';
				}

				return implode( ' ', $split_text );
			}

			return $text;
		}
	}
}
