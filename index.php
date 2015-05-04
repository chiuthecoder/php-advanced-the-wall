<?php
session_start();

if(isset($_SESSION['errors']))
{
	foreach($_SESSION['errors'] as $error)
	{
		echo "<p class='red'>" . $error . "</p>";
	}
	session_unset();
}	
if(isset($_SESSION['success']))
{	
	echo "<p class='green'>". $_SESSION['success'] . "</p>";
	session_unset();
}

?>

<html>
<head>
	<title>Wall-login</title>
	<link rel="stylesheet" href="style.css">

</head>
<body>
	<h2>Login</h2>
	<form action="process.php" method="post">
		<input type="hidden" name="action" value="login">
		<input type="text" name="email" placeholder="email">
		<input type="password" name="password" placeholder="password">
		<input type="submit" value="Submit">
	</form>
	<hr>
	<h2>Register</h2>
	<form action="process.php" method="post">
		<input type="hidden" name="action" value="registration">
		<input type="text" name="first_name" placeholder="first name">
		<input type="text" name="last_name" placeholder="last name">
		<input type="text" name="email" placeholder="email">
		<input type="password" name="password" placeholder="password">
		<input type="password" name="confirm_password" placeholder="confirm password">
		<input type="submit" value="Submit">
	</form>
</body>
</html>