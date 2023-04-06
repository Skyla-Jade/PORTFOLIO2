<?php

class GraceyCore_Centered_Header extends GraceyCore_Header {
	private static $instance;

	public function __construct() {
		$this->set_layout( 'centered' );
		$this->default_header_height = 150;

		parent::__construct();
	}

	/**
	 * @return GraceyCore_Centered_Header
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
