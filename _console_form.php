<?php

session_start();

require '_protected.php';

$name = "";
if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];	
} else {
    header("Location: admin.php");
}

$ini = parse_ini_file("server/${name}/settings.ini");
if( $ini !== false ) {

	$host = $ini['ip'];
	$port = $ini['port'];

}



if( isset( $_POST['cmd'] ) ){

	$cmd = $_POST['cmd'];
	$a = popen("bash ./runner.sh cmd ${name} ${cmd}", "r");

}

?>

<!DOCTYPE html>
<html>
<body style="margin-top:0; text-align:center;">

	<form method="POST">
        <input type="text" id="cmd" name="cmd">
		<input type="submit" name="cmd" value="Cmd">
	</form>
	
</body>
</html>