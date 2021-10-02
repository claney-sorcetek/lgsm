<?php

session_start();

require '_protected.php';

$_SESSION['name'] = "-";

$fileList = glob('server/*');
$templateList = glob('templates/*');
$amount = count($fileList);

if ( isset( $_POST['create'] ) ){

	$serverName = $_POST['name'];
	$template = $_POST['dropdown'];
	$port = $_POST['port'];

	mkdir("server/${serverName}");
	mkdir("server/${serverName}/backups");
	mkdir("server/${serverName}/files/");
	$file = fopen("server/${serverName}/settings.ini", 'wb');
	fputs($file, "[base]\nid=${amount}\nip=0.0.0.0\nport=${port}\nstart-cmd=foobar\n");
	$zip = new ZipArchive;

    if ( $zip->open( "templates/${template}" ) === TRUE ){
    
        $zip->extractTo("server/${serverName}/files");
        $zip->close();
    
    } else {
    
        echo 'failed';
    
    }
	header("location: admin.php");

}
	
?>

<!DOCTYPE html>
<html>

	<?php include "_head.php";?>

<body>

	<?php include "_navbar.php";?>

	<div class="container  jumbotron">
		<button type="button" class="btn btn-primary" onClick="show()">Create Server</button><br>

		<div class="toast hide" data-autohide="false" animation="true">
			<div class="toast-header">
				<strong class="mr-auto text-primary">New Server</strong>
				<button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
			</div>
			<div class="toast-body">
				<form method="POST" class="was-validated">
					<label for="name">Name:</label><br>  
					<input type="text" id="name" name="name" required><br>
					<label for="port">Port:</label><br>  
					<input type="text" id="port" name="port" required><br>
					<label for="name">Template:</label><br>  
					<select name = "dropdown" required>
						<?php

						foreach($templateList as $templateName){
							$name = str_replace("templates/", "", $templateName); 
							echo "<option value = '${name}'>${name}</option>";
						}

						?>
					</select><br><br>
					<input type="submit" name="create" value="Create">
				</form>
			</div>
		</div>

		<h1>Servers:</h1>

		<div class='container'>
			<table style="width:100%" class="table table-striped">
				<tr>
					<th>ID</th>
					<th>Port</th>
					<th>Status</th>
					<th>Description</th>
				</tr>
				<?php 
					foreach($fileList as $filename){
						echo "<tr>";

						$name = str_replace("server/", "", $filename); 
						$ini = parse_ini_file("server/${name}/settings.ini");
						if( $ini !== false ) {

							$id = $ini['id'];
							$port = $ini['port'];

						}
						echo "<td>#${id}</td>";

						echo "<td>${port}</td>";

						$a = popen("bash ./runner.sh stop ${name}", "r");
						if (is_resource($a)) {
							while($b = fgets($a, 2048)){
								if($b == "started"){
									echo "<td><span class='badge badge-success'>started</span></td>";
								} else {
									echo "<td><span class='badge badge-danger'>stopped</span></td>";
								}
								ob_flush();flush(); 
								pclose($a);
							}	
						}	
						
						echo "<td> <a href='_server.php?name=${name}'> ${name} </a> </td>"; 

						echo "</tr>";
					}
				?>
			</table> 
		</div>
	</div>

</body>
<script>
	function show(){
		$('.toast').toast('show');
	};
</script>
</html>