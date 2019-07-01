<?php

namespace DevLog;

use Requests_Exception_HTTP_500;

class DevLogController {


	public $layout = null;

	public $viewsDirectory = null;


	/**
	 * DevLogController constructor.
	 *
	 * @param $ip_addresses
	 *
	 * @throws Requests_Exception_HTTP_500
	 */
	public function __construct($ip_addresses) {

		if ( ! $this->ipAddressValidation($ip_addresses) ) {
			return true;
		}

		if ( $this->viewsDirectory == null ) {
			$this->viewsDirectory = dirname( __FILE__ ) . '/views';
		}

		if ( $this->layout == null ) {
			$this->layout = $this->viewsDirectory . '/layout.php';
		} else {
			$this->layout = $this->layout . '.php';
		}


		return $this->registerRoutes();
	}

	private function ipAddressValidation($ip_addresses) {
		if ( in_array( '*', $ip_addresses ) || in_array( DevLogHelper::getUserIpAddressFromServer( $_SERVER ), $ip_addresses ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @return bool
	 * @throws Requests_Exception_HTTP_500
	 */
	public function registerRoutes() {

		$route = strtok( isset( $_SERVER["REQUEST_URI"] ) ? $_SERVER["REQUEST_URI"] : '', '?' );

		if ( trim( $route, '/' ) == 'dlog' ) {

			$this->actionDefault();

			die();
		}

		if ( preg_match( '/^\/dlog\/view\/(?<name>.*)?$/', $route, $matches ) ) {

			$this->actionView( $matches['name'] );

			die();
		}

		return true;
	}


	/**
	 * Action
	 * @throws Requests_Exception_HTTP_500
	 */
	public function actionDefault() {
		$this->render( 'list', [
			'logs' => DevLog::getLogs()
		], false );
	}

	/**
	 * @throws Requests_Exception_HTTP_500
	 */
	public function actionView( $name ) {

		$this->render( 'view', [
			'log' => DevLog::getLog( $name )
		], false );
	}


	/**
	 * @param $file
	 * @param array $params
	 *
	 * @return bool
	 * @throws Requests_Exception_HTTP_500
	 */
	public function render( $file, $params = [], $clean = true ) {

		$file = $this->viewsDirectory . '/' . $file . '.php';

		if ( ! file_exists( $file ) ) {
			throw new Requests_Exception_HTTP_500( "View file not exist!" );
		}


		foreach ( $params as $key => $param ) {
			$$key = $param;
		}
		unset( $params );


		ob_start();
		include_once( $file );
		$content = ob_get_contents();
		ob_get_clean();

		if ( $clean == false ) {

			if ( ! file_exists( $this->layout ) ) {
				throw new Requests_Exception_HTTP_500( "Layout view file not exist!" );
			}

			require $this->layout;

		} else {
			echo $content;
		}

		return true;
	}

}