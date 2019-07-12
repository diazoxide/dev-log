<?php

namespace DevLog;
/*
 * Dev log
 * Simple and Powerful debugging tool
 * */

class DevLogServe {

	public $log = [];

	public $name = null;

	public $path = null;

	public $events = [];

	public $trackers = [];

	public function __construct( $path ) {
		$this->path = $path;
	}

	/**
	 * @return bool
	 */
	public function save() {
		$status = true;

		if ( isset( $this->events['beforeSave'] ) ) {
			call_user_func_array( $this->events['beforeSave'], [ & $this->log, &$status ] );
		}

		$status = $this->saveOnFile();

		if ( isset( $this->events['afterSave'] ) ) {
			call_user_func_array( $this->events['afterSave'], [ &$this->log, &$status ] );
		}

		return $status;
	}

	/**
	 * @return bool
	 */
	private function saveOnFile() {

		if ( $this->getFilePath() != null && file_put_contents( $this->getFilePath(), json_encode( $this->log ) ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @return string|null
	 */
	private function getFilePath() {
		if ( $this->name == null || $this->path == null ) {
			return null;
		}

		if ( ! file_exists( $this->path ) ) {
			mkdir( $this->path, 0777, true );
		}

		return $this->path . "/" . $this->name;
	}

	/**
	 * @param $name
	 *
	 * @return $this|bool
	 */
	public function findOne( $name ) {
		$this->name = $name;
		$path       = $this->getFilePath();
		$file       = file_get_contents( $path );
		if ( $file ) {
			$this->log = json_decode( $file );

			return $this;
		} else {
			return false;
		}
	}

	/**
	 * @param int $offset
	 * @param int $limit
	 *
	 * @return array
	 */
	public function findAll( $offset = 0, $limit = 100 ) {
		$files = glob( $this->path . '/*' );
		usort( $files, function ( $a, $b ) {
			return filemtime( $a ) < filemtime( $b );
		} );
		$files = array_slice( $files, $offset, $limit );

		$result = [];
		foreach ( $files as $file ) {
			$name            = basename( $file );
			$result[ $name ] = clone $this->findOne( $name );
		}

		return $result;
	}
}