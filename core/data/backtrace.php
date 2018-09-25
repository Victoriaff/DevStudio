<?php

class DEV_STUDIO_Backtrace extends DEV_STUDIO_Data {

	public $slug = 'backtrace';

	public function __construct( $args ) {
		parent::__construct( $args );

		$this->data();
		$this->save();
	}

	public function data() {
		$bt = debug_backtrace();

		foreach($bt as $key=>$val) {
			if ( $key > 3 ) {
				$index = ! empty( $val['file'] ) ? $val['file'] . ', line ' . $val['line'] : $val['function'];

				$this->data[ $index ] = array();

				if ( ! empty( $val['function'] ) ) {
					$this->data[ $index ]['function'] = $val['function'];
				}
				if ( ! empty( $val['class'] ) ) {
					$this->data[ $index ]['class'] = $val['class'];
				}
				if ( ! empty( $val['args'] ) ) {
					$this->data[ $index ]['args'] = $val['args'];
				}
			}
		}

		//dd($this->data);
	}
}