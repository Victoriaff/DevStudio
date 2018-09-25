<?php

class DEV_STUDIO_WP extends DEV_STUDIO_Data {

	public $slug = 'wp';

	public function __construct( $args ) {
		parent::__construct( $args );

		$this->data();
		$this->save();
	}

	public function data() {
		$this->data = array(
			'Wordpress Version' => @$GLOBALS['wp_version'],
			'Required PHP version' => @$GLOBALS['required_php_version'],
			'Required MySQL version' => @$GLOBALS['required_mysql_version'],
			'TinyMCE version' => @$GLOBALS['tinymce_version'],
			'Template' => @$GLOBALS['template'],

			'[ Functions ]' => '[::header::]',
			'is_admin()' => is_admin() ? 1:0,
			'is_home()' => is_home() ? 1:0,
			'is_front_page()' => is_front_page() ? 1:0,
			'is_page()' => is_page() ? 1:0,
			'is_single()' => is_single() ? 1:0,
			'is_singular()' => is_singular() ? 1:0,
			'is_embed()' => is_embed() ? 1:0,
			'is_tax()' => is_tax() ? 1:0,
			'is_attachment()' => is_attachment() ? 1:0,
			'is_category()' => is_category() ? 1:0,
			'is_tag()' => is_tag() ? 1:0,
			'is_author()' => is_author() ? 1:0,
			'is_date()' => is_date() ? 1:0,
			'is_archive()' => is_archive() ? 1:0,
			'is_multisite()' => is_multisite() ? 1:0,
			'wp_is_mobile()' => wp_is_mobile() ? 1:0,
			'is_404()' => is_404() ? 1:0
		);

	}
}