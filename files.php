<?php

session_start();

require '_protected.php';

$name = "";
if ($_SESSION['name'] !== "-") {
	
    $name = $_SESSION['name'];	

} else {

    header("Location: admin.php");

}

if( isset( $_GET['query'] ) ){
	
	$dirName = $_GET['query'];

}

if( isset( $_POST['query'] ) ){

	$dirName = $_POST['query'];

}
if ( isset($dirName) && strpos($dirName, '.') !== false ){
	
	if(  isset( $_POST['update'] ) ){

		$edit = $_POST['text'];
		$myfile = fopen( $dirName, "w" ) or die("Unable to open file!");
		fwrite($myfile, $edit);
		fclose($myfile);

	}

	if( file_exists( $dirName )){

		$myfile = fopen( $dirName, "r" ) or die("Unable to open file!");
		$lines = '';
		while(!feof($myfile)) {
			$line = fgets($myfile);
			$lines .= "${line}";
		}
		fclose($myfile);
			
	}

} else if( isset($dirName) ){

	include "_head.php";
    $fileList = glob("${dirName}/*");

} else {

    $fileList = glob("server/${name}/*");

}


?>

<!DOCTYPE html>
<html>

	<?php include "_head.php";?>

<body>

	<?php include "_navbar.php";?>

	<div class="container  jumbotron">
		<h1>Files - <?php echo $name; ?></h1>
		
		<?php if(! isset($myfile)): ?>
			<?php foreach($fileList as $path){?>
				<?php if( is_file($path) ): ?>
					<?php 
						$fileName = basename($path);
						echo "<i class='fas fa-file'></i>";
						echo "<a href='files.php?query=${path}'> ${fileName} </a>", "<br>";
					?>
				<?php else: ?>
					<?php
						$dirName = basename($path);
						echo "<i class='fas fa-folder-open'></i>";
						echo "<a href='files.php?query=${path}'> ${dirName} </a>", "<br>";
					?>
				<?php endif; ?>
			<?php } ?>
		<?php else: ?>
			<textarea rows="20" cols="90" name="text" form="settings"><?php echo $lines ?></textarea>
			<form method="POST" id="settings">
				<input hidden type="text" name="query" value="<?php echo $dirName;?>">
				<input type="submit" name="update" value="Update">
			</form>
		<?php endif; ?>
	</div>

</body>
</html>