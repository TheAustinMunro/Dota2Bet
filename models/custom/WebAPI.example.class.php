<?php
class WebAPI {
	private $APIKey;
	private $Dota2ID;

	public function __construct() {
		$this->APIKey  = '<YOUR_API_KEY_HERE>';
		$this->Dota2ID = 570;
	}

	public function GetSchema () {
		$url = 'https://api.steampowered.com/IEconItems_570/GetSchema/v0001/?key='.$this->APIKey.'&format=json';
		return self::MakeCurlRequest($url);
	}

	public function GetPlayerItems ($PlayerID) {
		$url = 'http://api.steampowered.com/IEconItems_570/GetPlayerItems/v0001/?key='.$this->APIKey.'&steamid='.$PlayerID.'&format=json&custom_name=true';
		return self::MakeCurlRequest($url);
	}

	public static function MakeCurlRequest ($url) {
		$handle = curl_init(); 
		curl_setopt($handle, CURLOPT_URL, $url); 
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($handle, CURLOPT_SSLVERSION, 3);
		$response = curl_exec($handle); 
		return $response;
	}
}