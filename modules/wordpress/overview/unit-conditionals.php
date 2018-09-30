<?php

class DEV_STUDIO_Unit_WP_Overview_Conditionals extends DEV_STUDIO_Unit {

	public $name = 'conditionals';
	public $title = 'Conditionals';
	public $data = array();

	public $show_tab = false;

	public function __construct() {
		parent::__construct();


		//$this->data();
		//$this->save();
	}

	public function data() {

		$conditionals = array();

		if ( function_exists('is_admin')) {
			$conditionals['is_admin()'] = is_admin() ? true : false;
		}
		if ( function_exists('is_archive')) {
			$conditionals['is_archive()'] = is_archive() ? true : false;
		}
		if ( function_exists('is_attachment')) {
			$conditionals['is_attachment()'] = is_attachment() ? true : false;
		}
		if ( function_exists('is_blog_admin')) {
			$conditionals['is_blog_admin()'] = is_blog_admin() ? true : false;
		}
		if ( function_exists('is_author')) {
			$conditionals['is_author()'] = is_author() ? true : false;
		}
		if ( function_exists('is_category')) {
			$conditionals['is_category()'] = is_category() ? true : false;
		}
		if ( function_exists('is_comment_feed')) {
			$conditionals['is_comment_feed()'] = is_comment_feed() ? true : false;
		}
		if ( function_exists('is_customize_preview')) {
			$conditionals['is_customize_preview()'] = is_customize_preview() ? true : false;
		}
		if ( function_exists('is_date')) {
			$conditionals['is_date()'] = is_date() ? true : false;
		}
		if ( function_exists('is_day')) {
			$conditionals['is_day()'] = is_day() ? true : false;
		}
		if ( function_exists('is_embed')) {
			$conditionals['is_embed()'] = is_embed() ? true : false;
		}
		if ( function_exists('is_embed')) {
			$conditionals['is_embed()'] = is_embed() ? true : false;
		}
		if ( function_exists('is_feed')) {
			$conditionals['is_feed()'] = is_feed() ? true : false;
		}
		if ( function_exists('is_front_page')) {
			$conditionals['is_front_page()'] = is_front_page() ? true : false;
		}
		if ( function_exists('is_home')) {
			$conditionals['is_home()'] = is_home() ? true : false;
		}
		if ( function_exists('is_month')) {
			$conditionals['is_month()'] = is_month() ? true : false;
		}
		if ( function_exists('is_embed')) {
			$conditionals['is_embed()'] = is_embed() ? true : false;
		}
		if ( function_exists('is_multisite')) {
			$conditionals['is_multisite()'] = is_multisite() ? true : false;
		}
		if ( function_exists('is_network_admin')) {
			$conditionals['is_network_admin()'] = is_network_admin() ? true : false;
		}
		if ( function_exists('is_page')) {
			$conditionals['is_page()'] = is_page() ? true : false;
		}
		if ( function_exists('is_page_template')) {
			$conditionals['is_page_template()'] = is_page_template() ? true : false;
		}
		if ( function_exists('is_paged')) {
			$conditionals['is_paged()'] = is_paged() ? true : false;
		}
		if ( function_exists('is_post_type_archive')) {
			$conditionals['is_post_type_archive()'] = is_post_type_archive() ? true : false;
		}
		if ( function_exists('is_preview')) {
			$conditionals['is_preview()'] = is_preview() ? true : false;
		}
		if ( function_exists('is_robots')) {
			$conditionals['is_robots()'] = is_robots() ? true : false;
		}
		if ( function_exists('is_rtl')) {
			$conditionals['is_rtl()'] = is_rtl() ? true : false;
		}
		if ( function_exists('is_search')) {
			$conditionals['is_search()'] = is_search() ? true : false;
		}
		if ( function_exists('is_single')) {
			$conditionals['is_single()'] = is_single() ? true : false;
		}
		if ( function_exists('is_singular')) {
			$conditionals['is_singular()'] = is_singular() ? true : false;
		}
		if ( function_exists('is_ssl')) {
			$conditionals['is_ssl()'] = is_ssl() ? true : false;
		}
		if ( function_exists('is_sticky')) {
			$conditionals['is_sticky()'] = is_sticky() ? true : false;
		}
		if ( function_exists('is_tag')) {
			$conditionals['is_tag()'] = is_tag() ? true : false;
		}
		if ( function_exists('is_tax')) {
			$conditionals['is_tax()'] = is_tax() ? true : false;
		}
		if ( function_exists('is_time')) {
			$conditionals['is_time()'] = is_time() ? true : false;
		}
		if ( function_exists('is_trackback')) {
			$conditionals['is_trackback()'] = is_trackback() ? true : false;
		}
		if ( function_exists('is_user_admin')) {
			$conditionals['is_user_admin()'] = is_user_admin() ? true : false;
		}
		if ( function_exists('is_year')) {
			$conditionals['is_year()'] = is_year() ? true : false;
		}
		if ( function_exists('is_404')) {
			$conditionals['is_404()'] = is_404() ? true : false;
		}
		if ( function_exists('wp_is_mobile')) {
			$conditionals['wp_is_mobile()'] = wp_is_mobile() ? true : false;
		}

		$true = array();
		$false = array();
		foreach($conditionals as $key=>$value) {
			if ( $value ) {
				$true[] = $key;
			} else {
				$false[] = $key;
			}
		}

		foreach($true as $key) {
			$this->data[] = array(
				'class' => 'mark',
				'type'    => 'columns',
				'columns' => array(
					array(
						'value' => $key
					),
					array(
						'value' => __('True', '{domain}')
					)
				)

			);
		}
		foreach($false as $key) {
			$this->data[] = array(
				'class' => 'mask',
				'type'    => 'columns',
				'columns' => array(
					array(
						'value' => $key
					),
					array(
						'value' => __('False', '{domain}')
					)
				)

			);
		}

		//dd($this->data);

	}

	public function html() {

		return DevStudio()->template('data-table', array(
			'rows' => $this->data
		));

	}

}