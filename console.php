<?php

session_start();

require '_protected.php';

$name = "";
if ($_SESSION['name'] !== "-") {
    $name = $_SESSION['name'];	
} else {
    header("Location: admin.php");
}

$ini = parse_ini_file("server/${name}/settings.ini");
if( $ini !== false ) {

	$cmd = $ini['start-cmd'];

}

$a =  null;
if( isset($_GET['action'])){
	if($_GET['action'] == 'start'){
		$a = popen("bash ./runner.sh start ${name} ./server/${name}/files/${cmd}", "r");
		header("Location: console.php");
	} else if($_GET['action'] == 'stop'){
		$a = popen("bash ./runner.sh stop ${name}", "r");
		header("Location: console.php");
	}
} else {
	$a = popen("bash ./runner.sh console ${name}", "r");
}

?>

<!DOCTYPE html>
<html>
<head>

	<?php include "_head.php";?>

</head>
<body>

    <?php include "_navbar.php";?>

	<div class="container  jumbotron">
		
	<div class="container">
		<a href="console.php?action=start" class="btn btn-success">Start</a>
		<a href="console.php?action=stop" class="btn btn-danger">Stop</a>
	</div>

		<h1>Console - <?php echo $name; ?></h1>

		<textarea rows=30% cols=100% name="text" disabled="yes"><?php
			
			if (is_resource($a)) {
				while($b = fgets($a, 2048)) { 
					echo $b."\n"; 
					ob_flush();flush(); 
				}
				pclose($a); 
			}

		?>
    	</textarea>
		<iframe id="form-iframe" src="_console_form.php" style="margin:0; width:100%; height:150px; border:none; overflow:hidden;" scrolling="no" onload="AdjustIframeHeightOnLoad()"></iframe>

	</div>
	
	<script type="text/javascript">
		function AdjustIframeHeightOnLoad() { document.getElementById("form-iframe").style.height = document.getElementById("form-iframe").contentWindow.document.body.scrollHeight + "px"; }
		function AdjustIframeHeight(i) { document.getElementById("form-iframe").style.height = parseInt(i) + "px"; }
	</script>
</body>
</html>