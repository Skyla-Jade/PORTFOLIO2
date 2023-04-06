<?php

if ( ! function_exists( 'gracey_core_add_interactive_link_showcase_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function gracey_core_add_interactive_link_showcase_shortcode( $shortcodes ) {
		$shortcodes[] = 'GraceyCore_Interactive_Link_Showcase_Shortcode';

		return $shortcodes;
	}

	add_filter( 'gracey_core_filter_register_shortcodes', 'gracey_core_add_interactive_link_showcase_shortcode' );
}

if ( class_exists( 'GraceyCore_Shortcode' ) ) {
	class GraceyCore_Interactive_Link_Showcase_Shortcode extends GraceyCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'gracey_core_filter_interactive_link_showcase_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'gracey_core_filter_interactive_link_showcase_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( GRACEY_CORE_SHORTCODES_URL_PATH . '/interactive-link-showcase' );
			$this->set_base( 'gracey_core_interactive_link_showcase' );
			$this->set_name( esc_html__( 'Interactive Link Showcase', 'gracey-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds interactive link showcase holder', 'gracey-core' ) );
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
					'name'       => 'skin',
					'title'      => esc_html__( 'Link Skin', 'gracey-core' ),
					'options'    => array(
						''      => esc_html__( 'Default', 'gracey-core' ),
						'light' => esc_html__( 'Light', 'gracey-core' ),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'color',
					'name'       => 'background_color',
					'title'      => esc_html__( 'Background Color', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'link_target',
					'title'         => esc_html__( 'Link Target', 'gracey-core' ),
					'options'       => gracey_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Child elements', 'gracey-core' ),
					'items'      => array(
						array(
							'field_type'    => 'text',
							'name'          => 'item_link',
							'title'         => esc_html__( 'Link', 'gracey-core' ),
							'default_value' => '',
						),
						array(
							'field_type' => 'text',
							'name'       => 'item_number',
							'title'      => esc_html__( 'Number', 'gracey-core' ),
						),
                        array(
							'field_type' => 'text',
							'name'       => 'item_title',
							'title'      => esc_html__( 'Title', 'gracey-core' ),
						),
						array(
							'field_type' => 'image',
							'name'       => 'item_image',
							'title'      => esc_html__( 'Image', 'gracey-core' ),
							'multiple'   => 'yes',
						),
					),
				)
			);
			$this->map_extra_options();
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['holder_styles']  = $this->get_holder_styles( $atts );
			$atts['items']          = $this->parse_repeater_items( $atts['children'] );
			$atts['this_shortcode'] = $this;

			return gracey_core_get_template_part( 'shortcodes/interactive-link-showcase', 'variations/' . $atts['layout'] . '/templates/' . $atts['layout'], '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-interactive-link-showcase';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';
			$holder_classes[] = ! empty( $atts['skin'] ) ? 'qodef-skin--' . $atts['skin'] : '';

			return implode( ' ', $holder_classes );
		}

		private function get_holder_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['background_color'] ) ) {
				$styles[] = 'background-color: ' . $atts['background_color'];
			}

			return $styles;
		}

		public function get_image_styles( $atts ) {
			$styles = array();

			if ( ! empty( $atts['item_image'] ) ) {
				$styles[] = 'background-image: url(' . esc_url( wp_get_attachment_url( $atts['item_image'] ) ) . ')';
			}

			return $styles;
		}
	}
}
