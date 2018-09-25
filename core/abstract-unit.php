<?php

abstract class DEV_STUDIO_Unit {

	public $name;
	public $title;
	public $tabTitle;

	public $data = array();
	public $show_tab = true;

	public function __construct() {
	}

	public function set_title( $title ) {
		$this->title = function_exists( '__' ) ? __( $title, 'dev-studio' ) : $title;
	}

	/**
	 * Get unit data
	 */
	abstract public function data();

	/**
	 * Save data
	 */
	public function save( $dir, $fname ) {
		$this->data();
		//dump( $dir . '/' . $fname . '.dat' );
		
		file_put_contents( $dir . '/' . $fname . '.dat', json_encode($this->data, true) );
	}

	/**
	 * Load data
	 */
	public function load( $dir, $fname ) {
		$data = file_get_contents( $dir . '/' . $fname . '.dat' );
		$this->data = json_decode($data, true);

	}

	/**
	 * Get html
	 *
	 * @return string
	 */
	public function html() {
		$rows = array();
		foreach($this->data as $key=>$value) $rows[] = array(
			array(
				'value' => $key
			),
			array(
				'value' => $value
			)
		);

		return DevStudio()->template('data-table', array(
			'rows' => $rows
		));
	}


}