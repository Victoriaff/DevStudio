<?php

class DEV_STUDIO_Component_WP_Overview extends DEV_STUDIO_Component {

	public $name = 'overview';
	public $title = 'Overview';

	public function __construct(  ) {
		parent::__construct(  );

		// Add Units
		$this->add_unit( new DEV_STUDIO_Unit_WP_Overview() );
		$this->add_unit( new DEV_STUDIO_Unit_WP_Overview_Conditionals() );
	}


}