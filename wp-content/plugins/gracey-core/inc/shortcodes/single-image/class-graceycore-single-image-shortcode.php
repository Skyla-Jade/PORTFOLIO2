<?php

if ( ! function_exists( 'gracey_core_add_single_image_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param $shortcodes array
	 *
	 * @return array
	 */
	function gracey_core_add_single_image_shortcode( $shortcodes ) {
		$shortcodes[] = 'GraceyCore_Single_Image_Shortcode';

		return $shortcodes;
	}

	add_filter( 'gracey_core_filter_register_shortcodes', 'gracey_core_add_single_image_shortcode' );
}

if ( class_exists( 'GraceyCore_Shortcode' ) ) {
	class GraceyCore_Single_Image_Shortcode extends GraceyCore_Shortcode {

		public function __construct() {
			$this->set_layouts( apply_filters( 'gracey_core_filter_single_image_layouts', array() ) );
			$this->set_extra_options( apply_filters( 'gracey_core_filter_single_image_extra_options', array() ) );

			parent::__construct();
		}

		public function map_shortcode() {
			$this->set_shortcode_path( GRACEY_CORE_SHORTCODES_URL_PATH . '/single-image' );
			$this->set_base( 'gracey_core_single_image' );
			$this->set_name( esc_html__( 'Single Image', 'gracey-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds image element', 'gracey-core' ) );
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
					'field_type' => 'image',
					'name'       => 'image',
					'title'      => esc_html__( 'Image', 'gracey-core' ),
				)
			);

			$this->set_option(
				array(
					'field_type'  => 'text',
					'name'        => 'image_size',
					'title'       => esc_html__( 'Image Size', 'gracey-core' ),
					'description' => esc_html__( 'For predefined image sizes input thumbnail, medium, large or full. If you wish to set a custom image size, type in the desired image dimensions in pixels (e.g. 400x400).', 'gracey-core' ),
				)
			);

			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'image_action',
					'title'      => esc_html__( 'Image Action', 'gracey-core' ),
					'options'    => array(
						''            => esc_html__( 'No Action', 'gracey-core' ),
						'open-popup'  => esc_html__( 'Open Popup', 'gracey-core' ),
						'custom-link' => esc_html__( 'Custom Link', 'gracey-core' ),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'text',
					'name'       => 'link',
					'title'      => esc_html__( 'Custom Link', 'gracey-core' ),
					'dependency' => array(
						'show' => array(
							'image_action' => array(
								'values'        => array( 'custom-link' ),
								'default_value' => '',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type'    => 'select',
					'name'          => 'target',
					'title'         => esc_html__( 'Custom Link Target', 'gracey-core' ),
					'options'       => gracey_core_get_select_type_options_pool( 'link_target' ),
					'default_value' => '_self',
					'dependency'    => array(
						'show' => array(
							'image_action' => array(
								'values'        => 'custom-link',
								'default_value' => '',
							),
						),
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'full_width',
					'title'      => esc_html__( 'Full Width Layout', 'gracey-core' ),
					'description'=> esc_html__( 'Set Image Width To Width Of The Screen', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'no_yes', false),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'distort_animation',
					'title'      => esc_html__( 'Enable Distort Animation', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'no_yes', false),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'infinite_animation',
					'title'      => esc_html__( 'Enable Infinite Animation', 'gracey-core' ),
					'dependency'  => array(
						'show' => array(
							'distort_animation' => array(
								'values'        => 'yes',
								'default_value' => 'no'
							)
						)
					),
					'options'    => gracey_core_get_select_type_options_pool( 'no_yes', false),
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
						'5' => esc_html__( 'Effect 5', 'gracey-core' ),
					),
					'dependency'  => array(
						'show' => array(
							'distort_animation' => array(
								'values'        => 'yes',
								'default_value' => 'no'
							)
						)
					),
				)
			);
			$this->set_option(
				array(
					'field_type' => 'select',
					'name'       => 'animation_hide_overflow',
					'title'      => esc_html__( 'Hide Overflow For Distort Animation', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'no_yes', false),
					'dependency'  => array(
						'show' => array(
							'distort_animation' => array(
								'values'        => 'yes',
								'default_value' => 'no'
							)
						)
					),
				)
			);
			$this->map_extra_options();
		}
		
		public function load_assets() {
			$atts = $this->get_atts();
			
			if ($atts['distort_animation'] == 'yes' && $atts['distort_animation_effect'] == '5') {
				wp_register_script( 'pixi', GRACEY_CORE_INC_URL_PATH . '/shortcodes/single-image/assets/js/plugins/pixi.min.js', array ( 'jquery' ), false, true );
				wp_enqueue_script( 'pixi' );
			}
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'gracey_core_single_image', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['image_params']   = $this->generate_image_params( $atts );

			return gracey_core_get_template_part( 'shortcodes/single-image', 'variations/' . $atts['layout'] . '/templates/' . $atts['layout'], '', $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-single-image';
			$holder_classes[] = ! empty( $atts['layout'] ) ? 'qodef-layout--' . $atts['layout'] : '';
			$holder_classes[] = ! empty( $atts['image_action'] ) && 'open-popup' === $atts['image_action'] ? 'qodef-magnific-popup qodef-popup-gallery' : '';
			$holder_classes[] = ! empty( $atts['distort_animation'] ) && ( $atts['distort_animation'] ) == 'yes' ? 'qodef--distort-animation' : '';
			$holder_classes[] = ! empty( $atts['infinite_animation'] ) && ( $atts['infinite_animation'] ) == 'yes' ? 'qodef--infinite-animation' : '';
			$holder_classes[] = ! empty( $atts['distort_animation_effect'] )  ? 'qodef--distort-effect-' . $atts['distort_animation_effect'] : '';
			$holder_classes[] = ! empty( $atts['animation_hide_overflow'] ) && ( $atts['animation_hide_overflow'] ) == 'yes'  ? 'qodef--distort-hide-overflow' : '';
			$holder_classes[] = ! empty( $atts['full_width'] ) && ( $atts['full_width'] ) == 'yes'  ? 'qodef--full-width-image' : '';
			
			return implode( ' ', $holder_classes );
		}

		private function generate_image_params( $atts ) {
			$image = array();

			if ( ! empty( $atts['image'] ) ) {
				$id = $atts['image'];

				$image['image_id'] = intval( $id );
				$image_original    = wp_get_attachment_image_src( $id, 'full' );
				$image['url']      = $image_original[0];
				$image['alt']      = get_post_meta( $id, '_wp_attachment_image_alt', true );

				$image_size = trim( $atts['image_size'] );
				preg_match_all( '/\d+/', $image_size, $matches ); /* check if numeral width and height are entered */
				if ( in_array( $image_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ), true ) ) {
					$image['image_size'] = $image_size;
				} elseif ( ! empty( $matches[0] ) ) {
					$image['image_size'] = array(
						$matches[0][0],
						$matches[0][1],
					);
				} else {
					$image['image_size'] = 'full';
				}
			}

			return $image;
		}
	}
}
