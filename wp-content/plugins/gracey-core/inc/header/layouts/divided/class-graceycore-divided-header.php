<?php

class GraceyCore_Divided_Header extends GraceyCore_Header {
	private static $instance;

	public function __construct() {
		$this->set_layout( 'divided' );
		$this->set_search_layout( 'covers-header' );
		$this->default_header_height = 90;

		parent::__construct();
	}

	/**
	 * @return GraceyCore_Divided_Header
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
