<?php

abstract class DEV_STUDIO_Module {

	public $name;
	public $title;

	public $components = array();

	public function __construct( ) {

		$this->set_title( $this->title );

	}

	public function set_title( $title ) {
		$this->title = function_exists( '__' ) ? __( $title, 'dev-studio' ) : $title;
	}

	public function components_units( $dir ) {
		foreach (glob($dir . '/*', GLOB_ONLYDIR) as $dir) {
			//$component = basename( $dir );
			foreach ( glob( $dir . '/*.php' ) as $file ) {
				require_once $file;
			}
		}
	}

	public function add_component( DEV_STUDIO_Component $component  ) {
		$this->components[ $component->name ] = $component;


	}

	public function components() {
		return $this->components;
	}

}