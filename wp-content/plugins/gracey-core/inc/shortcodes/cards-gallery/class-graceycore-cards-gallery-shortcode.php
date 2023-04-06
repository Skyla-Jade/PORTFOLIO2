<?php

if ( ! function_exists( 'gracey_core_add_cards_gallery_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function gracey_core_add_cards_gallery_shortcode( $shortcodes ) {
		$shortcodes[] = 'GraceyCore_Cards_Gallery_Shortcode';

		return $shortcodes;
	}

	add_filter( 'gracey_core_filter_register_shortcodes', 'gracey_core_add_cards_gallery_shortcode' );
}

if ( class_exists( 'GraceyCore_Shortcode' ) ) {
	class GraceyCore_Cards_Gallery_Shortcode extends GraceyCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( GRACEY_CORE_SHORTCODES_URL_PATH . '/cards-gallery' );
			$this->set_base( 'gracey_core_cards_gallery' );
			$this->set_name( esc_html__( 'Cards Gallery', 'gracey-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds cards gallery holder', 'gracey-core' ) );
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
					'name'          => 'link_target',
					'title'         => esc_html__( 'Link Target', 'gracey-core' ),
					'options'       => gracey_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'orientation',
					'title'         => esc_html__( 'Info Position', 'gracey-core' ),
					'options'       => array(
						''      => esc_html__( 'Default', 'gracey-core' ),
						'right' => esc_html__( 'Shuffled Right', 'gracey-core' ),
						'left'  => esc_html__( 'Shuffled Left', 'gracey-core' ),
					),
					'default_value' => 'right',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'bundle_animation',
					'title'         => esc_html__( 'Bundle Animation', 'gracey-core' ),
					'options'       => gracey_core_get_select_type_options_pool( 'no_yes' ),
					'default_value' => 'no',
				)
			);
			$this->set_option(
				array(
					'field_type' => 'repeater',
					'name'       => 'children',
					'title'      => esc_html__( 'Image Items', 'gracey-core' ),
					'items'      => array(
						array(
							'field_type'    => 'text',
							'name'          => 'item_link',
							'title'         => esc_html__( 'Link', 'gracey-core' ),
							'default_value' => '',
						),
						array(
							'field_type' => 'image',
							'name'       => 'item_image',
							'title'      => esc_html__( 'Item Image', 'gracey-core' ),
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
			$atts['items']          = $this->parse_repeater_items( $atts['children'] );

			return gracey_core_get_template_part( 'shortcodes/cards-gallery', 'templates/cards-gallery', '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-cards-gallery';
			$holder_classes[] = ! empty( $atts['orientation'] ) ? 'qodef-orientation--' . $atts['orientation'] : 'qodef-orientation--right';
			$holder_classes[] = isset( $atts['bundle_animation'] ) && 'yes' === $atts['bundle_animation'] ? 'qodef-animation--bundle' : 'qodef-animation--no';

			if ( count($this->parse_repeater_items( $atts['children'] )) === 2 ) {
                $holder_classes[] = 'qodef-num-of-items--2';
            }

			return implode( ' ', $holder_classes );
		}
	}
}
