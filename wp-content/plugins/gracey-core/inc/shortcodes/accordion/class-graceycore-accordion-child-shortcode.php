<?php

if ( ! function_exists( 'gracey_core_add_accordion_child_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function gracey_core_add_accordion_child_shortcode( $shortcodes ) {
		$shortcodes[] = 'GraceyCore_Accordion_Child_Shortcode';

		return $shortcodes;
	}

	add_filter( 'gracey_core_filter_register_shortcodes', 'gracey_core_add_accordion_child_shortcode' );
}

if ( class_exists( 'GraceyCore_Shortcode' ) ) {
	class GraceyCore_Accordion_Child_Shortcode extends GraceyCore_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( GRACEY_CORE_SHORTCODES_URL_PATH . '/accordion' );
			$this->set_base( 'gracey_core_accordion_child' );
			$this->set_name( esc_html__( 'Accordion Child', 'gracey-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds accordion child to accordion holder', 'gracey-core' ) );
			$this->set_category( esc_html__( 'Gracey Core', 'gracey-core' ) );
			$this->set_is_child_shortcode( true );
			$this->set_parent_elements(
				array(
					'gracey_core_accordion',
				)
			);
			$this->set_is_parent_shortcode( true );
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'title',
					'title'      => esc_html__( 'Title', 'gracey-core' ),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'title_tag',
					'title'         => esc_html__( 'Title Tag', 'gracey-core' ),
					'options'       => gracey_core_get_select_type_options_pool( 'title_tag' ),
					'default_value' => 'h3',
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'text',
					'name'          => 'layout',
					'title'         => esc_html__( 'Layout', 'gracey-core' ),
					'default_value' => '',
					'visibility'    => array( 'map_for_page_builder' => false ),
				)
			);
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts            = $this->get_atts();
			$atts['content'] = $content;

			return gracey_core_get_template_part( 'shortcodes/accordion', 'variations/' . $atts['layout'] . '/templates/child', '', $atts );
		}
	}
}
