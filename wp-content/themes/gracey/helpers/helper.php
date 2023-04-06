<?php

if ( ! function_exists( 'gracey_is_installed' ) ) {
	/**
	 * Function that checks if forward plugin installed
	 *
	 * @param string $plugin - plugin name
	 *
	 * @return bool
	 */
	function gracey_is_installed( $plugin ) {

		switch ( $plugin ) {
			case 'framework':
				return class_exists( 'QodeFramework' );
				break;
			case 'core':
				return class_exists( 'GraceyCore' );
				break;
			case 'woocommerce':
				return class_exists( 'WooCommerce' );
				break;
			case 'gutenberg-page':
				$current_screen = function_exists( 'get_current_screen' ) ? get_current_screen() : array();

				return method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor();
				break;
			case 'gutenberg-editor':
				return class_exists( 'WP_Block_Type' );
				break;
			default:
				return false;
		}
	}
}

if ( ! function_exists( 'gracey_include_theme_is_installed' ) ) {
	/**
	 * Function that set case is installed element for framework functionality
	 *
	 * @param bool $installed
	 * @param string $plugin - plugin name
	 *
	 * @return bool
	 */
	function gracey_include_theme_is_installed( $installed, $plugin ) {

		if ( 'theme' === $plugin ) {
			return class_exists( 'Gracey_Handler' );
		}

		return $installed;
	}

	add_filter( 'qode_framework_filter_is_plugin_installed', 'gracey_include_theme_is_installed', 10, 2 );
}

