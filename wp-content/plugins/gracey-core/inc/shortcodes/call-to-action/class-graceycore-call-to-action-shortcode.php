<?php

if ( ! function_exists( 'gracey_core_add_call_to_action_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function gracey_core_add_call_to_action_shortcode( $shortcodes ) {
		$shortcodes[] = 'GraceyCore_Call_To_Action_Shortcode';

		return $shortcodes;
	}

	add_filter( 'gracey_core_filter_register_shortcodes', 'gracey_core_add_call_to_action_shortcode' );
}

if ( class_exists( 'GraceyCore_Shortcode' ) ) {
	class GraceyCore_Call_To_Action_Shortcode extends GraceyCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'gracey_core_filter_call_to_action_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'gracey_core_filter_call_to_action_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( GRACEY_CORE_SHORTCODES_URL_PATH . '/call-to-action' );
			$this->set_base( 'gracey_core_call_to_action' );
			$this->set_name( esc_html__( 'Call to Action', 'gracey-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds call to action element', 'gracey-core' ) );
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
					'visibility'    => array(
						'map_for_page_builder' => $options_map['visibility'],
						'map_for_widget'       => $options_map['visibility'],
					),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'style',
					'title'         => esc_html__( 'Style', 'gracey-core' ),
					'options'       => array(
						'stretched' => esc_html__( 'Stretched', 'gracey-core' ),
						'centered'  => esc_html__( 'Centered', 'gracey-core' ),
					),
					'default_value' => 'stretched',
				)
			);
            $this->set_option(
                array(
                    'field_type' => 'textarea',
                    'name'       => 'main_text',
                    'title'      => esc_html__( 'Main Text', 'gracey-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type'    => 'select',
                    'name'          => 'text_tag',
                    'title'         => esc_html__( 'Text Tag', 'gracey-core' ),
                    'options'       => gracey_core_get_select_type_options_pool( 'title_tag' ),
                    'default_value' => 'h2',
                )
            );
            $this->set_option(
                array(
                    'field_type' => 'text',
                    'name'       => 'text_emphasize_words',
                    'title'      => esc_html__( 'Emphasize Words', 'gracey-core' ),
                    'description' => esc_html__( 'Enter the positions of the words you would like to Emphasize. Separate the positions with commas (e.g. if you would like the first, third, and fourth word to be emphasized, you would enter "1,3,4")', 'gracey-core' ),
                    'dependency' => array(
                        'hide' => array(
                            'main_text' => array(
                                'values'        => '',
                                'default_value' => '',
                            ),
                        ),
                    ),
                )
            );
            $this->set_option(
                array(
                    'field_type' => 'text',
                    'name'       => 'background_text',
                    'title'      => esc_html__( 'Background Text', 'gracey-core' ),
                )
            );
			$this->import_shortcode_options(
				array(
					'shortcode_base'    => 'gracey_core_button',
					'exclude'           => array( 'custom_class' ),
					'additional_params' => array(
						'group' => esc_html__( 'Button', 'gracey-core' ),
					),
				)
			);
			$this->map_extra_options();
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['button_params']  = $this->generate_button_params( $atts );
            $atts['main_text']          = $this->get_modified_text($atts);

			return gracey_core_get_template_part( 'shortcodes/call-to-action', 'variations/' . $atts['layout'] . '/templates/' . $atts['layout'], '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-call-to-action';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';
			$holder_classes[] = ! empty( $atts['style'] ) ? 'qodef-style--' . $atts['style'] : '';

			return implode( ' ', $holder_classes );
		}

		private function generate_button_params( $atts ) {
			$params = $this->populate_imported_shortcode_atts(
				array(
					'shortcode_base' => 'gracey_core_button',
					'exclude'        => array( 'custom_class' ),
					'atts'           => $atts,
				)
			);

			return $params;
		}

        private function get_modified_text($atts) {
            $text = $atts['main_text'];
            $text_emphasize_words = str_replace(' ', '', $atts['text_emphasize_words']);

            if ( !empty($text) ) {
                $emphasize_words = explode(',', $text_emphasize_words);
                $split_text = explode(' ', $text);

                if ( !empty($text_emphasize_words) ) {
                    foreach ($emphasize_words as $value) {
                        if ( !empty($split_text[$value - 1]) ) {
                            if ( !empty($split_text[$value]) && in_array( $value + 1 ,$emphasize_words )) {
                                $split_text[$value - 1] = '<span class="qodef-text-emphasize">' . $split_text[$value - 1] . ' ' . $split_text[$value] . '</span>';
                                unset($split_text[$value]);
                            } else {
                                $split_text[$value - 1] = '<span class="qodef-text-emphasize">' . $split_text[$value - 1] . '</span>';
                            }
                        }
                    }
                }

                $text = implode(' ', $split_text);
            }

            return $text;
        }
	}
}
