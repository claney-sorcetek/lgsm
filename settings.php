<?php

session_start();

require '_protected.php';

$name = "";
if ($_SESSION['name'] !== "-") {
    $name = $_SESSION['name'];	
} else {
    header("Location: admin.php");
}

$fileName = "server/${name}/settings.ini";	
if(  isset( $_POST['update'] ) ){

	$edit = $_POST['text'];
	$myfile = fopen( $fileName, "w" ) or die("Unable to open file!");
	fwrite($myfile, $edit);
	fclose($myfile);
	header("Location: settings.php");

} else {
	
	if( file_exists( $fileName )){

		$myfile = fopen( $fileName, "r" ) or die("Unable to open file!");
		$lines = '';
		while(!feof($myfile)) {
			$line = fgets($myfile);
			$lines .= "${line}";
		}
		fclose($myfile);
			
	}

}

?>

<!DOCTYPE html>
<html>

	<?php include "_head.php";?>

<body>

	<?php include "_navbar.php";?>

	<div class="container jumbotron">
		<h1>Settings - <?php echo $name; ?></h1>

		<textarea rows="20" cols="90" name="text" form="settings"><?php echo $lines ?></textarea>
		<form method="POST" id="settings">
  			<input type="submit" name="update" value="Update">
		</form>
	</div>

</body>
</html>