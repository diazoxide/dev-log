<?php


class DevLogController {


	public $layout = null;

	public $viewsDirectory = null;

	private $_layout_already_set = false;

	/**
	 * DevLogController constructor.
	 * @throws Requests_Exception_HTTP_500
	 */
	public function __construct() {


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


	/**
	 * @return bool
	 * @throws Requests_Exception_HTTP_500
	 */
	public function registerRoutes() {

		$route = strtok( $_SERVER["REQUEST_URI"], '?' );

		if ( trim( $route, '/' ) == 'dev-log' ) {

			$this->actionDefault();

			die();
		}

		if ( preg_match( '/^\/dev-log\/view\/(?<name>.*)?$/', $route, $matches ) ) {

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