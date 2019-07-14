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

	private $trackersServe = null;

	/**
	 * DevLogServe constructor.
	 *
	 * @param $path
	 * @param array $trackers
	 * @param DevLogServe $trackersServe
	 */
	public function __construct( $path, $trackers = [], $trackersServe = null ) {
		$this->path = $path;
		$this->trackersServe = $trackersServe;
		$this->setTrackers( $trackers );
	}


	/**
	 * Setting tracker functions
	 * @param $trackers
	 */
	private function setTrackers( $trackers ) {
		/*
		 * Adding event before save
		 * To track a data
		 * */
		/**
		 * @param $log
		 * @param $status
		 */
		$this->events['beforeSave'][] = function ( & $log, & $status ) use ( $trackers ) {

			/*
			 * Fetching trackers
			 * */
			foreach ( $trackers as $key => $tracker ) {
				/*
				 * If is set criteria
				 * */
				$criteria = isset( $tracker['criteria'] ) ? $tracker['criteria'] : [];

				/*
				 * Final status of criteria
				 * */
				$condition_status = true;

				/*
				 * Fetching criteria and checking each condition
				 * */
				foreach ( $criteria as $condition ) {

					/*
					 * If condition first element is callable function
					 * */
					if ( is_callable( $condition[0] ) ) {

						/*
						 * Type of condition (and | or)
						 * */
						$condition_type = isset( $condition[1] ) ? strtolower( $condition[1] ) : 'and';
						if ( $condition_type == 'and' ) {
							$condition_status = $condition_status && call_user_func_array( $condition[0], [
									& $log,
									& $status
								] );
						} elseif ( $condition_type == 'or' ) {
							$condition_status = $condition_status || call_user_func_array( $condition[0], [
									& $log,
									& $status
								] );
						}
					}
				}

				/*
				 * If criteria condition checking is successful
				 * And is true
				 * */
				if($condition_status == true){
					$data = isset( $tracker['data'] ) ? $tracker['data'] : [];

					if(is_callable($data)){
						$data = call_user_func_array( $data, [
							$key,
							$this->trackersServe->findOne($key)->log,
							$log,
						] );
					}

					if(!isset($data['instances'])){
						$data['instances'] = [];
					}
					$data['instances'][] = $log->name;

					if($this->trackersServe !== null){
						$this->trackersServe->log = $data;
						$this->trackersServe->name = $key;
						$this->trackersServe->save();
					}
				}

			}
		};


	}

	private function runEvent( $name, & $status ) {
		if ( isset( $this->events[ $name ] ) ) {
			foreach ( $this->events[ $name ] as $event ) {
				call_user_func_array( $event, [ &$this, &$status ] );
			}
		}
	}

	/**
	 * @return bool
	 */
	public function save() {
		$status = true;

		$this->runEvent( 'beforeSave', $status );

		$status = $this->saveOnFile();

		$this->runEvent( 'afterSave', $status );

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
			$this->log = json_decode( $file,true );

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