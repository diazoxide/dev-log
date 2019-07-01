<?php

/*
 *
 * */

final class DevLog {

	private static $_log_directory;

	private static $_log_file_path;

	private static $_logs;

	/**
	 * Register logger
	 */
	public static function register() {
		self::registerShutDown();

		if ( ! isset( self::$_logs['statement'] ) ) {
			self::$_logs['statement'] = [
				'time'     => time(),
				'php_info' => self::getPhpInfo(),
				'request'  => [ 'headers' => function_exists( 'getallheaders' ) ? getallheaders() : [] ],
				'server'   => $_SERVER,
				'post'     => $_POST,
				'get'      => $_GET,
				'trace'    => []
			];
		}

		self::info( 'Page start.' );
	}

	/**
	 * Register shutdown script
	 */
	public static function registerShutDown() {
		register_shutdown_function( function () {
			self::$_logs['statement']['memory_usage'] = memory_get_usage( true );
			self::$_logs['statement']['trace']        = debug_backtrace();
			self::$_logs['statement']['response']     = [ 'headers' => $http_response_header ];

			self::info( 'Page end.' );
			file_put_contents( self::getLogFilePath(), json_encode( self::$_logs ) );
		} );
	}

	/**
	 * @param $message
	 *
	 * @return false|string
	 */
	private static function _message( $message ) {
		if ( ! is_string( $message ) ) {
			ob_start();
			var_dump( $message );
			$message = ob_get_clean();
		}

		return $message;
	}

	private static function getPhpInfo() {

		ob_start();
		phpinfo();
		$php_info = ob_get_contents();
		ob_get_clean();

		return $php_info;
	}

	public static function getLogDirectory() {
		if ( ! isset( self::$_log_directory ) ) {
			self::$_log_directory = dirname( __FILE__ ) . '/logger';
		}

		return self::$_log_directory;
	}

	public static function getLogFilePath() {
		if ( ! isset( self::$_log_file_path ) ) {
			$file_name            = md5( microtime() . rand() );
			self::$_log_file_path = self::getLogDirectory() . "/" . $file_name;

		}

		return self::$_log_file_path;
	}

	/**
	 * @param $type
	 * @param $message
	 * @param string $category
	 */
	public static function log( $type, $message, $category = "default" ) {


		if ( ! file_exists( self::getLogDirectory() ) ) {
			// create directory/folder uploads.
			mkdir( self::getLogDirectory(), 0777, true );
		}


		self::$_logs['messages'][] = [
			'type'     => $type,
			'message'  => self::_message( $message ),
			'category' => $category,
			'time'     => time()
		];


	}


	public static function getLogs( $offset = 0, $limit = 20 ) {
		$files = glob( self::getLogDirectory() . '/*' );
		usort( $files, function ( $a, $b ) {
			return filemtime( $a ) < filemtime( $b );
		} );
		$files = array_slice( $files, $offset, $limit );


		$result = [];
		foreach ( $files as $file ) {
			$result[ basename( $file ) ] = json_decode( file_get_contents( $file ) );
		}

		return $result;
	}

	/**
	 * @param $name
	 *
	 * @return array|bool|mixed|object
	 */
	public static function getLog( $name ) {
		$path = self::getLogDirectory() . '/' . $name;
		$file = file_get_contents( $path );
		if ( $file ) {
			return json_decode( $file );
		} else {
			return false;
		}
	}


	public static function info( $message, $category = "default" ) {

		self::log( 'info', $message, $category );

	}

	public static function warning( $message, $category = "default" ) {

		self::log( 'warning', $message, $category );

	}

	public static function error( $message, $category = "default" ) {

		self::log( 'error', $message, $category );

	}


}