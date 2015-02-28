<?php
require_once('core/ZipatoBrowser.php');

/**
* Zipato Services to provides services through the Zipato API
*
* @see https://my.zipato.com/zipato-web/v2-doc/doc
* @author Nikya : https://github.com/Nikya
*
*/
abstract class ZipatoServices {

	/** The ZipatoBrowser Use to send request */
	protected $zipatoBrowser;

	/**
	* Services constructor
	*
	* @param $username Your email adresse to login
	* @param $password Your password Shadded one time
	*/
	public function __construct($username, $password) {
		$this->zipatoBrowser =  new ZipatoBrowser($username, $password);
	}

	/**
	* Browser destructor
	*/
	public function __destruct() {
		$this->finish();
	}

	/** Logout and free the browser */
	public function finish() {
		if(!is_null($this->zipatoBrowser))
			$this->zipatoBrowser->finish();
	}

	/** List all devices or One devices */
	public function autogetDevices($uuid) {
		if (!isset($uuid) or empty($uuid))
			return $this->getAllDevices();
		else
			return $this->getADevice($uuid);
	}

	/** List all devices */
	public function getAllDevices() {
		$url = '/devices';
		$rData = $this->zipatoBrowser->get($url);
		return $rData;
	}

	/** List a device and is endpoints and config */
	public function getADevice($uuid) {
		$url = '/devices/{uuid}';
		$params = array('endpoints'=>'true', 'config'=>'true');
		$rData = $this->zipatoBrowser->get($url, $uuid, $params);
		return $rData;
	}

	/** List all Endpoints or one Endpoint */
	public function autogetEndpoints($uuid) {
		if (!isset($uuid) or empty($uuid))
			return $this->getAllEndpoints();
		else
			return $this->getAEndpoint($uuid);
	}

	/** Get all endpoints */
	public function getAllEndpoints() {
		$url = '/endpoints';
		$rData = $this->zipatoBrowser->get($url);
		return $rData;
	}

	/** Get an Endpoint and is attributes and config */
	public function getAEndpoint($uuid) {
		$url = '/endpoints/{uuid}';
		$params = array('attributes'=>'true', 'config'=>'true');
		$rData = $this->zipatoBrowser->get($url, $uuid, $params);
		return $rData;
	}

	/** List all Attributes or one Attributes */
	public function autogetAttributes($uuid) {
		if (!isset($uuid) or empty($uuid))
			return $this->getAllAttributes();
		else
			return $this->getAAttributes($uuid);
	}

	/** Get all Attributes */
	public function getAllAttributes() {
		$url = '/attributes';
		$rData = $this->zipatoBrowser->get($url);
		return $rData;
	}

	/** Get an Attributes and is attributes and config */
	public function getAAttributes($uuid) {
		$url = '/attributes/{uuid}';
		$params = array('value'=>'true', 'type'=>'true');
		$rData = $this->zipatoBrowser->get($url, $uuid, $params);
		return $rData;
	}

	/** Get an Attributes and is attributes and config */
	public function getAttributeValue($uuid) {
		$url = '/attributes/{uuid}/value';
		$params = array('value'=>'true', 'type'=>'true');
		$rData = $this->zipatoBrowser->get($url, $uuid, $params);
		return $rData;
	}

	/** To swith an attribut state */
	public function switchTo($uuid, $state) {
		$url = '/attributes/{uuid}/value';
		$data = array('value'=>$state);
		$rData = $this->zipatoBrowser->put($url, $uuid, $data);
		return $rData;
	}
}
