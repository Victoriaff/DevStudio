<?php

class DEV_STUDIO_Checkpoint {

	public $checkpoints = array();
	public $checkpoint;
	public $checkpoint_dir;
	public $checkpoint_mode_dir;
	public $default_options = array(
		'units' => array(
			'wordpress.overview.overview',
			'wordpress.overview.conditionals',

			'wordpress.actions.actions',
			'wordpress.actions.actions_abc'
		)
	);

	public function __construct() {
	}

	public function add( $checkpoint ) {

		if ( DevStudio()->mode == 'public' || DevStudio()->mode == 'ajax_public' ) {
			$hooks = DevStudio()->data['hooks']['public'];
		} else {
			$hooks = DevStudio()->data['hooks']['admin'];
		}

		$this->checkpoints[ $checkpoint ] = array(
			'options' => $this->default_options,
			'hook'    => in_array( $checkpoint, $hooks ) ? true : false
		);

		if ( ! DevStudio()->me() ) {
			add_action( $checkpoint, array( $this, 'save_data' ) );
		}

	}

	public function save_data() {

		$this->checkpoint = current_action();

		if ( isset( $this->checkpoints[ $this->checkpoint ] ) ) {
			$checkpoint = $this->checkpoints[ $this->checkpoint ];

			foreach ( $checkpoint['options']['units'] as $dot_unit ) {
				$ex = explode( '.', $dot_unit );

				// Unit exists
				if ( isset( DevStudio()->map[ $ex[0] ]['components'][ $ex[1] ]['units'][ $ex[2] ] ) ) {

					// Remove old data and recreate directory
					$this->mkdir();

					$unit = DevStudio()->modules[ $ex[0] ]->components[ $ex[1] ]->units[ $ex[2] ];
					$unit->save( $this->checkpoint_dir, $dot_unit );

				}

			}

		}

	}

	public function load_data() {

		$this->checkpoint = $_POST['checkpoint'];

		$mode  = 'admin';
		$this->checkpoint_dir   = DevStudio()->dir('storage') . 'data/' . $mode . '/' . $this->checkpoint;
		$fname = $this->checkpoint_dir . '/' . $_POST['dot_unit'] . '.dat';

		if ( file_exists( $fname ) ) {
			$ex = explode( '.', $_POST['dot_unit'] );

			//return print_r(DevStudio()->map, true);

			if ( isset( DevStudio()->map[ $ex[0] ]['components'][ $ex[1] ]['units'][ $ex[2] ] ) ) {

					$unit = DevStudio()->modules[ $ex[0] ]->components[ $ex[1] ]->units[ $ex[2] ];
				$unit->load( $this->checkpoint_dir, $_POST['dot_unit'] );
				$html = $unit->html();

				return $html;
			}
		}
	}

	function mkdir() {
		$storage_dir = DevStudio()->dir('storage');

		$this->checkpoint_mode_dir = $storage_dir . 'data/' . DevStudio()->mode;
		@mkdir( $this->checkpoint_mode_dir, 755 );

		$this->checkpoint_dir = $this->checkpoint_mode_dir . '/' . $this->checkpoint;
		@mkdir( $this->checkpoint_dir, 755 );
	}
}