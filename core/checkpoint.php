<?php

class DEV_STUDIO_Checkpoint {

	public $checkpoints = array();
	public $checkpoint;
	public $checkpoint_dir;
	public $checkpoint_mode_dir;
	public $default_options = array(
		'units' => array(
			'wordpress.overview.overview',
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

		$response = array(
			'result' => ''
		);
		$this->checkpoint = $_POST['checkpoint'];

		$mode  = 'admin';
		$this->checkpoint_dir   = DevStudio()->get_storage_dir() . '/data/' . $mode . '/' . $this->checkpoint;
		$fname = $this->checkpoint_dir . '/' . $_POST['dot_unit'] . '.dat';

		/*
		$response['result'] = 'ok';
		$response['fname'] = $fname;
		$response['_POST'] = $_POST;

		wp_send_json($response);
		wp_die();
		*/


		if ( file_exists( $fname ) ) {
			$ex = explode( '.', $_POST['dot_unit'] );

			if ( isset( DevStudio()->map[ $ex[0] ]['components'][ $ex[1] ]['units'][ $ex[2] ] ) ) {

				$unit = DevStudio()->modules[ $ex[0] ]->components[ $ex[1] ]->units[ $ex[2] ];
				$unit->load( $this->checkpoint_dir, $_POST['dot_unit'] );
				$html = $unit->html();

				$response['result'] = 'ok';
				$response['html'] = $html;
				$response['_POST'] = $_POST;

				wp_send_json($response);
				wp_die();
			}
		}


	}

	function mkdir() {
		$storage_dir = DevStudio()->get_storage_dir();

		$this->checkpoint_mode_dir = $storage_dir . '/data/' . DevStudio()->mode;
		@mkdir( $this->checkpoint_mode_dir, 755 );

		$this->checkpoint_dir = $this->checkpoint_mode_dir . '/' . $this->checkpoint;
		@mkdir( $this->checkpoint_dir, 755 );
	}


}