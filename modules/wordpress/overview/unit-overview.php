<?php

class DEV_STUDIO_Unit_WP_Overview extends DEV_STUDIO_Unit {

	public $name = 'overview';
	public $title = 'Overview';
	public $data = array();

	public $show_tab = false;

	public function __construct() {
		parent::__construct();


		//$this->data();
		//$this->save();
	}

	public function data() {
		$this->data = array(
			__( 'Wordpress Version', 'dev-studio' )      => @$GLOBALS['wp_version'],
			__( 'Required PHP version', 'dev-studio' )   => @$GLOBALS['required_php_version'],
			__( 'Required MySQL version', 'dev-studio' ) => @$GLOBALS['required_mysql_version'],
			__( 'TinyMCE version', 'dev-studio' )        => @$GLOBALS['tinymce_version'],
			__( 'Template', 'dev-studio' )               => @$GLOBALS['template'],
		);

	}

	public function html() {
		$rows = array();
		foreach($this->data as $key=>$value) {
			if ( is_array( $value ) && isset( $value['type'] ) ) {
				$value['value'] = $key;
				$rows[] = $value;
			} else {
				$rows[] = array(
					'type' => 'columns',
					'columns' => array(
						array(
							'value' => $key
						),
						array(
							'value' => $value
						)
					)
				);
			}
		}

		return DevStudio()->template('data-table', array(
			'rows' => $rows
		));

	}
}