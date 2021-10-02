<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: admin.php");
}

require '_database.php';

if(!empty($_POST['email']) && !empty($_POST['password'])):
	
	$records = $conn->prepare('SELECT id,email,password FROM users WHERE email = :email');
	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

   if(count($results) > 0 && password_verify($_POST['password'], $results['password']) ) {
		
		$_SESSION['user_id'] = $results['id'];
		header("Location: admin.php");
	
	} else {

		$message = 'Sorry, those credentials do not match';
	
	}

endif;

?>

<!DOCTYPE html>
<html>

	<?php include "_head.php";?>

<body> 

	<div class="container jumbotron">
		<?php if(!empty($message)): ?>
			<p><?= $message ?></p>
		<?php endif; ?>

		<h1>Login</h1>

		<form action="index.php" method="POST">
			
			<input type="text" placeholder="Enter your email" name="email">
			<input type="password" placeholder="and password" name="password">

			<input type="submit" value="Login">

		</form>
	</div>

</body>
</html>