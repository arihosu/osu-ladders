<?php 
include('ladder/Core.php');
$db = new Datab();
$core = new Core();
if (isset($_GET['ladderkey']))
{
	// Create ladder key
	$ladderkey = $_GET['ladderkey'];
	$check = $db->ladderCheck($ladderkey);
	if ($check == 'ladder-create' || $check == 'ladder-exists')
	{
		echo "Someone took that ladder name!";
		return 1;
	}
	$db->createKey($ladderkey);
	header('Location: /ladder/main/ladder.php?ladderkey=' . $ladderkey);

} elseif (isset($_POST['ladderkey'])) 
{
	// Create ladder?
	$mode = $_POST['mode'];
	$ladderkey = $_POST['ladderkey'];
	$usernames = array($_POST['username1'],
		$_POST['username2'],
		$_POST['username3'],
		$_POST['username4'],
		$_POST['username5']
		);
	$core->putStatsInDb($usernames, $mode, $ladderkey);
	$db->useKey($ladderkey);
	header('Location: /ladder/main/ladder.php?ladderkey=' . $ladderkey);
}
?>