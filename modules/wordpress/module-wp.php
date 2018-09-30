<?php

class DEV_STUDIO_Module_WP extends DEV_STUDIO_Module {

	public $name = 'wordpress';
	public $title = 'WordPress';

	public function __construct() {

		parent::__construct();

		$this->components_units( DevStudio()->dir('modules') . $this->name );

		// Add Components
		$this->add_component( new DEV_STUDIO_Component_WP_Overview() );
		$this->add_component( new DEV_STUDIO_Component_WP_Actions() );

		//dump( $this->components() );

	}

}