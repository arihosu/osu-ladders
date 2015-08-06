<?php 
include('../templates/head.html');
include('ladder/Core.php');
?>

<div class="row body">
    <div class="col-lg-12 col-xs-12">

<?php 

$do = new Datab();
$core = new Core();
if (isset($_POST['ladderkey']))
{
	$ladderkey = $_POST['ladderkey'];
} else 
{
	$ladderkey = $_GET['ladderkey'];
}
$check = $do->ladderCheck($ladderkey);

switch ($check)
{
	case 'ladder-invalid':
		include('../templates/invalid.html');
		break;
	case 'ladder-exists':
		include('../templates/exists.html');
		$core->printTable($ladderkey);
		include('../templates/exists-footer.php');
		break;
	case 'ladder-create':
		include('../templates/create.html');
		break;
}
?>

	</div>
</div>

<?php 
include('../templates/footer.html');
?>