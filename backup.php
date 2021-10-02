<?php

session_start();

require '_protected.php';
include 'ZipMaster.php';

$name = "";
if ($_SESSION['name'] !== "-") {
	
    $name = $_SESSION['name'];	

} else {

    header("Location: admin.php");

}

$fileList = glob("server/${name}/backups/*");

if( isset( $_GET['backup'] ) ){

    $zip = new ZipMaster\ZipMaster("server/${name}/backups/".date("j-m-Y_G-i").'.zip', "server/${name}/files");
    $zip->archive();
    header('Location: backup.php');

} else if( isset( $_GET['rollback'])){

    //Check if the user really wants to rollback
    $zip = new ZipArchive;

    if ( $zip->open( $_GET['rollback'] ) === TRUE ){
    
        $zip->extractTo("server/${name}/files");
        $zip->close();
    
    } else {
    
        echo 'failed';
    
    }

} else if( isset( $_GET['delete'])){
    
    unlink($_GET['delete']);
    header('Location: backup.php');

}


?>

<!DOCTYPE html>
<html>

	<?php include "_head.php";?>

<body>

	<?php include "_navbar.php";?>

	<div class="container  jumbotron">
		<h1>Backup - <?php echo $name; ?></h1>
        <a href="backup.php?backup=true" class="btn btn-info">Backup</a><br><br>
		
        <?php foreach($fileList as $path){?>
			<?php 
				$fileName = basename($path);
            ?>
			<i class='fas fa-file'></i>
            <b><?php echo $fileName;?></b><br>
            <a href='backup.php?rollback=<?php echo$path;?>' class='btn btn-success'> Rollback </a>
            <a href='backup.php?delete=<?php echo$path;?>' class='btn btn-danger'> Delete </a><br><br>
		<?php } ?>
	</div>

</body>
</html>