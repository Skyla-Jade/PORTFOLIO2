<?php

if ( ! function_exists( 'gracey_core_add_numbered_text_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param $shortcodes array
	 *
	 * @return array
	 */
	function gracey_core_add_numbered_text_shortcode( $shortcodes ) {
		$shortcodes[] = 'GraceyCore_Numbered_Text_Shortcode';
		
		return $shortcodes;
	}
	
	add_filter( 'gracey_core_filter_register_shortcodes', 'gracey_core_add_numbered_text_shortcode' );
}

if ( class_exists( 'GraceyCore_Shortcode' ) ) {
	class GraceyCore_Numbered_Text_Shortcode extends GraceyCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( GRACEY_CORE_SHORTCODES_URL_PATH . '/numbered-text' );
			$this->set_base( 'gracey_core_numbered_text' );
			$this->set_name( esc_html__( 'Numbered Text', 'gracey-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds numbered text element', 'gracey-core' ) );
			$this->set_category( esc_html__( 'Gracey Core', 'gracey-core' ) );
			$this->set_option( array(
				'field_type' => 'text',
				'name'       => 'custom_class',
				'title'      => esc_html__( 'Custom Class', 'gracey-core' ),
			) );
            $this->set_option( array(
                'field_type' => 'text',
                'name'       => 'number',
                'title'      => esc_html__( 'Number', 'gracey-core' )
            ) );
			$this->set_option( array(
				'field_type' => 'text',
				'name'       => 'title',
				'title'      => esc_html__( 'Title', 'gracey-core' ),
                'default_value' => '',
			) );
			$this->set_option( array(
				'field_type'    => 'select',
				'name'          => 'title_tag',
				'title'         => esc_html__( 'Title Tag', 'gracey-core' ),
				'options'       => gracey_core_get_select_type_options_pool( 'title_tag' ),
				'default_value' => 'h5',
                'dependency' => array(
                    'hide' => array(
                        'title' => array(
                            'values' => ''
                        )
                    )
                ),
			) );
			$this->set_option( array(
				'field_type' => 'color',
				'name'       => 'title_color',
				'title'      => esc_html__( 'Title Color', 'gracey-core' ),
                'dependency' => array(
                    'hide' => array(
                        'title' => array(
                            'values' => ''
                        )
                    )
                ),
			) );
			$this->set_option( array(
				'field_type' => 'textarea',
				'name'       => 'text',
				'title'      => esc_html__( 'Text', 'gracey-core' )
			) );
			$this->set_option( array(
				'field_type' => 'color',
				'name'       => 'text_color',
				'title'      => esc_html__( 'Text Color', 'gracey-core' ),
                'dependency' => array(
                    'hide' => array(
                        'text' => array(
                            'values' => ''
                        )
                    )
                ),
			) );
			$this->set_option( array(
				'field_type' => 'text',
				'name'       => 'text_margin_top',
				'title'      => esc_html__( 'Text Margin Top', 'gracey-core' ),
                'dependency' => array(
                    'hide' => array(
                        'text' => array(
                            'values' => ''
                        )
                    )
                ),
			) );
			$this->set_option( array(
				'field_type' => 'select',
				'name'       => 'style',
				'title'      => esc_html__( 'Style', 'gracey-core' ),
				'options'    => array(
					'center' => esc_html__( 'Centered', 'gracey-core' ),
					'left'   => esc_html__( 'Aligned Left', 'gracey-core' )
				),
			) );
		}
		
		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();
			
			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['title_styles']   = $this->get_title_styles( $atts );
			$atts['text_styles']    = $this->get_text_styles( $atts );
			
			return gracey_core_get_template_part( 'shortcodes/numbered-text', 'templates/numbered-text', '', $atts );
		}
		
		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();
			
			$holder_classes[] = 'qodef-numbered-text';
			$holder_classes[] = ! empty( $atts['style'] ) ?  'qodef-alignment--' . $atts['style'] : 'qodef-alignment--center';
			
			return implode( ' ', $holder_classes );
		}
		
		private function get_title_styles( $atts ) {
			$styles = array();
			
			if ( ! empty( $atts['title_color'] ) ) {
				$styles[] = 'color: ' . $atts['title_color'];
			}
			
			return $styles;
		}
		
		private function get_text_styles( $atts ) {
			$styles = array();
			
			if ( $atts['text_margin_top'] !== '' ) {
				if ( qode_framework_string_ends_with_space_units( $atts['text_margin_top'] ) ) {
					$styles[] = 'margin-top: ' . $atts['text_margin_top'];
				} else {
					$styles[] = 'margin-top: ' . intval( $atts['text_margin_top'] ) . 'px';
				}
			}
			
			if ( ! empty( $atts['text_color'] ) ) {
				$styles[] = 'color: ' . $atts['text_color'];
			}
			
			return $styles;
		}
	}
}