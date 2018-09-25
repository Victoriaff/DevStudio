<?php

class DEV_STUDIO_Component_WP_Actions extends DEV_STUDIO_Component {

	public $name = 'actions';
	public $title = 'Actions';

	public function __construct(  ) {
		parent::__construct(  );

		// Add Units
		$this->add_unit( new DEV_STUDIO_Unit_WP_Actions() );
		$this->add_unit( new DEV_STUDIO_Unit_WP_Actions_ABC() );

	}


}