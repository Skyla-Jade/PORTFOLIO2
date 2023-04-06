<?php

if ( ! function_exists( 'gracey_core_add_stacked_portfolio_shortcode' ) ) {
    /**
     * Function that add shortcode into shortcodes list for registration
     *
     * @param array $shortcodes
     *
     * @return array
     */
    function gracey_core_add_stacked_portfolio_shortcode( $shortcodes ) {
        $shortcodes[] = 'GraceyCore_Stacked_Portfolio_Shortcode';

        return $shortcodes;
    }

    add_filter( 'gracey_core_filter_register_shortcodes', 'gracey_core_add_stacked_portfolio_shortcode' );
}

if ( class_exists( 'GraceyCore_Shortcode' ) ) {
    class GraceyCore_Stacked_Portfolio_Shortcode extends GraceyCore_Shortcode {

        public function __construct() {
            $this->set_layouts( apply_filters( 'gracey_core_filter_stacked_portfolio_layouts', array() ) );
            $this->set_extra_options( apply_filters( 'gracey_core_filter_stacked_portfolio_extra_options', array() ) );

            parent::__construct();
        }

        public function map_shortcode() {
            $this->set_shortcode_path( GRACEY_CORE_CPT_URL_PATH . '/portfolio/shortcodes/stacked-portfolio' );
            $this->set_base( 'gracey_core_stacked_portfolio' );
            $this->set_name( esc_html__( 'Stacked Portfolio', 'gracey-core' ) );
            $this->set_description( esc_html__( 'Shortcode that displays list of stacked portfolios', 'gracey-core' ) );
            $this->set_category( esc_html__( 'Gracey Core', 'gracey-core' ) );
            $this->set_option(
                array(
                    'field_type' => 'text',
                    'name'       => 'custom_class',
                    'title'      => esc_html__( 'Custom Class', 'gracey-core' ),
                )
            );

            $this->set_option(
                array(
                    'field_type'    => 'select',
                    'name'          => 'title_tag',
                    'title'         => esc_html__( 'Item Title Tag', 'gracey-core' ),
                    'options'       => gracey_core_get_select_type_options_pool( 'title_tag' ),
                    'default_value' => 'h5',
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
                    'field_type'    => 'text',
                    'name'          => 'posts_per_page',
                    'title'         => esc_html__( 'Posts per Page', 'gracey-core' ),
                    'default_value' => '6',
                    'group'         => esc_html__( 'Query', 'gracey-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type' => 'text',
                    'name'       => 'category',
                    'title'      => esc_html__( 'One-Category Portfolio List', 'gracey-core' ),
                    'description' => esc_html__( 'Enter one category slug (leave empty for showing all categories)', 'gracey-core' ),
                    'group'      => esc_html__( 'Query', 'gracey-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type'  => 'text',
                    'name'        => 'post_ids',
                    'title'       => esc_html__( 'Posts IDs', 'gracey-core' ),
                    'description' => esc_html__( 'Separate post IDs with commas', 'gracey-core' ),
                    'group'       => esc_html__( 'Query', 'gracey-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type'    => 'select',
                    'name'          => 'orderby',
                    'title'         => esc_html__( 'Order By', 'gracey-core' ),
                    'options'       => gracey_core_get_select_type_options_pool( 'order_by' ),
                    'default_value' => 'date',
                    'group'         => esc_html__( 'Query', 'gracey-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type'    => 'select',
                    'name'          => 'order',
                    'title'         => esc_html__( 'Order', 'gracey-core' ),
                    'options'       => gracey_core_get_select_type_options_pool( 'order' ),
                    'default_value' => 'DESC',
                    'group'         => esc_html__( 'Query', 'gracey-core' ),
                )
            );

            $this->set_option(
                array(
                    'field_type' => 'text',
                    'name'       => 'title',
                    'title'      => esc_html__( 'Title', 'gracey-core' ),
                    'group'      => esc_html__( 'End Of Scroll', 'gracey-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type'    => 'select',
                    'name'          => 'eos_title_tag',
                    'title'         => esc_html__( 'Title Tag', 'gracey-core' ),
                    'options'       => gracey_core_get_select_type_options_pool( 'title_tag' ),
                    'default_value' => 'h1',
                    'group'      => esc_html__( 'End Of Scroll', 'gracey-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type' => 'color',
                    'name'       => 'eos_title_color',
                    'title'      => esc_html__( 'Title Color', 'gracey-core' ),
                    'group'      => esc_html__( 'End Of Scroll', 'gracey-core' ),
                )
            );
            $this->set_option(
                array(
                    'field_type' => 'text',
                    'name'       => 'title_emphasize_words',
                    'title'      => esc_html__( 'Emphasize Words', 'gracey-core' ),
                    'description' => esc_html__( 'Enter the positions of the words you would like to Emphasize. Separate the positions with commas (e.g. if you would like the first, third, and fourth word to be emphasized, you would enter "1,3,4")', 'gracey-core' ),
                    'dependency' => array(
                        'hide' => array(
                            'title' => array(
                                'values'        => '',
                                'default_value' => '',
                            ),
                        ),
                    ),
                    'group'      => esc_html__( 'End Of Scroll', 'gracey-core' ),
                )
            );

            $custom_sidebars = gracey_core_get_custom_sidebars();
            if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
                $this->set_option( array(
                    'field_type'    => 'select',
                    'name'          => 'widget_area',
                    'title'         => esc_html__( 'Custom Widget Area', 'gracey-core' ),
                    'options'       => $custom_sidebars,
                    'group'         => esc_html__( 'Static Content', 'gracey-core' ),
                ) );
            }

            $this->map_extra_options();
        }

        public static function call_shortcode( $params ) {
            $html = qode_framework_call_shortcode( 'gracey_core_stacked_portfolio', $params );
            $html = str_replace( "\n", '', $html );

            return $html;
        }

        public function render( $options, $content = null ) {
            parent::render( $options );
            $atts = $this->get_atts();

            $atts['query_result']   = new \WP_Query( $this->get_query_array( $atts ) );
            $atts['holder_classes'] = $this->get_holder_classes( $atts );
            $atts['title_styles']   = $this->get_title_styles( $atts );
            $atts['title']          = $this->get_modified_title($atts);
            $atts['this_shortcode'] = $this;

            return gracey_core_get_template_part( 'post-types/portfolio/shortcodes/stacked-portfolio', 'templates/content', '', $atts );
        }

        private function get_query_array( $params ) {
            $query_array = array(
                'post_status'    => 'publish',
                'post_type'      => 'portfolio-item',
                'posts_per_page' => $params['posts_per_page'],
                'orderby'        => $params['orderby'],
                'order'          => $params['order']
            );

            if ( ! empty( $params['category'] ) ) {
                $query_array['portfolio-category'] = $params['category'];
            }

            $project_ids = null;
            if ( ! empty( $params['post_ids'] ) ) {
                $project_ids             = explode( ',', $params['post_ids'] );
                $query_array['post__in'] = $project_ids;
            }

            if ( ! empty( $params['next_page'] ) ) {
                $query_array['paged'] = $params['next_page'];
            } else {
                $query_array['paged'] = 1;
            }

            return $query_array;
        }

        private function get_holder_classes( $atts ) {
            $holder_classes = $this->init_holder_classes();

            $holder_classes[] = 'qodef-stacked-portfolio';
            $holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';

            return implode( ' ', $holder_classes );
        }

        public function get_article_offsets() {
            $offsets = [];

            if (!empty(get_post_meta( get_the_ID(), "qodef_stacked_portfolio_x_meta", true ))) {
                $offsets['x'] = get_post_meta( get_the_ID(), "qodef_stacked_portfolio_x_meta", true );
            } else {
                $offsets['x'] = 'center';
            }

            if (!empty(get_post_meta( get_the_ID(), "qodef_stacked_portfolio_y_meta", true ))) {
                $offsets['y'] = get_post_meta( get_the_ID(), "qodef_stacked_portfolio_y_meta", true );
            } else {
                $offsets['y'] = 'center';
            }

            return $offsets;
        }

        public function get_item_link() {
            $portfolio_link_meta = get_post_meta( get_the_ID(), 'portfolio_external_link', true );
            $portfolio_link      = ! empty( $portfolio_link_meta ) ? $portfolio_link_meta : get_permalink( get_the_ID() );

            return apply_filters( 'manon_edge_filter_portfolio_external_link', $portfolio_link );
        }

        public function get_item_link_target() {
            $portfolio_link_meta   = get_post_meta( get_the_ID(), 'portfolio_external_link', true );
            $portfolio_link_target = ! empty( $portfolio_link_meta ) ? '_blank' : '_self';

            return apply_filters( 'manon_edge_filter_portfolio_external_link_target', $portfolio_link_target );
        }

        private function get_title_styles( $atts ) {
            $styles = array();

            if ( ! empty( $atts['eos_title_color'] ) ) {
                $styles[] = 'color: ' . $atts['eos_title_color'];
            }

            return $styles;
        }

        private function get_modified_title($atts) {
            $title = $atts['title'];
            $title_emphasize_words = str_replace(' ', '', $atts['title_emphasize_words']);

            if ( !empty($title) ) {
                $emphasize_words = explode(',', $title_emphasize_words);
                $split_title = explode(' ', $title);

                if ( !empty($title_emphasize_words) ) {
                    foreach ($emphasize_words as $value) {
                        if ( !empty($split_title[$value - 1]) ) {
                            if ( !empty($split_title[$value]) && in_array( $value + 1 ,$emphasize_words )) {
                                $split_title[$value - 1] = '<span class="qodef-sp-title-emphasize">' . $split_title[$value - 1] . ' ' . $split_title[$value] . '</span>';
                                unset($split_title[$value]);
                            } else {
                                $split_title[$value - 1] = '<span class="qodef-sp-title-emphasize">' . $split_title[$value - 1] . '</span>';
                            }
                        }
                    }
                }

                $title = implode(' ', $split_title);
            }

            return $title;
        }
    }
}
