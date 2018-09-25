<?php
class DEV_STUDIO_Util {

	static function is_admin() {
		if ( isset( $GLOBALS['current_screen'] ) && class_exists('WP_Screen') )
			return $GLOBALS['current_screen']->in_admin();
		elseif ( defined( 'WP_ADMIN' ) )
			return WP_ADMIN;

		return false;
	}

	static function is_ajax() {
		return defined( 'DOING_AJAX' );
	}

	static function map() {
		$data = array();

		$active_module = 'wordpress';
		$active_component = 'overview';

		foreach(DevStudio()->modules() as $module_name=>$module) {
			$data[ $module_name ] = array(
				'title'      => $module->title,
				'components' => array()
			);
			if ($module_name == $active_module) $data[ $module_name ]['active'] = true;

			foreach ( $module->components() as $component_name => $component ) {
				$data[ $module_name ]['components'][ $component_name ] = array(
					'title' => $component->title,

					'units' => array()
				);
				if ($component_name == $active_component) $data[ $module_name ]['components'][ $component_name ]['active'] = true;

				foreach ( $component->units() as $unit_name => $unit ) {
					$data[ $module_name ]['components'][ $component_name ]['units'][ $unit_name ] = array(
						'title' => !empty($unit->tabTitle) ? $unit->tabTitle:$unit->title
					);
				}
			}
		}

		return $data;
	}

	function rmdir( $dir ) {
		if (is_dir($dir)) {
			$it    = new RecursiveDirectoryIterator( $dir, RecursiveDirectoryIterator::SKIP_DOTS );
			$files = new RecursiveIteratorIterator( $it, RecursiveIteratorIterator::CHILD_FIRST );
			foreach ( $files as $file ) {
				if ( $file->isDir() ) {
					rmdir( $file->getRealPath() );
				} else {
					unlink( $file->getRealPath() );
				}
			}
			rmdir( $dir );
		}
	}
}