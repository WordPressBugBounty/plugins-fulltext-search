<?php

defined('ABSPATH') || exit;


/**
 * The Fire&Flare microservice is a smart "proxy" that sends short packets from the server backend to 
 * the js-based frontend in a real-time.
 * 
 * This Fire&Flare wrapper class is using to make rapid bi-directional syncronization
 * between the website client part and the server part (controlled by WPFTS).
 * 
 * "Fire" part is controlled by this class
 * "Flare" part is controlled by js script
 * 
 * @author Epsiloncool <epsiloncool@gmail.com>
 */
class WPFTS_Flare
{
	public $target_url = '';
	public $mid = '';

	public function __construct($target_url, $medium_point = '')
	{
		$this->target_url = $target_url;
		$this->mid = $medium_point;
	}

	public function SendFire($data = array(), $is_update = false, $is_blocking = false)
	{
		$server_addr = isset($_SERVER['SERVER_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['SERVER_ADDR'])) : '';
		$http_host = isset($_SERVER['HTTP_HOST']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST'])) : '';
		$server_id = ($server_addr !== '') ? $server_addr : (($http_host !== '') ? $http_host : 'no_server_addr');

		$packet = array(
			'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
			'body' => wpfts_json_encode(array(
				'mid' => $this->mid,
				'ts' => time(), // Current actual timestamp
				't' => $is_update ? 'u' : 'f', // Full frame
				'sd' => home_url(),
				'si' => $server_id,
				'msg' => $data,
			)),
			'blocking' => $is_blocking,	// Do not wait for response if false
			'timeout' => 300,
			'data_format' => 'body',
		);

		return wp_remote_post($this->target_url, $packet);
	}

	public static function MakeUniqueMediumID()
	{
		$server_addr = isset($_SERVER['SERVER_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['SERVER_ADDR'])) : '';
		$http_host = isset($_SERVER['HTTP_HOST']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST'])) : '';
		$server_id = ($server_addr !== '') ? $server_addr : (($http_host !== '') ? $http_host : 'no_server_addr');
		$mid = md5(uniqid('flare_mid')).('|'.home_url().'|'.$server_id);

		return $mid;
	}
}
