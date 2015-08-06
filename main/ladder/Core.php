<?php
/**
 * Core.php
 * Handles everything
 */

include('Datab.php');
include('Osuapi.php');
include('Display.php');

class Core
{
	public $connector;
	public $api;
	public $key;

	public function __construct()
	{
		$this->connector = new Datab();
		$this->api = new Osuapi();
		$this->key = '3469e713db9b2fa4e1eae851e703163791d62218';
	}

	public function putStatsInDb($usernames, $mode, $ladderkey)
	{
		foreach ($usernames as $key => $value)
		{
			if ($key == 0) 
			{
				$master = 1;
			} else
			{
				$master = 0;
			}
			$data = $this->api->getUserStats($value, $mode, $this->key);
			$this->connector->putStats($data, $mode, $ladderkey, $master);
		}
	}

	public function printTable($ladderkey)
	{
		printTable($this->connector->getStats($ladderkey));
		return 1;
	}
}