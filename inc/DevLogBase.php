<?php

namespace DevLog;
/*
 * Dev log
 * Simple and Powerful debugging tool
 * */

class DevLogBase {

	public static $scriptName = "DevLog";

	public static $scriptVersion = "1.0.4";

	private static $_log_serve;

	private static $_log_directory;

	private static $_logs;

	private static $_logs_hash;

	private static $_track_serve;

	private static $_track_directory;

	public static $messageTypes = [];

	public static $logTrackers = [];

	public static $hash_length = 12;

	/**
	 * Register logger
	 * To initialize logger should run this action
	 */
	public static function register() {

		include_once "DevLogHelper.php";
		include_once "DevLogServe.php";

		if ( DEV_LOG_DEBUGGER == true ) {
			include_once "DevLogController.php";
			if ( ! DevLogHelper::ipAddressValidation( DEV_LOG_IP_ADDRESSES ) || ! new DevLogController() ) {
				return;
			}
		}

		/*
		 * Register request shutdown actions
		 * Then save log file as json
		 * And register inline debugger
		 * */
		register_shutdown_function(
			function () {
				/*
				 * Register custom shutdown actions
				 * */
				static::registerShutDownActions();

				/*
				 * Save all logged data
				 * */
				$serve       = self::getLogServe();
				$serve->name = self::getLogHash();
				$serve->log  = self::$_logs;

//
//				$serve->events['beforeSave'][] = [
//					function ( & $log, & $status ) {
//						$log['statement']['post']['heloooooo'] = '1111';
//					}
//				];

				$serve->save();

				/**
				 * If DEV_LOG_INLINE_DEBUGGER is true and not ajax request
				 * Then load inline debugger on every request
				 * */
				if ( DEV_LOG_DEBUGGER == true && DEV_LOG_INLINE_DEBUGGER == true && ! DevLogHelper::isXHRFromServer( $_SERVER ) ) {
					self::registerInlineDebugger();
				}
			}
		);

		static::registerStartActions();

	}


	/**
	 * Render inline debugger
	 */
	private static function registerInlineDebugger() {
		$iframe = '<iframe style="border:none;" width="100%" height="38" src="/' . DEV_LOG_PATH . '/inline/' . self::getLogHash() . '">Your browser does not support iframe.</iframe>';
		echo '<div id="DevLogInline" style="height:38px;z-index:999999999 !important; position: fixed;width:100%;bottom:0;left:0;">' . $iframe . '</div>';
	}

	/**
	 * Register start script
	 */
	public static function registerStartActions() {
		if ( ! isset( self::$_logs['statement'] ) ) {
			self::$_logs['statement'] = [
				'time'       => time(),
				'start_time' => microtime( true ),
				'php_info'   => self::getPhpInfo(),
				'request'    => [ 'headers' => function_exists( 'getallheaders' ) ? getallheaders() : [] ],
				'server'     => $_SERVER,
				'post'       => $_POST,
				'get'        => $_GET,
				'response'   => [ 'headers' => headers_list() ],
				'trace'      => []
			];
		}
	}

	/**
	 * Register shutdown script
	 */
	public static function registerShutDownActions() {
		self::$_logs['statement']['memory_usage'] = memory_get_usage( true );
		self::$_logs['statement']['load_time']    = microtime( true ) - self::$_logs['statement']['start_time'];
		self::$_logs['statement']['trace']        = debug_backtrace();
		self::$_logs['statement']['status']       = http_response_code();
	}


	private static function getPhpInfo() {

		ob_start();
		phpinfo();
		$php_info = ob_get_contents();
		ob_get_clean();

		return $php_info;
	}

	/**
	 * @return string
	 */
	public static function getLogDirectory() {
		if ( ! isset( self::$_log_directory ) ) {
			self::$_log_directory = dirname( __FILE__ ) . '/../logger';
		}

		return self::$_log_directory;
	}


	/**
	 * @return string
	 */
	public static function getTrackDirectory() {
		if ( ! isset( self::$_track_directory ) ) {
			self::$_track_directory = dirname( __FILE__ ) . '/../track';
		}

		return self::$_track_directory;
	}

	public static function getTrackers() {
		return [];
	}

	/**
	 * @return DevLogServe
	 */
	public static function getLogServe() {

		if ( ! isset( self::$_log_serve ) ) {
			self::$_log_serve = new DevLogServe(
				self::getLogDirectory(),
				static::getTrackers(),
				self::getTrackServe()
			);
		}

		return self::$_log_serve;
	}

	public static function getTrackServe() {
		if ( ! isset( self::$_track_serve ) ) {
			self::$_track_serve = new DevLogServe( self::getTrackDirectory() );
		}

		return self::$_track_serve;
	}


	/**
	 * @return string
	 */
	public static function getLogHash() {
		if ( ! isset( self::$_logs_hash ) ) {
			self::$_logs_hash = substr( md5( uniqid( rand(), true ) ), 0, static::$hash_length );
		}

		return self::$_logs_hash;
	}

	/**
	 * @param $type
	 * @param $message
	 * @param string $category
	 */
	public static function log( $type, $message, $category = "default" ) {
		self::$_logs['messages'][] = [
			'type'     => $type,
			'message'  => $message,
			'category' => $category,
			'time'     => time()
		];
	}


	/**
	 * @param int $offset
	 * @param int $limit
	 *
	 * @return array
	 */
	public static function getLogs( $offset = 0, $limit = 100 ) {
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


}