<?php

class GraceyCore_Breadcrumbs_Title extends GraceyCore_Title {
	private static $instance;

	public function __construct() {
		$this->slug = 'breadcrumbs';
	}

	/**
	 * @return GraceyCore_Breadcrumbs_Title
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
