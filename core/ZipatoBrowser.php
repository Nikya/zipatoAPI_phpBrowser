<?php

/**
* Zipato Browser for Zipato web API V2.
*
* @see https://my.zipato.com/zipato-web/api/
* @author Nikya : https://github.com/Nikya
*
*/
class ZipatoBrowser {

	/** Base URL part of the REST API */
	const BASE_URL = 'https://my.zipato.com/zipato-web/v2';

	/** cURL handler */
	private $ch = null;

	/** Current URL */
	private $currentUrl = null;

	/** The session Id obtain during login */
	private $sessionId = null;

	/**
	* Browser constructor
	* Need a call to login() before to use it if no params given.
	*
	* @param $username Your email adresse to login
	* @return $password Your password Shadded one time
	*/
	public function __construct($username=null, $password=null) {
		if (!is_null($username) and isset($username) and !empty($username))
			$this->login($username, $password);
	}

	/**
	* Browser destructor
	*/
	public function __destruct() {
		$this->finish();
	}

	/** Logout, close the browser and frees all resources */
	public function finish() {
		if(!is_null($this->ch)) {
			$url = '/user/logout';
			$rData = $this->get($url);
			curl_close($this->ch);
			$this->ch = null;
		}
	}

	/**
	* Secure login to the API
	*
	* @param $username Your email adresse to login
	* @return $password Your pasword Shadded one time
	*/
	public function login($username, $password) {
		// Init cURL
		$this->ch = curl_init();
		$this->assertNotFalse($this->ch);

		// Step init : to get the nonce and Session Id
		$url = '/user/init';
		$rData = $this->get($url);
		$jsessionid =  $rData->jsessionid;
		$nonce = $rData->nonce;

		// Build the login token
		$token = sha1($nonce . $password);

		// Save the session ID
		$this->sessionId = $jsessionid;

		// Step login
		$url = "/user/login?username=$username&token=$token";
		$rData = $this->get($url);

		if ($rData->success != '1') {
			$rData = ' Login fail : '.print_r($rData, true);
		}

		return $rData;
	}

	/**
	* Check the value to be true if is an ok cURL action.
	* If not, throw an exception
	*/
	private function assertNotFalse($boolean) {
		if ($boolean===false) {
			$errorMsg = curl_error($this->ch);
			$this->finish();
			throw new Exception(__CLASS__." cURL error : $errorMsg : $this->currentUrl");
		}
	}

	/**
	* Check that the HTTP code of last curl exec is not different than 200
	*
	*/
	private function assertOk($jsonObj) {
		$httpCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

		if($httpCode/100 != 2) {
			$errorMsg = print_r($jsonObj,true);
			throw new Exception(__CLASS__." HTTP error [$httpCode] for $this->currentUrl. $errorMsg.");
		}
	}

	/** Build the full URL */
	private function buildUrl ($url, $uuid=null, $params=null) {
		if (!isset($url) or is_null($url) or empty($url))
			throw new Exception("url is empty $this->currentUrl");

		// Replace the uuid placeHolder by the gived uuid
		$url = str_replace('{uuid}', $uuid, $url);

		// Add params is gived
		$paramsQuery = '';
		if (isset($params))
			$paramsQuery = '?'.http_build_query($params);

		$this->currentUrl = self::BASE_URL.$url.$paramsQuery;
	}

	/**
	* Reset the cURL
	*/
	public function reset() {
		curl_reset($this->ch);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

		if (!is_null($this->sessionId))
			curl_setopt($this->ch, CURLOPT_COOKIE, 'JSESSIONID='.$this->sessionId);
	}

	/**
	* Make an HTTP GET to the URL, check the result and return the response.
	*
	* @param $url The URL to call
	* @param $uuid (Optional) An uuid to be inject in the URL
	* @return Convert the raw json response into json object
	*/
	public function get($url, $uuid=null, $params=null) {
		$this->reset();
		$this->buildUrl($url, $uuid, $params);

		curl_setopt($this->ch, CURLOPT_URL, $this->currentUrl);
		curl_setopt($this->ch, CURLOPT_HTTPGET, true);

		$curlExec = curl_exec($this->ch);

		$this->assertNotFalse($curlExec);
		$jsonObj = json_decode($curlExec);
		$this->assertOk($jsonObj);

		return $jsonObj;
	}

	/**
	* Make an HTTP PUT to the URL, set the content body, check the result and return the response.
	*
	* @param $url The URL to call
	* @param $uuid (Optional) An uuid to be inject in the URL
	* @param $bodyData (Optional) An bodyData array to be converted in Json and send
	* @return Convert the raw json response into json object
	*/
	public function put($url, $uuid=null, $bodyData=null) {
		$this->reset();

		$this->buildUrl($url, $uuid);
		$jsonData = json_encode($bodyData);

		curl_setopt($this->ch, CURLOPT_URL, $this->currentUrl);
		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($jsonData))
		);

		$curlExec =  curl_exec($this->ch);

		$this->assertNotFalse($curlExec);

		// No content return (It's normal)
		if (empty($curlExec))
			$jsonObj = json_encode(array('succes'=>true));
		else
			$jsonObj = json_decode($curlExec);

		return $jsonObj;
	}
}
