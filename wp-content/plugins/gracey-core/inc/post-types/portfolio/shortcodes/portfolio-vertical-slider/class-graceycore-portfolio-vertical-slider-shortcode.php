<?php

if ( ! function_exists( 'gracey_core_add_portfolio_vertical_slider_shortcode' ) ) {
	/**
	 * Function that isadding shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes - Array of registered shortcodes
	 *
	 * @return array
	 */
	function gracey_core_add_portfolio_vertical_slider_shortcode( $shortcodes ) {
		$shortcodes[] = 'GraceyCore_Portfolio_Vertical_Slider_Shortcode';
		
		return $shortcodes;
	}
	
	add_filter( 'gracey_core_filter_register_shortcodes', 'gracey_core_add_portfolio_vertical_slider_shortcode' );
}

if ( class_exists( 'GraceyCore_List_Shortcode' ) ) {
	class GraceyCore_Portfolio_Vertical_Slider_Shortcode extends GraceyCore_List_Shortcode {
		
		public function __construct() {
			$this->set_post_type( 'portfolio-item' );
			$this->set_post_type_taxonomy( 'portfolio-category' );
			$this->set_post_type_additional_taxonomies( array( 'portfolio-tag' ) );
			$this->set_layouts( apply_filters( 'gracey_core_filter_portfolio_vertical_slider_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'gracey_core_filter_portfolio_vertical_slider_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( GRACEY_CORE_CPT_URL_PATH . '/portfolio/shortcodes/portfolio-vertical-slider' );
			$this->set_base( 'gracey_core_portfolio_vertical_slider' );
			$this->set_name( esc_html__( 'Portfolio Vertical Slider', 'gracey-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays list of portfolios', 'gracey-core' ) );
			$this->set_category( esc_html__( 'Gracey Core', 'gracey-core' ) );
			$this->set_scripts(
				apply_filters('gracey_core_filter_portfolio_vertical_slider_register_assets', array())
			);

			$this->set_option( array(
				'field_type' => 'text',
				'name'       => 'custom_class',
				'title'      => esc_html__( 'Custom Class', 'gracey-core' )
			) );

            $this->map_list_options(
                array(
                    'exclude_behavior' => array( 'masonry', 'slider', 'justified-gallery' ),
                    'exclude_option'   => array( 'columns' ),
                )
            );

			$this->set_option( array(
				'field_type'    => 'text',
				'name'          => 'excerpt_length',
				'group'         => 'layout',
				'title'         => esc_html__( 'Excerpt Length', 'gracey-core' ),
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
					'name'       => 'disable_distort_animation_on_safari',
					'title'      => esc_html__( 'Disable Distort Animation On Safari', 'gracey-core' ),
					'description'=> esc_html__( 'Depending on number and size of images distort animation on safari could produce bugs', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'yes_no', false),
					'group'      => esc_html__( 'Layout', 'gracey-core' ),
				)
			);

            $custom_sidebars = gracey_core_get_custom_sidebars();
            if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
                $this->set_option( array(
                    'field_type'    => 'select',
                    'name'          => 'custom_widget_area',
                    'title'         => esc_html__( 'Custom Widget Area', 'gracey-core' ),
                    'options'       => $custom_sidebars,
                    'group'         => 'layout',
                ) );
            }

			$this->map_query_options( array( 'post_type' => $this->get_post_type() ) );
            $this->map_layout_options( array( 'layouts' => $this->get_layouts() ) );
			$this->map_extra_options();
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'gracey_core_portfolio_vertical_slider', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function load_assets() {
			parent::load_assets();

			do_action( 'gracey_core_action_portfolio_vertical_slider_load_assets', $this->get_atts() );
		}
		
		public function render( $options, $content = null ) {
			parent::render( $options );
			
			$atts = $this->get_atts();
			
			$atts['post_type']       = $this->get_post_type();
			$atts['taxonomy_filter'] = $this->get_post_type_taxonomy();
			
			// Additional query args
			$atts['additional_query_args'] = $this->get_additional_query_args( $atts );

			$atts['query_result']           = new \WP_Query( gracey_core_get_query_params( $atts ) );
			$atts['holder_inner_classes'] = $this->get_holder_inner_classes( $atts );
			$atts['holder_classes']         = $this->get_holder_classes( $atts );
			$atts['slider_attr']            = $this->get_slider_data( $atts, array( 'outsidePagination' => 'yes' ) );
			$atts['data_attr']              = gracey_core_get_pagination_data( GRACEY_CORE_REL_PATH, 'post-types/portfolio/shortcodes', 'portfolio-vertical-slider', 'portfolio', $atts );
			$atts['this_shortcode']         = $this;
			$atts['unique_id']              =  wp_unique_id('qodef-svg-custom-distort-');
			
			return gracey_core_get_template_part( 'post-types/portfolio/shortcodes/portfolio-vertical-slider', 'templates/content-vertical-slider', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();
			
			$holder_classes[] = 'qodef-portfolio-vertical-slider';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-item-layout--' . $atts['layout'] : '';
			$holder_classes[] = ! empty( $atts['distort_animation'] ) && ( $atts['distort_animation'] ) == 'yes' ? 'qodef--custom-distort-animation-list' : '';
			$holder_classes[] = ! empty( $atts['disable_distort_animation_on_safari'] ) && ( $atts['disable_distort_animation_on_safari'] ) == 'yes' ? 'qodef--distort-animation-disabled-on-safari' : '';
			
			$list_classes            = $this->get_list_classes( $atts );
			$holder_classes          = array_merge( $holder_classes, $list_classes );
			
			return implode( ' ', $holder_classes );
		}

        private function get_holder_inner_classes( $atts ) {
            $holder_inner_classes[] = 'qodef-pvs-holder-inner';
            $holder_inner_classes[] = 'swiper-container';

            return implode( ' ', $holder_inner_classes );
        }
		
		public function get_item_classes( $atts ) {
			$item_classes = $this->init_item_classes();
			
			$list_item_classes = $this->get_list_item_classes( $atts );
            array_push($list_item_classes, 'swiper-slide');
			
			$item_classes = array_merge( $item_classes, $list_item_classes );
			
			return implode( ' ', $item_classes );
		}
		
		public function get_title_styles( $atts ) {
			$styles = array();
			
			if ( ! empty( $atts['text_transform'] ) ) {
				$styles[] = 'text-transform: ' . $atts['text_transform'];
			}
			
			return $styles;
		}
	}
}
