<?php

if ( ! function_exists( 'gracey_core_add_intro_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function gracey_core_add_intro_shortcode( $shortcodes ) {
		$shortcodes[] = 'GraceyCore_Intro_Shortcode';
		
		return $shortcodes;
	}
	
	add_filter( 'gracey_core_filter_register_shortcodes', 'gracey_core_add_intro_shortcode' );
}

if ( class_exists( 'GraceyCore_Shortcode' ) ) {
	class GraceyCore_Intro_Shortcode extends GraceyCore_Shortcode {
		
		public function __construct() {
			$this->set_layouts( apply_filters( 'gracey_core_filter_intro_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'gracey_core_filter_intro_extra_options', array() ) );
			
			parent::__construct();
		}
		
		public function map_shortcode() {
			$this->set_shortcode_path( GRACEY_CORE_SHORTCODES_URL_PATH . '/intro' );
			$this->set_base( 'gracey_core_intro' );
			$this->set_name( esc_html__( 'Intro Section', 'gracey-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds intro element', 'gracey-core' ) );
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
					'field_type' => 'select',
					'name'       => 'appear_animation',
					'title'      => esc_html__( 'Appear Animation', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'yes_no', false ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Image Items', 'gracey-core' ),
					'group'      => esc_html__( 'Images', 'gracey-core' ),
					'items'      => array(
						array(
							'field_type' => 'image',
							'name'       => 'item_image',
							'title'      => esc_html__( 'Item Image', 'gracey-core' ),
						),
						array(
							'field_type'  => 'select',
							'name'        => 'vertical_align',
							'title'       => esc_html__( 'Vertical Align', 'gracey-core' ),
							'description' => esc_html__( 'Vertical Alignment Relative To Images Holder', 'gracey-core' ),
							'default'     => '',
							'options'    => array(
								''           => 'Center',
								'flex-start' => 'Top',
								'flex-end'   => 'Bottom',
							),
						),
						array(
							'field_type'  => 'select',
							'name'        => 'horizontal_align',
							'title'       => esc_html__( 'Horizontal Align', 'gracey-core' ),
							'description' => esc_html__( 'Horizontal Alignment Relative To Images Holder', 'gracey-core' ),
							'default'     => '',
							'options'    => array(
								''           => 'Center',
								'flex-start' => 'Left',
								'flex-end'   => 'Right',
							),
						),
						array(
							'field_type' => 'select',
							'name'       => 'enable_custom_margin',
							'title'      => esc_html__( 'Enable Custom Spacing', 'gracey-core' ),
							'options'    => gracey_core_get_select_type_options_pool( 'no_yes', false ),
						),
						array(
							'field_type'  => 'text',
							'name'        => 'custom_margin',
							'title'       => esc_html__( 'Custom Margin', 'gracey-core' ),
							'description' => esc_html__( 'Set margin that will be applied for image in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'gracey-core' ),
							'default'     => '',
							'dependency'  => array(
								'show' => array(
									'enable_custom_margin' => array(
										'values'        => 'yes',
										'default_value' => 'no',
									),
								),
							)
						),
						array(
							'field_type'  => 'text',
							'name'        => 'custom_padding',
							'title'       => esc_html__( 'Custom Padding', 'gracey-core' ),
							'description' => esc_html__( 'Set padding that will be applied for image in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'gracey-core' ),
							'default'     => '',
							'dependency'  => array(
								'show' => array(
									'enable_custom_margin' => array(
										'values'        => 'yes',
										'default_value' => 'no',
									),
								),
							)
						),
						array(
							'field_type'  => 'text',
							'name'        => 'custom_rotate',
							'title'       => esc_html__( 'Custom Rotate', 'gracey-core' ),
							'description' => esc_html__( 'Set rotation that will be applied for image', 'gracey-core' ),
							'default'     => '',
						),
						array(
							'field_type' => 'select',
							'name'       => 'disable_image',
							'title'      => esc_html__( 'Disable Image', 'gracey-core' ),
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
						),
					),
				)
			);
			$this->import_shortcode_options(
				array(
					'shortcode_base'    => 'gracey_core_stamp',
					'exclude'           => array( 'custom_class', 'absolute_position' ),
					'additional_params' => array(
						'group' => esc_html__( 'Stamp', 'gracey-core' ),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'title',
					'title'      => esc_html__( 'Title Text', 'gracey-core' ),
					'group'      => esc_html__( 'Text', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'title_tag',
					'title'         => esc_html__( 'Title Tag', 'gracey-core' ),
					'options'       => gracey_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => 'h2',
					'group'         => esc_html__( 'Text', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'color',
					'title'      => esc_html__( 'Color', 'gracey-core' ),
					'group'      => esc_html__( 'Text', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'font_size',
					'title'      => esc_html__( 'Font Size', 'gracey-core' ),
					'group'      => esc_html__( 'Text', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'margin',
					'title'      => esc_html__( 'Margin', 'gracey-core' ),
					'group'      => esc_html__( 'Text', 'gracey-core' ),
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
					'name'        => 'font_size_1024',
					'title'       => esc_html__( 'Font Size', 'gracey-core' ),
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
					'name'        => 'font_size_680',
					'title'       => esc_html__( 'Font Size', 'gracey-core' ),
					'description' => esc_html__( 'Set responsive style value for screen size 680', 'gracey-core' ),
					'group'       => esc_html__( 'Screen Size 680', 'gracey-core' ),
				)
			);
			
			$this->map_extra_options();
		}
		
		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();
			
			$atts['unique_class']   = 'qodef-intro-section-' . rand( 0, 1000 );
			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['this_shortcode'] = $this;
			$atts['items']          = $this->parse_repeater_items( $atts['children'] );
			$atts['stamp_params']   = $this->generate_stamp_params( $atts );
//			$atts['text_styles']    = $this->get_text_styles( $atts );
			
			$this->set_responsive_styles( $atts );
			
			return gracey_core_get_template_part( 'shortcodes/intro', 'variations/' . $atts['layout'] . '/templates/' . $atts['layout'], '', $atts );
		}
		
		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();
			
			$holder_classes[] = 'qodef-intro-section';
			$holder_classes[] = $atts['unique_class'];
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';
			$holder_classes[] = 'yes' === $atts['appear_animation'] ? 'qodef--has-appear' : '';
			
			return implode( ' ', $holder_classes );
		}
		
		public function get_item_classes( $item ) {
			$item_classes =  array();
			$disable_image        = $item['disable_image'];
			
			$item_classes[] = ! empty( $disable_image ) ? 'qodef-hide-on--' . $disable_image  : '';
			
			return implode( ' ', $item_classes );
		}
		
		public function get_item_holder_styles( $item ) {
			
			$styles = array();
			
			$padding          = $item['custom_padding'];
			$margin_enabled   = $item['enable_custom_margin'];
			$vertical_align   = $item['vertical_align'];
			$horizontal_align = $item['horizontal_align'];
			
			if ( $margin_enabled == 'yes' ) {
				if ( $padding !== '' ){
					$styles[] = 'padding: ' . $padding;
				}
			}
			
			if ( $vertical_align !== '' ) {
				$styles[] .= 'align-items: ' . $vertical_align;
			}
			
			if ( $horizontal_align !== '' ) {
				$styles[] .= 'justify-content: ' . $horizontal_align;
			}
			
			return $styles;
		}
		
		public function get_item_styles( $item ) {
			
			$styles = array();
			
			$margin           = $item['custom_margin'];
			$margin_enabled   = $item['enable_custom_margin'];
			$custom_rotate    = $item['custom_rotate'];
			
			if ( $margin_enabled == 'yes' ) {
				if ( $margin !== '' ){
					$styles[] = 'margin: ' . $margin;
				}
			}
			
			if ( $custom_rotate !== '' ) {
				$styles[] .= '--qodef-rotate: ' . $custom_rotate;
			}
			return $styles;
		}
		
		private function generate_stamp_params( $atts ) {
			$params = $this->populate_imported_shortcode_atts(
				array(
					'shortcode_base' => 'gracey_core_stamp',
					'exclude'        => array( 'custom_class', 'absolute_position', 'top_position', 'bottom_position', 'left_position', 'right_position' ),
					'atts'           => $atts,
				)
			);
			
			return $params;
		}
		
		private function set_responsive_styles( $atts ) {
			$unique_class = '.' . $atts['unique_class'] . ' .qodef-custom-font-holder';
			$screen_sizes = array( '1440', '1024', '768', '680' );
			$option_keys  = array( 'font_size');
			
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
