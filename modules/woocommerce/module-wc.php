<?php

class DEV_STUDIO_Module_WC extends DEV_STUDIO_Module {

	public $name = 'woocommerce';
	public $title = 'WooCommerce';

	public function __construct() {

		parent::__construct();

		$this->components_units( DevStudio()->dir('modules') . $this->name );

		// Add Components
		$this->add_component( new DEV_STUDIO_Component_WC_Overview() );

		//dump( $this->components() );

	}

}