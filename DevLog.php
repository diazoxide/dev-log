<?php

namespace DevLog;
/*
 * Dev log
 * Simple and Powerful debugging tool
 * */

final class DevLog extends DevLogBase {

	/**
	 * @param $message
	 * @param string $category
	 */
	public static function message( $message, $category = "default" ) {

		self::log( 'message', $message, $category );

	}

	/**
	 * @param $message
	 * @param string $category
	 */
	public static function info( $message, $category = "default" ) {

		self::log( 'info', $message, $category );

	}

	/**
	 * @param $message
	 * @param string $category
	 */
	public static function note( $message, $category = "default" ) {

		self::log( 'note', $message, $category );

	}

	/**
	 * @param $message
	 * @param string $category
	 */
	public static function secondary( $message, $category = "default" ) {

		self::log( 'secondary', $message, $category );

	}

	/**
	 * @param $message
	 * @param string $category
	 */
	public static function important( $message, $category = "default" ) {

		self::log( 'important', $message, $category );

	}

	/**
	 * @param $message
	 * @param string $category
	 */
	public static function warning( $message, $category = "default" ) {

		self::log( 'warning', $message, $category );

	}

	/**
	 * @param $message
	 * @param string $category
	 */
	public static function error( $message, $category = "default" ) {

		self::log( 'error', $message, $category );

	}


	/**
	 * Register page shutdown actions
	 */
	public static function registerShutDownActions() {
		parent::registerShutDownActions();
		self::important( "Page loaded." );
	}

	/**
	 * Register page start actions
	 */
	public static function registerStartActions() {
		parent::registerStartActions();
		self::important( "Page started." );
	}


}