<?php

/**
* Meteo from zipato
*
* @see https://my.zipato.com/zipato-web/v2-doc/doc
* @author Nikya : https://github.com/Nikya
*
*/
class MeteoServices extends ZipatoServices {

	/** A Meteo UUID */
	private $uuid;

	/** Hard URL to find Wether Icon */
	const BASE_WEATHER_ICON_URL = 'https://my.zipato.com/zipato-web/images/app2/parts/weather/icons/';

	/**
	* Registre the meteo UUID to use
	*
	* @param $meteoUuid A meteo UUID (Use Zipato API explorer : Get /Meteo)
	*/
	public function setUuid($meteoUuid) {
		$this->uuid = $meteoUuid;
	}

	/**
	* List all configured Meteo
	*
	* @return Array of data
	*/
	public function listMeteo() {
		$url = '/meteo';
		$rData = $this->zipatoBrowser->get($url);
		return $rData;
	}

	/**
	* Read all data about the current Meteo
	*
	* @return Array of data
	*/
	public function fullRead() {

		if (!isset($this->uuid)) {
			throw new Exception("Unset Meteo UUID");
		}

		$rData = array();
		$allValue = array();

		// All conditions
		$rDataC = array();
		$url = '/meteo/{uuid}/conditions';
		$rDataC = $this->zipatoBrowser->get($url, $this->uuid);

		// All values
		$rDataV = array();
		$url = '/meteo/attributes/values';
		$rDataV = $this->zipatoBrowser->get($url);

		// Extract values
		foreach ($rDataV as $d) {
			$allValue[$d->uuid] = $d->value->value;
		}

		// Build output data
		foreach ($rDataC->attributes as $attr) {
			$name = $attr->attributeName;
			$uuid = $attr->uuid;

			if (isset($allValue[$uuid]))
				$rData[$name] = $allValue[$uuid];
		}

		$rData['icon'] = $this->getMeteoIcon($rData['icon']);

		return $rData;
	}

	/**
	* Get a weather Icon
	*
	* @param $iconName Name of a icon
	* @return A image online URL
	*
	*/
	public function getMeteoIcon($iconName) {
		return self::BASE_WEATHER_ICON_URL.$iconName.'.png';
	}
}
