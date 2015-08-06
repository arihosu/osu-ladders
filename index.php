<?php 
include('templates/head.html');
// Container is already closed. All rows must be closed in the same file
?>

<div class="row body">
	<div class="col-lg-12 col-xs-12 center">
		<h3>Insert your ladder key</h3>
		<form action="main/ladder.php" method="POST">
			<input type="text" name="ladderkey" pattern="[A-Za-z0-9\s]{4,16}" placeholder="Your ladderkey" required> <br>
			<input type="submit" value="View ladder">
		</form>
		<p>Don't have a ladder key? <a href="main/create.php">Create one here!</a></p>
	</div>
</div>

<?php 
include ('templates/footer.html');
?>