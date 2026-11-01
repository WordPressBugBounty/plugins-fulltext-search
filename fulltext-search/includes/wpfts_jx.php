<?php

defined('ABSPATH') || exit;


/**  
 * Copyright 2013-2024 Epsiloncool
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 ******************************************************************************
 *  I am thank you for the help by buying PRO version of this plugin 
 *  at https://fulltextsearch.org/ 
 *  It will keep me working further on this useful product.
 ******************************************************************************
 * 
 *  @copyright 2013-2024
 *  @license GPLv3
 *  @package WP Fast Total Search
 *  @author Epsiloncool <info@e-wm.org>
 */

class WPFTS_jxResponse
{
	protected $xresponse = array();
	
	function console($msg)
	{
		$this->xresponse[] = array('cn', $msg);
	}
	
	function alert($msg)
	{
		$this->xresponse[] = array('al', $msg);
	}

	function assign($id, $data)
	{
		$this->xresponse[] = array('as', $id, $data);
	}
	
	function redirect($url = '', $delay = 0)
	{
		$this->xresponse[] = array('rd', $url, $delay);
	}
	
	function reload()
	{
		$this->xresponse[] = array('rl');
	}
	
	function script($script = '')
	{
		$this->xresponse[] = array('js', $script);
	}
	
	function variable($var, $value)
	{
		$this->xresponse[] = array('vr', $var, $value);
	}
	
	function setResponse($a)
	{
		$this->xresponse = $a;
	}
	
	function getJSON()
	{
		return wpfts_json_encode($this->xresponse);
	}

	function echoJSON()
	{
		echo wpfts_json_encode($this->xresponse);
	}
	
	function getData()
	{
		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- this is a request parser; the AJAX handlers verify nonces.
		if ((isset($_POST['__xr'])) && (sanitize_text_field(wp_unslash($_POST['__xr'])) === '1')) {
			// phpcs:ignore WordPress.Security.NonceVerification.Missing,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- request parser; JSON is decoded and validated by AJAX handlers.
			$raw = isset($_POST['z']) ? wp_unslash($_POST['z']) : '';
			if (!is_string($raw) || ($raw === '')) {
				return array();
			}
			$post = json_decode($raw, true);
			return is_array($post) ? $post : array();
		} else {
			return false;
		}
	}
}
