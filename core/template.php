<?php

class DEV_STUDIO_Template {



	public function __construct() {
	}


	public function load( $tmpl_name, $data = array() ) {

		$fname = DevStudio()->dir('templates') . $tmpl_name.'.php';
		if (!file_exists($fname)) return;

		ob_start();
		require( $fname );
		return ob_get_clean();
	}


}