<?php

if ( ! function_exists( 'gracey_core_add_text_marquee_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function gracey_core_add_text_marquee_shortcode( $shortcodes ) {
		$shortcodes[] = 'GraceyCore_Text_Marquee_Shortcode';

		return $shortcodes;
	}

	add_filter( 'gracey_core_filter_register_shortcodes', 'gracey_core_add_text_marquee_shortcode', 9 );
}

if ( class_exists( 'GraceyCore_Shortcode' ) ) {
	class GraceyCore_Text_Marquee_Shortcode extends GraceyCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'gracey_core_filter_text_marquee_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'gracey_core_filter_text_marquee_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( GRACEY_CORE_SHORTCODES_URL_PATH . '/text-marquee' );
			$this->set_base( 'gracey_core_text_marquee' );
			$this->set_name( esc_html__( 'Text Marquee', 'gracey-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds Text Marquee element', 'gracey-core' ) );
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
					'name'          => 'layout',
					'title'         => esc_html__( 'Layout', 'gracey-core' ),
					'options'       => $this->get_layouts(),
					'default_value' => $options_map['default_value'],
					'visibility'    => array( 'map_for_page_builder' => $options_map['visibility'] ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'text_1',
					'title'      => esc_html__( 'Text 1', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'text_1_color',
					'title'      => esc_html__( 'Text 1 Color', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'text_2',
					'title'      => esc_html__( 'Text 2', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'text_2_color',
					'title'      => esc_html__( 'Text 2 Color', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'text_3',
					'title'      => esc_html__( 'Text 3', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'text_3_color',
					'title'      => esc_html__( 'Text 3 Color', 'gracey-core' ),
				)
			);
            $this->set_option( array(
                'field_type'    => 'select',
                'name'          => 'change_orientation',
                'title'         => esc_html__( 'Change Animation Orientation', 'gracey-core' ),
                'options'       => gracey_core_get_select_type_options_pool( 'yes_no', false ),
                'default_value' => 'no'
            ));
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'font_size',
					'title'      => esc_html__( 'Font Size (px or em)', 'gracey-core' ),
					'group'      => esc_html__( 'Typography', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'line_height',
					'title'      => esc_html__( 'Line Height (px or em)', 'gracey-core' ),
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
					'field_type' => 'text',
					'name'       => 'letter_spacing',
					'title'      => esc_html__( 'Letter Spacing (px or em)', 'gracey-core' ),
					'group'      => esc_html__( 'Typography', 'gracey-core' ),
				)
			);

			$this->map_extra_options();
		}

        public static function call_shortcode( $params ) {
            $html = qode_framework_call_shortcode( 'gracey_core_text_marquee', $params );
            $html = str_replace( "\n", '', $html );

            return $html;
        }

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes']        = $this->get_holder_classes( $atts );
			$atts['text_style']            = $this->get_text_global_style( $atts );
			$atts['text_individual_style'] = $this->get_text_individual_style( $atts );

			return gracey_core_get_template_part( 'shortcodes/text-marquee', 'variations/' . $atts['layout'] . '/templates/' . $atts['layout'], '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-text-marquee';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';
            $holder_classes[] = ! empty ( $atts['change_orientation'] ) && $atts['change_orientation'] == 'yes' ? 'qodef-animation--reverse' : '';

			return implode( ' ', $holder_classes );
		}

		private function get_text_global_style( $atts ) {
			$text_style = array();

			if ( ! empty( $atts['font_size'] ) ) {
				$text_style[] = 'font-size:' . $atts['font_size'];
			}
			if ( ! empty( $atts['line_height'] ) ) {
				$text_style[] = 'line-height:' . $atts['line_height'];
			}
			if ( ! empty( $atts['font_weight'] ) ) {
				$text_style[] = 'font-weight:' . $atts['font_weight'];
			}
			if ( ! empty( $atts['letter_spacing'] ) ) {
				$text_style[] = 'letter-spacing:' . $atts['letter_spacing'];
			}

			return $text_style;
		}

		private function get_text_individual_style( $atts ) {
			$text_style           = array();
			$text_style['first']  = array();
			$text_style['second'] = array();
			$text_style['third']  = array();

			if ( ! empty( $atts['text_1_color'] ) ) {
				$text_style['first'][] = 'color:' . $atts['text_1_color'];
			}

			if ( ! empty( $atts['text_2_color'] ) ) {
				$text_style['second'][] = 'color:' . $atts['text_2_color'];
			}

			if ( ! empty( $atts['text_3_color'] ) ) {
				$text_style['third'][] = 'color:' . $atts['text_3_color'];
			}

			return $text_style;
		}
	}
}
