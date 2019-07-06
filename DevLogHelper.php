<?php

namespace DevLog;

class DevLogHelper {


	/**
	 * @param $server
	 *
	 * @return mixed
	 */
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

	/**
	 * @param $server
	 *
	 * @return string
	 */
	public static function getActualUrlFromServer( $server ) {
		$server = (array) $server;
		return ( isset( $server['HTTPS'] ) && $server['HTTPS'] === 'on' ? "https" : "http" )
		       . "://{$server['HTTP_HOST']}{$server['REQUEST_URI']}";
	}

	/**
	 * @param $server
	 *
	 * @return bool
	 */
	public static function isXHRFromServer( $server ) {
		$server = (array) $server;
		if ( isset( $server['HTTP_X_REQUESTED_WITH'] ) && strtolower( $server['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest' ) {
			return true;
		}

		return false;
	}


	/**
	 * @param $items
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public static function getMenu($items, $params){

		$result = '<div class="list-group">';

		$result.=self::getMenuItems($items,isset($params['items']) ? $params['items'] : [] );

		$result.="</div>";

		return $result;

	}

	/**
	 * @param $items
	 * @param $params
	 *
	 * @return string
	 */
	public static function getMenuItems($items, $params){

		$result = '';

		foreach ($items as $index => $item){
			$_params = $params;
			$url = isset($item['url']) ? $item['url'] : false;
			if($url){
				$_params['href'] = $url;
			}

			if(self::compareUrls(self::getActualUrlFromServer($_SERVER),$url)){
				$_params['class'].=" active";
			}

			$label = isset($item['label']) ? $item['label'] : '';

			$result.='<a '.self::getHtmlParams($_params).'>'.$label.'</a>';
		}

		return $result;
	}


	/**
	 * @param array $params
	 *
	 * @return string
	 */
	public static function getHtmlParams(array $params){
		return join(' ', array_map(function($key) use ($params)
		{
			if(is_bool($params[$key]))
			{
				return $params[$key]?$key:'';
			}
			return $key.'="'.$params[$key].'"';
		}, array_keys($params)));
	}


	public static function compareUrls($a,$b){
		$_a = parse_url($a);

		$_b = parse_url($b);

		$__a = [
			'path'=>isset($_a['path']) && isset($_b['path']) ? $_a['path'] : '',
			'query'=>isset($_a['query']) ? $_a['query'] : ''
		];

		$__b = [
			'path'=>isset($_b['path']) && isset($_a['path']) ? $_b['path'] : '',
			'query'=>isset($_b['query']) ? $_b['query'] : ''
		];


		return $__a==$__b;
	}


	public static function getMemUsageReadable( $mem_usage ) {

		if ( $mem_usage < 1024 ) {
			return $mem_usage . " b";
		} elseif ( $mem_usage < 1048576 ) {
			return round( $mem_usage / 1024, 2 ) . " kb";
		} else {
			return round( $mem_usage / 1048576, 2 ) . " mb";
		}
	}

	public static function trimString( $string, $limit = 40, $end = '...' ) {
		return ( strlen( $string ) > $limit ) ? substr( $string, 0, $limit ) . $end : $string;
	}

}