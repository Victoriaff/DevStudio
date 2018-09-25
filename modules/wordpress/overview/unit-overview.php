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

			__( 'Functions', 'dev-studio' ) => array(
				'type' => 'subheader'
			),
			'is_admin()'      => is_admin() ? 1 : 0,
			'is_home()'       => is_home() ? 1 : 0,
			'is_front_page()' => is_front_page() ? 1 : 0,
			'is_page()'       => is_page() ? 1 : 0,
			'is_single()'     => is_single() ? 1 : 0,
			'is_singular()'   => is_singular() ? 1 : 0,
			'is_embed()'      => is_embed() ? 1 : 0,
			'is_tax()'        => is_tax() ? 1 : 0,
			'is_attachment()' => is_attachment() ? 1 : 0,
			'is_category()'   => is_category() ? 1 : 0,
			'is_tag()'        => is_tag() ? 1 : 0,
			'is_author()'     => is_author() ? 1 : 0,
			'is_date()'       => is_date() ? 1 : 0,
			'is_archive()'    => is_archive() ? 1 : 0,
			'is_multisite()'  => is_multisite() ? 1 : 0,
			'wp_is_mobile()'  => wp_is_mobile() ? 1 : 0,
			'is_404()'        => is_404() ? 1 : 0
		);

	}

	public function html() {
		$rows = array();
		foreach($this->data as $key=>$value) {
			if ( is_array( $value ) && isset( $value['type'] ) ) {
				$rows[$key] = $value;
			} else {
				$rows[] = array(
					array(
						'value' => $key
					),
					array(
						'value' => $value
					)
				);
			}
		}

		return DevStudio()->template('data-table', array(
			'rows' => $rows
		));

	}
}