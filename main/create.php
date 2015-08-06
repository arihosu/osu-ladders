<?php 
include('../templates/head.html');
// Container is already closed. All rows must be closed in the same file
?>

<div class="row body">
	<div class="col-lg-12 col-xs-12 center">
		<h3>Create a ladder</h3>
		<form action="createdo.php" method="GET">
			<p>The ladder can be viewed by anyone with the key. 16 characters max. <br>No symbols. Spaces are allowed. <em>Case-insensitive</em></p>
			<input type="text" name="ladderkey" placeholder="Key name" pattern="[A-Za-z0-9\s]{4,16}" required> <br>
			<input type="submit" value="Create key">
        </form>
        <div class="goback">
        	<a href="/ladder/">Go back</a>
        </div>
	</div>
</div>

<?php 
include ('../templates/footer.html');
?>