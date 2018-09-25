<?php

abstract class DEV_STUDIO_Component
{
	public $name;
	public $title;

    public $units = array();

    public function __construct() {

	    $this->set_title( $this->title );
    }

	public function set_title( $title ) {
		$this->title = function_exists( '__' ) ? __( $title, 'dev-studio' ) : $title;
	}

	public function add_unit( DEV_STUDIO_Unit $unit  ) {
		$this->units[ $unit->name ] = $unit;


	}

	public function units() {
		return $this->units;
	}



}