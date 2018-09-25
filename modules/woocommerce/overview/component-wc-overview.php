<?php

class DEV_STUDIO_Component_WC_Overview extends DEV_STUDIO_Component {

	public $name = 'overview';
	public $title = 'Overview';

	public function __construct(  ) {
		parent::__construct(  );

		// Add Units
		$this->add_unit( new DEV_STUDIO_Unit_WC_Overview() );
	}


}