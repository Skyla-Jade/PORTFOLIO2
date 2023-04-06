<?php

class GraceyCore_Side_Area_Mobile_Header extends GraceyCore_Mobile_Header {
	private static $instance;

	public function __construct() {
		$this->set_layout( 'side-area' );
		$this->default_header_height = 70;

		parent::__construct();
	}

	/**
	 * @return GraceyCore_Side_Area_Mobile_Header
	 */
	public static function get_instance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
