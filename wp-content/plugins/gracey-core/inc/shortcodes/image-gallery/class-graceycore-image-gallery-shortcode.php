<?php

if ( ! function_exists( 'gracey_core_add_image_gallery_shortcode' ) ) {
	/**
	 * Function that add shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes
	 *
	 * @return array
	 */
	function gracey_core_add_image_gallery_shortcode( $shortcodes ) {
		$shortcodes[] = 'GraceyCore_Image_Gallery_Shortcode';

		return $shortcodes;
	}

	add_filter( 'gracey_core_filter_register_shortcodes', 'gracey_core_add_image_gallery_shortcode' );
}

if ( class_exists( 'GraceyCore_List_Shortcode' ) ) {
	class GraceyCore_Image_Gallery_Shortcode extends GraceyCore_List_Shortcode {

		public function map_shortcode() {
			$this->set_shortcode_path( GRACEY_CORE_SHORTCODES_URL_PATH . '/image-gallery' );
			$this->set_base( 'gracey_core_image_gallery' );
			$this->set_name( esc_html__( 'Image Gallery', 'gracey-core' ) );
			$this->set_description( esc_html__( 'Shortcode that adds image gallery element', 'gracey-core' ) );
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
					'field_type' => 'image',
					'name'       => 'images',
					'multiple'   => 'yes',
					'title'      => esc_html__( 'Images', 'gracey-core' ),
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
                    'field_type'  => 'select',
                    'name'        => 'enable_shadow',
                    'title'       => esc_html__( 'Enable Shadow', 'emeritus-core' ),
                    'options'     =>  gracey_core_get_select_type_options_pool('no_yes')
                )
            );
			$this->map_list_options(
				array(
					'exclude_behavior' => array( 'justified-gallery' ),
					'exclude_option'   => array( 'images_proportion' ),
					'group'            => esc_html__( 'Gallery Settings', 'gracey-core' ),
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
                    'default_value' => '',
                    'group'            => esc_html__( 'Gallery Settings', 'gracey-core' ),
                )
            );
		}

		public static function call_shortcode( $params ) {
			$html = qode_framework_call_shortcode( 'gracey_core_image_gallery', $params );
			$html = str_replace( "\n", '', $html );

			return $html;
		}

		public function render( $options, $content = null ) {
			parent::render( $options );
			$atts = $this->get_atts();

			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['item_classes']   = $this->get_item_classes( $atts );
			$atts['slider_attr']    = $this->get_slider_data( $atts );
			$atts['images']         = $this->generate_images_params( $atts );

			return gracey_core_get_template_part( 'shortcodes/image-gallery', 'templates/image-gallery', $atts['behavior'], $atts );
		}

		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();

			$holder_classes[] = 'qodef-image-gallery';
			$holder_classes[] = ! empty( $atts['image_action'] ) && 'open-popup' === $atts['image_action'] ? 'qodef-magnific-popup qodef-popup-gallery' : '';
            $holder_classes[] = ! empty( $atts['slider_navigation_position'] ) && $atts['slider_navigation_position'] === 'below_slider' ? 'qodef-navigation--below' : '';
            $holder_classes[] = ! empty( $atts['enable_shadow'] ) && $atts['enable_shadow'] === 'yes' ? 'qodef-image-shadow' : '';

			$list_classes   = $this->get_list_classes( $atts );
			$holder_classes = array_merge( $holder_classes, $list_classes );
            if ( isset( $atts['slider_width'] ) && $atts['slider_width'] === 'yes') {
                $holder_classes[] = 'qodef-auto-width-slider';
            }

			return implode( ' ', $holder_classes );
		}

		public function get_item_classes( $atts ) {
			$item_classes   = $this->init_item_classes();
			$item_classes[] = 'qodef-image-wrapper';

			$list_item_classes = $this->get_list_item_classes( $atts );

			$item_classes = array_merge( $item_classes, $list_item_classes );

			return implode( ' ', $item_classes );
		}

		private function generate_images_params( $atts ) {
			$image_ids = array();
			$images    = array();
			$i         = 0;

			if ( '' !== $atts['images'] ) {
				$image_ids = explode( ',', $atts['images'] );
			}

			$image_size = $this->generate_image_size( $atts );

			foreach ( $image_ids as $id ) {

				$image['image_id']   = intval( $id );
				$image_original      = wp_get_attachment_image_src( $id, 'full' );
				$image['url']        = $this->generate_image_url( $id, $atts, $image_original[0] );
				$image['alt']        = get_post_meta( $id, '_wp_attachment_image_alt', true );
				$image['image_size'] = $image_size;

				$images[ $i ] = $image;
				$i ++;
			}

			return $images;
		}

		private function generate_image_size( $atts ) {
			$image_size = trim( $atts['image_size'] );
			preg_match_all( '/\d+/', $image_size, $matches ); /* check if numeral width and height are entered */
			if ( in_array( $image_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ), true ) ) {
				return $image_size;
			} elseif ( ! empty( $matches[0] ) ) {
				return array(
					$matches[0][0],
					$matches[0][1],
				);
			} else {
				return 'full';
			}
		}

		private function generate_image_url( $id, $atts, $default ) {
			if ( 'custom-link' === $atts['image_action'] ) {
				$url = get_post_meta( $id, 'qodef_image_gallery_custom_link', true );
				if ( empty( $url ) ) {
					$url = $default;
				}
			} else {
				$url = $default;
			}

			return $url;
		}
	}
}
