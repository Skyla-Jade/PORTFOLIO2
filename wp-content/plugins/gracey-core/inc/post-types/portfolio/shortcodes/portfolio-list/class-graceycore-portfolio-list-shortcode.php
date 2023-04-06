<?php

if ( ! function_exists( 'gracey_core_add_portfolio_list_shortcode' ) ) {
	/**
	 * Function that isadding shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes - Array of registered shortcodes
	 *
	 * @return array
	 */
	function gracey_core_add_portfolio_list_shortcode( $shortcodes ) {
		$shortcodes[] = 'GraceyCore_Portfolio_List_Shortcode';

		return $shortcodes;
	}

	add_filter( 'gracey_core_filter_register_shortcodes', 'gracey_core_add_portfolio_list_shortcode' );
}

if ( class_exists( 'GraceyCore_List_Shortcode' ) ) {
	class GraceyCore_Portfolio_List_Shortcode extends GraceyCore_List_Shortcode {

		public function __construct() {
			$this->set_post_type( 'portfolio-item' );
			$this->set_post_type_taxonomy( 'portfolio-category' );
			$this->set_post_type_additional_taxonomies( array( 'portfolio-tag' ) );
			$this->set_layouts( apply_filters( 'gracey_core_filter_portfolio_list_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'gracey_core_filter_portfolio_list_extra_options', array() ) );
			$this->set_hover_animation_options( apply_filters( 'gracey_core_filter_portfolio_list_hover_animation_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( GRACEY_CORE_CPT_URL_PATH . '/portfolio/shortcodes/portfolio-list' );
			$this->set_base( 'gracey_core_portfolio_list' );
			$this->set_name( esc_html__( 'Portfolio List', 'gracey-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays list of portfolios', 'gracey-core' ) );
			$this->set_category( esc_html__( 'Gracey Core', 'gracey-core' ) );
            $this->set_scripts(
                array_merge(
                    array(
                        'SmoothScrollbar'        => array(
                            'registered' => false,
                            'url'        => GRACEY_CORE_INC_URL_PATH . '/post-types/portfolio/shortcodes/portfolio-list/assets/js/plugins/smooth-scrollbar.js',
                            'dependency' => array( 'jquery' )
                        ),
                        'HorizontalScrollPlugin' => array(
                            'registered' => false,
                            'url'        => GRACEY_CORE_INC_URL_PATH . '/post-types/portfolio/shortcodes/portfolio-list/assets/js/plugins/HorizontalScrollPlugin.js',
                            'dependency' => array( 'jquery' )
                        ),
                        'overscroll'             => array(
                            'registered' => false,
                            'url'        => GRACEY_CORE_INC_URL_PATH . '/post-types/portfolio/shortcodes/portfolio-list/assets/js/plugins/overscroll.js',
                            'dependency' => array( 'jquery' )
                        ),
                    ), apply_filters( 'gracey_core_filter_portfolio_list_register_assets', array() )
                )
            );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'custom_class',
					'title'      => esc_html__( 'Custom Class', 'gracey-core' ),
				)
			);
			$this->map_list_options();

            $this->set_option(
                array(
                    'field_type'    => 'select',
                    'name'          => 'custom_behavior',
                    'title'         => esc_html__( 'Custom Behavior', 'gracey-core' ),
                    'options'       => array(
                        'no'                  => esc_html__( 'No', 'gracey-core' ),
                        'horizontal_slider'   => esc_html__( 'Horizontal Slider', 'gracey-core' ),
                        'full_slider'         => esc_html__( 'Full Slider', 'gracey-core' ),
                    ),
                    'default_value' => 'no',
                    'description'   => esc_html__( 'If set, it will ignore most of the General options.', 'gracey-core' ),
                    'group'         => esc_html__( 'Custom Behavior', 'gracey-core' ),
                )
            );

            // horizontal slider start
            $this->set_option(
                array(
                    'field_type' => 'text',
                    'name'       => 'horizontal_info_subtitle',
                    'title'      => esc_html__( 'Info Panel Subtitle', 'gracey-core' ),
                    'dependency' => array(
                        'show' => array(
                            'custom_behavior' => array(
                                'values' => 'horizontal_slider',
                            ),
                        ),
                    ),
                    'group'      => esc_html__( 'Custom Behavior', 'gracey-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type' => 'text',
                    'name'       => 'horizontal_info_title',
                    'title'      => esc_html__( 'Info Panel Title', 'gracey-core' ),
                    'dependency' => array(
                        'show' => array(
                            'custom_behavior' => array(
                                'values' => 'horizontal_slider',
                            ),
                        ),
                    ),
                    'group'      => esc_html__( 'Custom Behavior', 'gracey-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type' => 'text',
                    'name'       => 'horizontal_info_button_text',
                    'title'      => esc_html__( 'Info Panel Button Text', 'gracey-core' ),
                    'dependency' => array(
                        'show' => array(
                            'custom_behavior' => array(
                                'values' => 'horizontal_slider',
                            ),
                        ),
                    ),
                    'group'      => esc_html__( 'Custom Behavior', 'gracey-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type' => 'text',
                    'name'       => 'horizontal_info_button_link',
                    'title'      => esc_html__( 'Info Panel Button Link', 'gracey-core' ),
                    'dependency' => array(
                        'show' => array(
                            'custom_behavior' => array(
                                'values' => 'horizontal_slider',
                            ),
                        ),
                    ),
                    'group'      => esc_html__( 'Custom Behavior', 'gracey-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type' => 'select',
                    'name'       => 'horizontal_info_button_link_target',
                    'title'      => esc_html__( 'Info Panel Button Link Target', 'gracey-core' ),
                    'dependency' => array(
                        'show' => array(
                            'custom_behavior' => array(
                                'values' => 'horizontal_slider',
                            ),
                        ),
                    ),
                    'options'       => gracey_core_get_select_type_options_pool( 'link_target' ),
                    'default_value' => '_self',
                    'group'      => esc_html__( 'Custom Behavior', 'gracey-core' ),
                )
            );
            // horizontal slider end

			$this->map_query_options( array( 'post_type' => $this->get_post_type() ) );
			$this->map_layout_options(
				array(
					'layouts'          => $this->get_layouts(),
					'hover_animations' => $this->get_hover_animation_options(),
				)
			);
            $this -> set_option( array (
                'field_type'    => 'text',
                'name'          => 'item_bottom_padding',
                'title'         => esc_html__( 'Additional Item Bottom Padding', 'gracey-core' ),
                'default_value' => '',
                'group'         => esc_html__( 'Layout', 'gracey-core' ),
                'dependency'    => array (
                    'hide' => array (
                        'behavior' => array (
                            'values'        => 'slider',
                            'default_value' => '',
                        ),
                    ),
                ),
            ) );
            $this -> set_option( array (
                'field_type'    => 'select',
                'name'          => 'invert_image_colors',
                'title'         => esc_html__( 'Invert Image Colors on Hover', 'gracey-core' ),
                'options'       => gracey_core_get_select_type_options_pool( 'no_yes', false ),
                'default_value' => 'no',
                'group'         => esc_html__( 'Layout', 'gracey-core' ),
                'dependency'    => array (
                    'show' => array (
                        'layout' => array (
                            'values'        => 'info-follow',
                            'default_value' => '',
                        ),
                    ),
                ),
            ) );
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'distort_animation',
					'title'      => esc_html__( 'Distort Animation', 'gracey-core' ),
					'description'=> esc_html__( 'Enable Distort Animation on Appear Or Hover', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'yes_no', false),
					'group'      => esc_html__( 'Layout', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'distort_animation_effect',
					'title'      => esc_html__( 'Distort Animation Effect', 'gracey-core' ),
					'options'    => array(
						'' => esc_html__( 'Effect 1', 'gracey-core' ),
						'2' => esc_html__( 'Effect 2', 'gracey-core' ),
						'3' => esc_html__( 'Effect 3', 'gracey-core' ),
						'4' => esc_html__( 'Effect 4', 'gracey-core' ),
					),
					'dependency'  => array(
						'show' => array(
							'distort_animation' => array(
								'values'        => 'yes',
								'default_value' => 'no'
							)
						)
					),
					'group'      => esc_html__( 'Layout', 'gracey-core' ),
					
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'animation_hide_overflow',
					'title'      => esc_html__( 'Hide Overflow For Distort Animation', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'yes_no', false),
					'dependency'  => array(
						'show' => array(
							'distort_animation' => array(
								'values'        => 'yes',
								'default_value' => 'no'
							)
						)
					),
					'group'      => esc_html__( 'Layout', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'disable_distort_animation_on_safari',
					'title'      => esc_html__( 'Disable Distort Animation On Safari', 'gracey-core' ),
					'description'=> esc_html__( 'Depending on number and size of images distort animation on safari could produce bugs', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'yes_no', false),
					'group'      => esc_html__( 'Layout', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'disable_distort_animation_on_mobile_devices',
					'title'      => esc_html__( 'Disable Distort Animation On Mobile Devices', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'yes_no', false),
					'group'      => esc_html__( 'Layout', 'gracey-core' ),
				)
			);
            $this->set_option(
                array(
                    'field_type'    => 'text',
                    'name'          => 'font_size',
                    'title'         => esc_html__( 'Font Size', 'gracey-core' ),
                    'group'         => esc_html__( 'Layout', 'gracey-core' ),
                    'default_value' => ''
                )
            );

            $this->set_option(
                array(
                    'field_type'    => 'select',
                    'name'          => 'intro_item',
                    'title'         => esc_html__( 'Enable Intro Item', 'gracey-core' ),
                    'options'       => gracey_core_get_select_type_options_pool( 'no_yes', false ),
                    'default_value' => 'no',
                    'group'         => esc_html__( 'Intro Item', 'gracey-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type'    => 'text',
                    'name'          => 'intro_item_title',
                    'title'         => esc_html__( 'Intro Item Title', 'gracey-core' ),
                    'group'         => esc_html__( 'Intro Item', 'gracey-core' ),
                    'dependency' => array(
                        'show' => array(
                            'intro_item' => array(
                                'values' => 'yes',
                            ),
                        ),
                    ),
                    'default_value' => ''
                )
            );
            $this->set_option(
                array(
                    'field_type'  => 'text',
                    'name'        => 'intro_item_title_line_break_positions',
                    'title'       => esc_html__( 'Positions of Line Break', 'gracey-core' ),
                    'description' => esc_html__( 'Enter the positions of the words after which you would like to create a line break. Separate the positions with commas (e.g. if you would like the first, third, and fourth word to have a line break, you would enter "1,3,4")', 'gracey-core' ),
                    'group'         => esc_html__( 'Intro Item', 'gracey-core' ),
                    'dependency' => array(
                        'hide' => array(
                            'intro_item_title' => array(
                                'values'        => '',
                                'default_value' => '',
                            ),
                        ),
                    ),
                )
            );
            $this->set_option(
                array(
                    'field_type'    => 'text',
                    'name'          => 'intro_item_subtitle',
                    'title'         => esc_html__( 'Intro Item Subtitle', 'gracey-core' ),
                    'group'         => esc_html__( 'Intro Item', 'gracey-core' ),
                    'dependency' => array(
                        'show' => array(
                            'intro_item' => array(
                                'values' => 'yes',
                            ),
                        ),
                    ),
                    'default_value' => ''
                )
            );
            $this->set_option(
                array(
                    'field_type'    => 'text',
                    'name'          => 'intro_item_background_text',
                    'title'         => esc_html__( 'Intro Item Background Text', 'gracey-core' ),
                    'group'         => esc_html__( 'Intro Item', 'gracey-core' ),
                    'dependency' => array(
                        'show' => array(
                            'intro_item' => array(
                                'values' => 'yes',
                            ),
                        ),
                    ),
                    'default_value' => ''
                )
            );
            $this->set_option(
                array(
                    'field_type'    => 'text',
                    'name'          => 'intro_item_link',
                    'title'         => esc_html__( 'Intro Item Link', 'gracey-core' ),
                    'group'         => esc_html__( 'Intro Item', 'gracey-core' ),
                    'dependency' => array(
                        'show' => array(
                            'intro_item' => array(
                                'values' => 'yes',
                            ),
                        ),
                    ),
                    'default_value' => ''
                )
            );

            $this->set_option(
                array(
                    'field_type'    => 'select',
                    'name'          => 'slider_navigation_position',
                    'title'         => esc_html__( 'Slider Navigation Position', 'gracey-core' ),
                    'options'       => array(
                        ''                => esc_html__( 'Default', 'gracey-core' ),
                        'below_slider'    => esc_html__( 'Below Slider', 'gracey-core' ),
                    ),
                    'dependency' => array(
                        'hide' => array(
                            'slider_navigation' => array(
                                'values' => 'no',
                            ),
                        ),
                    ),
                    'default_value' => ''
                )
            );

            $this->set_option(
                array(
                    'field_type'    => 'select',
                    'name'          => 'skew_slider',
                    'title'         => esc_html__( 'Skew Slider', 'gracey-core' ),
                    'options'       => gracey_core_get_select_type_options_pool( 'no_yes', false ),
                    'dependency' => array(
                        'show' => array(
                            'behavior' => array(
                                'values' => 'slider',
                            ),
                        ),
                    ),
                    'default_value' => ''
                )
            );
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'appear_animation',
					'title'      => esc_html__( 'Appear Animation', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'yes_no', false ),
					'dependency' => array(
						'show' => array(
							'skew_slider' => array(
								'values' => 'yes',
							),
						),
					),
				)
			);
            $this->set_option(
                array(
                    'field_type'    => 'select',
                    'name'          => 'enable_background_text',
                    'title'         => esc_html__( 'Enable Background Text', 'gracey-core' ),
                    'options'       => gracey_core_get_select_type_options_pool( 'no_yes', false ),
                    'dependency' => array(
                        'show' => array(
                            'behavior' => array(
                                'values' => 'slider',
                            ),
                        ),
                    ),
                    'default_value' => ''
                )
            );
            $this->set_option(
                array(
                    'field_type'    => 'text',
                    'name'          => 'background_text',
                    'title'         => esc_html__( 'Background Text', 'gracey-core' ),
                    'dependency' => array(
                        'show' => array(
                            'enable_background_text' => array(
                                'values' => 'yes',
                            ),
                        ),
                    ),
                    'default_value' => ''
                )
            );

			$this->map_additional_options();
			$this->map_extra_options();
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'gracey_core_portfolio_list', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function load_assets() {
			parent::load_assets();

			do_action( 'gracey_core_action_portfolio_list_load_assets', $this->get_atts() );
		}

		public function render( $options, $content = null ) {
			parent::render( $options );

            // full_slider override start
            if ( $this->get_single_att( 'custom_behavior' ) === 'full_slider' ) {
                $this->set_single_att( 'behavior', 'slider' );
                $this->set_single_att( 'columns', '1' );
                $this->set_single_att( 'space', 'no' );
                $this->set_single_att( 'slider_direction', 'vertical' );
                $this->set_single_att( 'slider_pagination', 'yes' );
                $this->set_single_att( 'slider_navigation', 'no' );
                $this->set_single_att( 'enable_fullheight', 'no' );
                $this->set_single_att( 'slider_mousewheel', 'yes' );
	            $this->set_single_att( 'slider_effect', 'fade' );
            }
            // full_slider override end

			$atts = $this->get_atts();
			
			// regular slider override start
			if ( isset( $atts['slider_width'] ) && $atts['slider_width'] === 'yes' && $atts['skew_slider'] !== 'yes' ) {
				$atts['slider_looped_slides'] = '10';
			}
			// regular slider override end

			$atts['post_type']       = $this->get_post_type();
			$atts['taxonomy_filter'] = $this->get_post_type_taxonomy();

			// Additional query args
			$atts['additional_query_args'] = $this->get_additional_query_args( $atts );

			$atts['query_result']   = new \WP_Query( gracey_core_get_query_params( $atts ) );
			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['outer_holder_classes'] = $this->get_outer_holder_classes( $atts );
			$atts['slider_attr']    = $this->get_slider_data( $atts );
			$atts['data_attr']      = gracey_core_get_pagination_data( GRACEY_CORE_REL_PATH, 'post-types/portfolio/shortcodes', 'portfolio-list', 'portfolio', $atts );
            $atts['intro_item_title'] = $this->get_modified_intro_item_title( $atts );

			$atts['this_shortcode'] = $this;

            // horizontal_slider override start
            if ( $this->get_single_att( 'custom_behavior' ) === 'horizontal_slider' ) {
                return gracey_core_get_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'templates/content', 'slider-custom-horizontal', $atts );
            }
            // horizontal_slider override end

			return gracey_core_get_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'templates/content', $atts['behavior'], $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-portfolio-list';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-item-layout--' . $atts['layout'] : '';
            $holder_classes[] = ! empty( $atts['custom_behavior'] ) ? 'qodef-layout--' . $atts['custom_behavior'] : '';
            $holder_classes[] = ! empty( $atts['slider_navigation_position'] ) && $atts['slider_navigation_position'] === 'below_slider' ? 'qodef-navigation--below' : '';
            $holder_classes[] = ! empty( $atts['invert_image_colors'] ) && $atts['invert_image_colors'] === 'yes' ? 'qodef-invert-colors' : '';
			$holder_classes[] = ! empty( $atts['distort_animation'] ) && ( $atts['distort_animation'] ) == 'yes' ? 'qodef--distort-animation-list' : '';
			$holder_classes[] = ! empty( $atts['distort_animation_effect'] )  ? 'qodef--distort-effect-' . $atts['distort_animation_effect'] : '';
			$holder_classes[] = ! empty( $atts['disable_distort_animation_on_safari'] ) && ( $atts['disable_distort_animation_on_safari'] ) == 'yes' ? 'qodef--distort-animation-disabled-on-safari' : '';
			$holder_classes[] = ! empty( $atts['disable_distort_animation_on_mobile_devices'] ) && ( $atts['disable_distort_animation_on_mobile_devices'] ) == 'yes' ? 'qodef--distort-animation-disabled-on-mobile' : '';
			$holder_classes[] = ! empty( $atts['animation_hide_overflow'] ) && ( $atts['animation_hide_overflow'] ) == 'yes'  ? 'qodef--distort-hide-overflow' : '';
			$holder_classes[] = ! empty( $atts['info_follow_background'] ) && ( $atts['info_follow_background'] ) == 'no'  ? 'qodef--disabled-info-follow-bg' : '';

            // custom horizontal slider
            if ( $this->get_single_att( 'custom_behavior' ) === 'horizontal_slider' ) {
                $key = array_search( 'qodef-swiper-container', $holder_classes );
                unset( $holder_classes[ $key ] );
            }

			$list_classes            = $this->get_list_classes( $atts );
			$hover_animation_classes = $this->get_hover_animation_classes( $atts );
			$holder_classes          = array_merge( $holder_classes, $list_classes, $hover_animation_classes );
            if ( isset( $atts['slider_width'] ) && $atts['slider_width'] === 'yes') {
	            $holder_classes[] = 'qodef-auto-width-slider';
            }

			return implode( ' ', $holder_classes );
		}

        private function get_outer_holder_classes( $atts ) {
            $holder_classes = array();

            $holder_classes[] = 'qodef-portfolio-slider-holder';

            if ( isset( $atts['skew_slider'] ) && $atts['skew_slider'] === 'yes') {
                $holder_classes[] = 'qodef-skew-slider-holder';
	
	            if ($atts['appear_animation'] === 'yes') {
		            $holder_classes[] = 'qodef--has-appear';
	            }
            }

            if ( isset( $atts['enable_background_text'] ) && $atts['enable_background_text'] === 'yes') {
                $holder_classes[] = 'qodef-background-text';
            }

            return implode( ' ', $holder_classes );
        }

		public function get_item_classes( $atts ) {
			$item_classes = $this->init_item_classes();

			$list_item_classes = $this->get_list_item_classes( $atts );

			$item_classes = array_merge( $item_classes, $list_item_classes );

			return implode( ' ', $item_classes );
		}

		public function get_title_styles( $atts ) {
			$styles = array();

            if ( ! empty( $atts['font_size'] ) ) {
                if ( qode_framework_string_ends_with_typography_units( $atts['font_size'] ) ) {
                    $styles[] = 'font-size: ' . $atts['font_size'];
                } else {
                    $styles[] = 'font-size: ' . intval( $atts['font_size'] ) . 'px';
                }
            }

			if ( ! empty( $atts['text_transform'] ) ) {
				$styles[] = 'text-transform: ' . $atts['text_transform'];
			}

			return $styles;
		}

		public function get_list_item_style( $atts ) {
            $styles = array ();

            if ( ! empty( $atts[ 'item_bottom_padding' ] ) ) {
                if ( qode_framework_string_ends_with_space_units( $atts[ 'item_bottom_padding' ] ) ) {
                    $styles[] = 'padding-bottom: ' . $atts[ 'item_bottom_padding' ];
                } else {
                    $styles[] = 'padding-bottom: ' . intval( $atts[ 'item_bottom_padding' ] ) . 'px';
                }
            }

            return $styles;
		}

        private function get_modified_intro_item_title( $atts ) {
            $title = $atts['intro_item_title'];

            if ( ! empty( $title ) && ! empty( $atts['intro_item_title_line_break_positions'] ) ) {
                $split_title          = explode( ' ', $title );
                $line_break_positions = explode( ',', str_replace( ' ', '', $atts['intro_item_title_line_break_positions'] ) );

                foreach ( $line_break_positions as $position ) {
                    $position = intval($position);
                    if ( isset( $split_title[ $position - 1 ] ) && ! empty( $split_title[ $position - 1 ] ) ) {
                        $split_title[ $position - 1 ] = $split_title[ $position - 1 ] . '<br />';
                    }
                }

                $title = implode( ' ', $split_title );
            }

            return $title;
        }
	}
}
