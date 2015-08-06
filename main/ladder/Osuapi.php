<?php 

class Osuapi
{
	public $apiurl;

	public function __construct()
	{
		$this->apiurl = 'https://osu.ppy.sh/api/';
	}

	/*
	 * apiRequest(url)
	 * Returns whatever is requested to the osu! api
	 */
	public function apiRequest($url)
	{
		$content = file_get_contents($url);
		$content = json_decode($content, true);
		return $content;
	}

	/*
	 * getUserStats(username, mode, key)
	 * Returns the requested user stats
	 */
	public function getUserStats($username, $mode, $key)
	{
		$url = $this->apiurl . 'get_user?u='. $username . '&m=' . $mode . '&k=' . $key;
		return $this->apiRequest($url);
		
	}

	/*
	 * getUserTopScores(username, mode, key)
	 * Returns the top 10 scores from user
	 */
	public function getUserTopScores($username, $mode, $key)
	{
		$url = $this->apiurl . 'get_user_best?u='. $username . '&m=' . $mode . '&k=' . $key;
		return $this->apiRequest($url);
	}

	/*
	 * getBeatmapSet(id, key)
	 * Returns beatmap information
	 */
	public function getBeatmapSet($id, $key)
	{
		$url = $this->apiurl . 'get_beatmaps?s='. $id . '&k=' . $key;
		return $this->apiRequest($url);
	}

	/*
	 * getBeatmapScores(id, key)
	 * Returns the top 50 scores for the specified beatmap
	 */
	public function getBeatmapScores($id, $mode, $key)
	{
		$url = $this->apiurl . 'get_scores?b='. $id . '&m=' . $mode . '&k=' . $key;
		return $this->apiRequest($url);
	}
}

?>