if ( ! function_exists( 'gracey_template_part' ) ) {
	/**
	 * Function that echo module template part.
	 *
	 * @param string $module name of the module from inc folder
	 * @param string $template full path of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 */
	function gracey_template_part( $module, $template, $slug = '', $params = array() ) {
		echo gracey_get_template_part( $module, $template, $slug, $params ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'gracey_get_template_part' ) ) {
	/**
	 * Function that load module template part.
	 *
	 * @param string $module name of the module from inc folder
	 * @param string $template full path of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @return string - string containing html of template
	 */
	function gracey_get_template_part( $module, $template, $slug = '', $params = array() ) {
		//HTML Content from template
		$html          = '';
		$template_path = GRACEY_INC_ROOT_DIR . '/' . $module;

		$temp = $template_path . '/' . $template;
		if ( is_array( $params ) && count( $params ) ) {
			extract( $params ); // @codingStandardsIgnoreLine
		}

		$template = '';

		if ( ! empty( $temp ) ) {
			if ( ! empty( $slug ) ) {
				$template = "{$temp}-{$slug}.php";

				if ( ! file_exists( $template ) ) {
					$template = $temp . '.php';
				}
			} else {
				$template = $temp . '.php';
			}
		}

		if ( $template ) {
			ob_start();
			include( $template ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
			$html = ob_get_clean();
		}

		return $html;
	}
}

if ( ! function_exists( 'gracey_get_page_id' ) ) {
	/**
	 * Function that returns current page id
	 * Additional conditional is to check if current page is any wp archive page (archive, category, tag, date etc.) and returns -1
	 *
	 * @return int
	 */
	function gracey_get_page_id() {
		$page_id = get_queried_object_id();

		if ( gracey_is_wp_template() ) {
			$page_id = - 1;
		}

		return apply_filters( 'gracey_filter_page_id', $page_id );
	}
}

if ( ! function_exists( 'gracey_is_wp_template' ) ) {
	/**
	 * Function that checks if current page default wp page
	 *
	 * @return bool
	 */
	function gracey_is_wp_template() {
		return is_archive() || is_search() || is_404() || ( is_front_page() && is_home() );
	}
}

if ( ! function_exists( 'gracey_get_ajax_status' ) ) {
	/**
	 * Function that return status from ajax functions
	 *
	 * @param string $status - success or error
	 * @param string $message - ajax message value
	 * @param string|array $data - returned value
	 * @param string $redirect - url address
	 */
	function gracey_get_ajax_status( $status, $message, $data = null, $redirect = '' ) {
		$response = array(
			'status'   => esc_attr( $status ),
			'message'  => esc_html( $message ),
			'data'     => $data,
			'redirect' => ! empty( $redirect ) ? esc_url( $redirect ) : '',
		);

		$output = json_encode( $response );

		exit( $output ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'gracey_get_button_element' ) ) {
	/**
	 * Function that returns button with provided params
	 *
	 * @param array $params - array of parameters
	 *
	 * @return string - string representing button html
	 */
	function gracey_get_button_element( $params ) {
		if ( class_exists( 'GraceyCore_Button_Shortcode' ) ) {
			return GraceyCore_Button_Shortcode::call_shortcode( $params );
		} else {
			$link   = isset( $params['link'] ) ? $params['link'] : '#';
			$target = isset( $params['target'] ) ? $params['target'] : '_self';
			$text   = isset( $params['text'] ) ? $params['text'] : '';
            $additional_class = isset( $params['button_layout'] ) ? 'qodef-layout--'.$params['button_layout'] : '';

            $button_html = '<a itemprop="url" class="qodef-theme-button ' . esc_attr( $additional_class ) . '" href="' . esc_url( $link ) . '" target="' . esc_attr( $target ) . '">';
            $button_html .= '<span class="qodef-m-text">' . esc_html( $text ) . '</span>';
            $button_html .= '<span class="qodef-btn-icon">' . gracey_get_svg_icon( 'button-arrow' ) . '</span></a>';

            return $button_html;
		}
	}
}

if ( ! function_exists( 'gracey_render_button_element' ) ) {
	/**
	 * Function that render button with provided params
	 *
	 * @param array $params - array of parameters
	 */
	function gracey_render_button_element( $params ) {
		echo gracey_get_button_element( $params ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'gracey_class_attribute' ) ) {
	/**
	 * Function that render class attribute
	 *
	 * @param string|array $class
	 */
	function gracey_class_attribute( $class ) {
		echo gracey_get_class_attribute( $class ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'gracey_get_class_attribute' ) ) {
	/**
	 * Function that return class attribute
	 *
	 * @param string|array $class
	 *
	 * @return string|mixed
	 */
	function gracey_get_class_attribute( $class ) {
		$value = gracey_is_installed( 'framework' ) ? qode_framework_get_class_attribute( $class ) : '';

		return $value;
	}
}

if ( ! function_exists( 'gracey_get_post_value_through_levels' ) ) {
	/**
	 * Function that returns meta value if exists
	 *
	 * @param string $name name of option
	 * @param int $post_id id of
	 *
	 * @return string value of option
	 */
	function gracey_get_post_value_through_levels( $name, $post_id = null ) {
		return gracey_is_installed( 'framework' ) && gracey_is_installed( 'core' ) ? gracey_core_get_post_value_through_levels( $name, $post_id ) : '';
	}
}

if ( ! function_exists( 'gracey_get_space_value' ) ) {
	/**
	 * Function that returns spacing value based on selected option
	 *
	 * @param string $text_value - textual value of spacing
	 *
	 * @return int
	 */
	function gracey_get_space_value( $text_value ) {
		return gracey_is_installed( 'core' ) ? gracey_core_get_space_value( $text_value ) : 0;
	}
}

if ( ! function_exists( 'gracey_wp_kses_html' ) ) {
	/**
	 * Function that does escaping of specific html.
	 * It uses wp_kses function with predefined attributes array.
	 *
	 * @param string $type - type of html element
	 * @param string $content - string to escape
	 *
	 * @return string escaped output
	 * @see wp_kses()
	 *
	 */
	function gracey_wp_kses_html( $type, $content ) {
		return gracey_is_installed( 'framework' ) ? qode_framework_wp_kses_html( $type, $content ) : $content;
	}
}

if ( ! function_exists( 'gracey_render_svg_icon' ) ) {
	/**
	 * Function that print svg html icon
	 *
	 * @param string $name - icon name
	 * @param string $class_name - custom html tag class name
	 */
	function gracey_render_svg_icon( $name, $class_name = '' ) {
		echo gracey_get_svg_icon( $name, $class_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'gracey_get_svg_icon' ) ) {
	/**
	 * Returns svg html
	 *
	 * @param string $name - icon name
	 * @param string $class_name - custom html tag class name
	 *
	 * @return string|html
	 */
	function gracey_get_svg_icon( $name, $class_name = '' ) {
		$html  = '';
		$class = isset( $class_name ) && ! empty( $class_name ) ? 'class="' . esc_attr( $class_name ) . '"' : '';

		switch ( $name ) {
			case 'menu':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve"><line x1="12" y1="21" x2="52" y2="21"/><line x1="12" y1="33" x2="52" y2="33"/><line x1="12" y1="45" x2="52" y2="45"/></svg>';
				break;
			case 'search':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 20 20"><path d="M18.869 19.162l-5.943-6.484c1.339-1.401 2.075-3.233 2.075-5.178 0-2.003-0.78-3.887-2.197-5.303s-3.3-2.197-5.303-2.197-3.887 0.78-5.303 2.197-2.197 3.3-2.197 5.303 0.78 3.887 2.197 5.303 3.3 2.197 5.303 2.197c1.726 0 3.362-0.579 4.688-1.645l5.943 6.483c0.099 0.108 0.233 0.162 0.369 0.162 0.121 0 0.242-0.043 0.338-0.131 0.204-0.187 0.217-0.503 0.031-0.706zM1 7.5c0-3.584 2.916-6.5 6.5-6.5s6.5 2.916 6.5 6.5-2.916 6.5-6.5 6.5-6.5-2.916-6.5-6.5z"></path></svg>';
				break;
			case 'star':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path xmlns="http://www.w3.org/2000/svg" d="M480 208H308L256 48l-52 160H32l140 96-54 160 138-100 138 100-54-160z" stroke-linejoin="round" stroke-width="32"/></svg>';
				break;
			case 'menu-arrow-right':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><g><path d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z"></path></g></svg>';
				break;
			case 'slider-arrow-left':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28" height="18" viewBox="0 0 28 18" xml:space="preserve"><path d="M0.4,8.5c5.5,0,9.5-8.1,9.5-8.2C10.1,0,10.3,0,10.5,0.1c0.2,0.1,0.3,0.4,0.1,0.7c-0.1,0.3-2.7,5.5-6.7,7.7h23.7C27.8,8.5,28,8.7,28,9c0,0.3-0.2,0.5-0.4,0.5H3.9c4,2.2,6.6,7.4,6.7,7.7c0.1,0.2,0,0.5-0.1,0.7c-0.2,0.1-0.4,0.1-0.6-0.2c0-0.1-4.1-8.2-9.5-8.2C0.2,9.5,0,9.3,0,9C0,8.7,0.2,8.5,0.4,8.5z"/><path d="M0.4,8.5c5.5,0,9.5-8.1,9.5-8.2C10.1,0,10.3,0,10.5,0.1c0.2,0.1,0.3,0.4,0.1,0.7c-0.1,0.3-2.7,5.5-6.7,7.7h23.7C27.8,8.5,28,8.7,28,9c0,0.3-0.2,0.5-0.4,0.5H3.9c4,2.2,6.6,7.4,6.7,7.7c0.1,0.2,0,0.5-0.1,0.7c-0.2,0.1-0.4,0.1-0.6-0.2c0-0.1-4.1-8.2-9.5-8.2C0.2,9.5,0,9.3,0,9C0,8.7,0.2,8.5,0.4,8.5z"/></svg>';
				break;
			case 'slider-arrow-right':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28" height="18" viewBox="0 0 28 18"  xml:space="preserve"><path d="M27.6,8.5c-5.5,0-9.5-8.1-9.5-8.2C17.9,0,17.7,0,17.5,0.1c-0.2,0.1-0.3,0.4-0.1,0.7c0.1,0.3,2.7,5.5,6.7,7.7H0.4C0.2,8.5,0,8.7,0,9c0,0.3,0.2,0.5,0.4,0.5h23.7c-4,2.2-6.6,7.4-6.7,7.7c-0.1,0.2,0,0.5,0.1,0.7c0.2,0.1,0.4,0.1,0.6-0.2c0-0.1,4.1-8.2,9.5-8.2C27.8,9.5,28,9.3,28,9C28,8.7,27.8,8.5,27.6,8.5z"/><path d="M27.6,8.5c-5.5,0-9.5-8.1-9.5-8.2C17.9,0,17.7,0,17.5,0.1c-0.2,0.1-0.3,0.4-0.1,0.7c0.1,0.3,2.7,5.5,6.7,7.7H0.4C0.2,8.5,0,8.7,0,9c0,0.3,0.2,0.5,0.4,0.5h23.7c-4,2.2-6.6,7.4-6.7,7.7c-0.1,0.2,0,0.5,0.1,0.7c0.2,0.1,0.4,0.1,0.6-0.2c0-0.1,4.1-8.2,9.5-8.2C27.8,9.5,28,9.3,28,9C28,8.7,27.8,8.5,27.6,8.5z"/></svg>';
				break;
			case 'pagination-arrow-left':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28" height="18" viewBox="0 0 28 18" xml:space="preserve"><path d="M0.4,8.5c5.5,0,9.5-8.1,9.5-8.2C10.1,0,10.3,0,10.5,0.1c0.2,0.1,0.3,0.4,0.1,0.7c-0.1,0.3-2.7,5.5-6.7,7.7h23.7C27.8,8.5,28,8.7,28,9c0,0.3-0.2,0.5-0.4,0.5H3.9c4,2.2,6.6,7.4,6.7,7.7c0.1,0.2,0,0.5-0.1,0.7c-0.2,0.1-0.4,0.1-0.6-0.2c0-0.1-4.1-8.2-9.5-8.2C0.2,9.5,0,9.3,0,9C0,8.7,0.2,8.5,0.4,8.5z"/><path d="M0.4,8.5c5.5,0,9.5-8.1,9.5-8.2C10.1,0,10.3,0,10.5,0.1c0.2,0.1,0.3,0.4,0.1,0.7c-0.1,0.3-2.7,5.5-6.7,7.7h23.7C27.8,8.5,28,8.7,28,9c0,0.3-0.2,0.5-0.4,0.5H3.9c4,2.2,6.6,7.4,6.7,7.7c0.1,0.2,0,0.5-0.1,0.7c-0.2,0.1-0.4,0.1-0.6-0.2c0-0.1-4.1-8.2-9.5-8.2C0.2,9.5,0,9.3,0,9C0,8.7,0.2,8.5,0.4,8.5z"/></svg>';
				break;
			case 'pagination-arrow-right':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28" height="18" viewBox="0 0 28 18"  xml:space="preserve"><path d="M27.6,8.5c-5.5,0-9.5-8.1-9.5-8.2C17.9,0,17.7,0,17.5,0.1c-0.2,0.1-0.3,0.4-0.1,0.7c0.1,0.3,2.7,5.5,6.7,7.7H0.4C0.2,8.5,0,8.7,0,9c0,0.3,0.2,0.5,0.4,0.5h23.7c-4,2.2-6.6,7.4-6.7,7.7c-0.1,0.2,0,0.5,0.1,0.7c0.2,0.1,0.4,0.1,0.6-0.2c0-0.1,4.1-8.2,9.5-8.2C27.8,9.5,28,9.3,28,9C28,8.7,27.8,8.5,27.6,8.5z"/><path d="M27.6,8.5c-5.5,0-9.5-8.1-9.5-8.2C17.9,0,17.7,0,17.5,0.1c-0.2,0.1-0.3,0.4-0.1,0.7c0.1,0.3,2.7,5.5,6.7,7.7H0.4C0.2,8.5,0,8.7,0,9c0,0.3,0.2,0.5,0.4,0.5h23.7c-4,2.2-6.6,7.4-6.7,7.7c-0.1,0.2,0,0.5,0.1,0.7c0.2,0.1,0.4,0.1,0.6-0.2c0-0.1,4.1-8.2,9.5-8.2C27.8,9.5,28,9.3,28,9C28,8.7,27.8,8.5,27.6,8.5z"/></svg>';
				break;
			case 'close':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><g><path d="M 10.050,23.95c 0.39,0.39, 1.024,0.39, 1.414,0L 17,18.414l 5.536,5.536c 0.39,0.39, 1.024,0.39, 1.414,0 c 0.39-0.39, 0.39-1.024,0-1.414L 18.414,17l 5.536-5.536c 0.39-0.39, 0.39-1.024,0-1.414c-0.39-0.39-1.024-0.39-1.414,0 L 17,15.586L 11.464,10.050c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 15.586,17l-5.536,5.536 C 9.66,22.926, 9.66,23.56, 10.050,23.95z"></path></g></svg>';
				break;
//			case 'spinner':
//				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512"><path d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z"></path></svg>';
//				break;
			case 'spinner':
				$html = '<svg ' . $class . ' width="46" x="0px" y="0px" viewBox="0 0 46 46" style="enable-background:new 0 0 46 46;" xml:space="preserve"><path d="M0.9,22.9h14.8c3.9,0,7.1-3.2,7.1-7.1v-15h0.6v15c0,3.9,3.2,7.1,7.1,7.1h15v0.6h-15c-3.9,0-7.1,3.2-7.1,7.1v15h-0.6v-15 c0-3.9-3.2-7.1-7.1-7.1H0.9V22.9z"/></svg>';
				break;
			case 'link':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 265 134" style="enable-background:new 0 0 265 134;" xml:space="preserve"><g><path stroke-miterlimit="10" d="M182.2,34.7c2.7,6.7,4,13.9,4,21.6v21.6h-32.3V56.2c0-6.3-2-11.5-6.1-15.5s-9.2-6.1-15.5-6.1H56.9 c-6.3,0-11.5,2-15.5,6.1s-6.1,9.2-6.1,15.5v21.6c0,6.3,2,11.5,6.1,15.5s9.2,6.1,15.5,6.1h10.8c1.3,6.3,3.8,12.1,7.4,17.5 c3.6,5.4,7,9.2,10.1,11.5l4,3.4H56.9c-14.8,0-27.5-5.3-38.1-15.8C8.3,105.3,3,92.6,3,77.8V56.2c0-14.8,5.3-27.5,15.8-38.1 C29.4,7.6,42.1,2.3,56.9,2.3h75.5c10.8,0,20.8,3,30,9.1C171.6,17.5,178.2,25.2,182.2,34.7z M207.8,2.3c14.8,0,27.5,5.3,38.1,15.8 c10.5,10.6,15.8,23.2,15.8,38.1v21.6c0,14.8-5.3,27.5-15.8,38.1c-10.6,10.6-23.2,15.8-38.1,15.8h-75.5c-22.9,0-39.3-10.8-49.2-32.3 c-3.1-7.6-4.7-14.8-4.7-21.6V56.2h32.3v21.6c0,6.3,2,11.5,6.1,15.5s9.2,6.1,15.5,6.1h75.5c6.3,0,11.5-2,15.5-6.1s6.1-9.2,6.1-15.5 V56.2c0-6.3-2-11.5-6.1-15.5s-9.2-6.1-15.5-6.1h-10.8c-1.3-6.3-3.8-12.1-7.4-17.5c-3.6-5.4-7-9.2-10.1-11.5l-4-3.4H207.8z"/></g></svg>';
				break;
            case 'quote':
				$html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 188 123" style="enable-background:new 0 0 188 123;" xml:space="preserve"><g><path stroke-miterlimit="10" d="M43.2,121.9c-6,0-11.4-1-16.4-2.9c-5-1.9-9.3-4.7-12.9-8.3c-3.6-3.6-6.4-8.1-8.4-13.2c-2-5.2-3-11-3-17.5 c0-14.7,5-28.8,15.1-42.2C27.5,24.3,42.2,12.4,61.4,2l18.5,26.4c-5.1,2.7-9.5,5.3-13.4,7.9c-3.9,2.6-7.2,5.2-10.1,7.9 c-2.9,2.7-5.3,5.5-7.4,8.3c-2.1,2.9-4,5.9-5.6,9.2c5.5,0,10.5,0.8,14.9,2.4c4.4,1.6,8.3,3.7,11.5,6.5c3.2,2.8,5.7,6,7.4,9.6 c1.7,3.7,2.6,7.6,2.6,11.7c0,4.2-0.9,8.1-2.6,11.7c-1.7,3.7-4.2,6.8-7.4,9.5s-7,4.8-11.5,6.4C53.7,121.1,48.7,121.9,43.2,121.9z M148,121.9c-6,0-11.4-1-16.4-2.9c-5-1.9-9.3-4.7-12.9-8.3c-3.6-3.6-6.4-8.1-8.4-13.2c-2-5.2-3-11-3-17.5c0-14.7,5-28.8,15.1-42.2 c10-13.4,24.7-25.4,43.9-35.8l18.5,26.4c-5.1,2.7-9.5,5.3-13.4,7.9c-3.9,2.6-7.2,5.2-10.1,7.9c-2.9,2.7-5.3,5.5-7.4,8.3 c-2.1,2.9-4,5.9-5.6,9.2c5.5,0,10.5,0.8,14.9,2.4c4.4,1.6,8.3,3.7,11.5,6.5c3.2,2.8,5.7,6,7.4,9.6c1.7,3.7,2.6,7.6,2.6,11.7 c0,4.2-0.9,8.1-2.6,11.7c-1.7,3.7-4.2,6.8-7.4,9.5c-3.2,2.7-7,4.8-11.5,6.4C158.5,121.1,153.5,121.9,148,121.9z"/></g></svg>';
				break;
            case 'play':
                $html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 145 139" style="enable-background:new 0 0 145 139;" xml:space="preserve"><path class="st0" d="M24.5,3.7l115.6,66.8L24.5,137.3V3.7 M23.5,2v137l118.6-68.5L23.5,2L23.5,2z"/><g><polygon points="123.6,70.5 5,2 5,139"/></g></svg>';
                break;
            case 'button-arrow':
//                $html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28" height="18" viewBox="0 0 31 21" style="enable-background:new 0 0 31 21;" xml:space="preserve"><path stroke-miterlimit="10" d="M29.9,11.3c-5.8,0-10,8.2-10.1,8.3c-0.1,0.2-0.4,0.3-0.6,0.2c-0.2-0.1-0.3-0.4-0.2-0.7c0.1-0.3,2.9-5.5,7.1-7.8 h-25c-0.2,0-0.4-0.2-0.4-0.5c0-0.3,0.2-0.5,0.4-0.5h25c-4.2-2.2-6.9-7.5-7.1-7.8C18.9,2.3,19,2,19.2,1.9c0.2-0.1,0.5-0.1,0.6,0.2 c0,0.1,4.3,8.3,10.1,8.3c0.2,0,0.4,0.2,0.4,0.5C30.3,11.1,30.1,11.3,29.9,11.3z"/><path stroke-miterlimit="10" d="M29.9,11.3c-5.8,0-10,8.2-10.1,8.3c-0.1,0.2-0.4,0.3-0.6,0.2c-0.2-0.1-0.3-0.4-0.2-0.7c0.1-0.3,2.9-5.5,7.1-7.8 h-25c-0.2,0-0.4-0.2-0.4-0.5c0-0.3,0.2-0.5,0.4-0.5h25c-4.2-2.2-6.9-7.5-7.1-7.8C18.9,2.3,19,2,19.2,1.9c0.2-0.1,0.5-0.1,0.6,0.2 c0,0.1,4.3,8.3,10.1,8.3c0.2,0,0.4,0.2,0.4,0.5C30.3,11.1,30.1,11.3,29.9,11.3z"/></svg>';
	            $html = '<svg ' . $class . ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28" height="18" viewBox="0 0 28 18"  xml:space="preserve"><path d="M27.6,8.5c-5.5,0-9.5-8.1-9.5-8.2C17.9,0,17.7,0,17.5,0.1c-0.2,0.1-0.3,0.4-0.1,0.7c0.1,0.3,2.7,5.5,6.7,7.7H0.4C0.2,8.5,0,8.7,0,9c0,0.3,0.2,0.5,0.4,0.5h23.7c-4,2.2-6.6,7.4-6.7,7.7c-0.1,0.2,0,0.5,0.1,0.7c0.2,0.1,0.4,0.1,0.6-0.2c0-0.1,4.1-8.2,9.5-8.2C27.8,9.5,28,9.3,28,9C28,8.7,27.8,8.5,27.6,8.5z"/><path d="M27.6,8.5c-5.5,0-9.5-8.1-9.5-8.2C17.9,0,17.7,0,17.5,0.1c-0.2,0.1-0.3,0.4-0.1,0.7c0.1,0.3,2.7,5.5,6.7,7.7H0.4C0.2,8.5,0,8.7,0,9c0,0.3,0.2,0.5,0.4,0.5h23.7c-4,2.2-6.6,7.4-6.7,7.7c-0.1,0.2,0,0.5,0.1,0.7c0.2,0.1,0.4,0.1,0.6-0.2c0-0.1,4.1-8.2,9.5-8.2C27.8,9.5,28,9.3,28,9C28,8.7,27.8,8.5,27.6,8.5z"/></svg>';
	            break;
		}

		return apply_filters( 'gracey_filter_svg_icon', $html );
	}
}
