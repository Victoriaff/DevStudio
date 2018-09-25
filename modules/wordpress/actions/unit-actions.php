<?php

class DEV_STUDIO_Unit_WP_Actions extends DEV_STUDIO_Unit {

	public $name = 'actions';
	public $title = 'Actions';

	public function __construct(  ) {
		parent::__construct(  );
	}

	public function data() {
		global $wp_actions;

		if (isset($wp_actions) && !empty($wp_actions)) {
			foreach($wp_actions as $action => $fires) {
				$this->data[$action] = $fires;
			}
		}
	}

	public function html() {
		$rows = array();
		foreach($this->data as $key=>$value) $rows[] = array(
			array(
				'value' => $key
			),
			array(
				'value' => $value,
				'class' => 'ds-text-right'
			)
		);

		return DevStudio()->template('data-table', array(
			'headers' => array(
				__('Action', 'dev-studio'),
				__('Fires', 'dev-studio'),
			),
			'rows' => $rows
		));
	}

}