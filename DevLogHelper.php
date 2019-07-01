<?php

namespace DevLog;

class DevLogHelper {


	public static function getUserIpAddressFromServer( $server ) {
		if ( ! empty( $server->{'HTTP_CLIENT_IP'} ) ) {
			$ip = $server->{'HTTP_CLIENT_IP'};
		} elseif ( ! empty( $server->{'HTTP_X_FORWARDED_FOR'} ) ) {
			$ip = $server->{'HTTP_X_FORWARDED_FOR'};
		} else {
			$ip = $server->{'REMOTE_ADDR'};
		}

		return $ip;
	}

	public static function getActualUrlFromServer( $server ) {
		return ( isset( $server->{'HTTPS'} ) && $server->{'HTTPS'} === 'on' ? "https" : "http" )
		       . "://{$server->HTTP_HOST}{$server->REQUEST_URI}";
	}

	public static function isXHRFromServer( $server ) {
		$server = (array) $server;
		if ( isset( $server['HTTP_X_REQUESTED_WITH'] ) && strtolower( $server['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest' ) {
			return true;
		}

		return false;
	}

}