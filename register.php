<?php

session_start();

require '_protected.php';

require '_database.php';

$message = '';

if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['permission'])):
	
	// Enter the new user in the database
	$sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
	$stmt = $conn->prepare($sql);

	$stmt->bindParam(':email', $_POST['email']);
	$stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));

	if( $stmt->execute() ):
		$message = 'Successfully created new user';
	else:
		$message = 'Sorry there must have been an issue creating your account';
	endif;

endif;

?>

<!DOCTYPE html>
<html>

	<?php include "_head.php";?>

<body>

	<?php include "_navbar.php";?>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>
	
	<div class="container  jumbotron">
		<h1>Register</h1>

		<form action="register.php" method="POST" class="was-validated">
			
			<input type="text" placeholder="Enter your email" name="email" required>
			<input type="password" placeholder="Password" name="password" required>
			<input type="password" placeholder="Confirm Password" name="confirm_password" required>
			<input type="submit" value="Create">

		</form>
	</div>

</body>
</html>