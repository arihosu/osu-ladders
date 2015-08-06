<?php 
include('ladder/Core.php');
$ladderkey = $_POST['ladderkey'];
$do = new Core();
$db = new Datab();
$data = $db->getUsersFromKey($ladderkey);

$db->clearLadder($ladderkey);
$do->putStatsInDb($data, $data['mode'], $ladderkey);
header('Location: /ladder/main/ladder.php?ladderkey=' . $ladderkey);
?>