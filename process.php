<?php
require('connection.php');
session_start();

if(isset($_POST['action']) && $_POST['action'] == 'login')
{
	$query = "SELECT * FROM users WHERE email = '{$_POST['email']}' AND password = '{$_POST['password']}'";
		$result = fetch_record($query);	
		if($result){
			$_SESSION['user'] = $result;
			header('location: wall.php');
			exit();
		}
		else{
			header('Location: index.php');
			exit();
		}

}

elseif(isset($_POST['action']) && $_POST['action'] == 'registration')
{
	// COLLECT ERRORS
	$errors = array();
	if(empty($_POST['first_name'])){
		$errors[] = "first name can't be blank.";
	}
	if(empty($_POST['last_name'])){
		$errors[] = "last name can't be blank.";
	}
	if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$errors[] = "your email is blank or is invalid.";
	}
	if(empty($_POST['password'])){
		$errors[] = "password can't be blank.";
	}
	// IF ERRORS EXIST
	if(count($errors) > 0)
	{
		//if there are errors, assign the session variable
		$_SESSION['errors'] = $errors;
		header('Location: index.php');
		exit();
	}
	//ERRORS DON'T EXIST
	else
	{		
		// var_dump($_POST);
		// die('here');
		$query = "INSERT INTO users (first_name, last_name, email, password, confirm_password, created_at, updated_at) 
		VALUES ('{$_POST['first_name']}','{$_POST['last_name']}','{$_POST['email']}','{$_POST['password']}','{$_POST['confirm_password']}',NOW(),NOW() )";
		run_mysql_query($query);
		$_SESSION['success'] = $_POST['first_name']. ", You have successfully registered, please login to continute.";
		header('Location: index.php');
		exit();	
	}
}
elseif(isset($_POST['action']) && $_POST['action'] == 'create_message')
{

	$query = "INSERT INTO messages (user_id, content, created_at, updated_at) 
	VALUES ('{$_POST['user_id']}','{$_POST['content']}',NOW(),NOW() )";
	run_mysql_query($query);
	header('Location: wall.php');
	exit();	

}
elseif(isset($_POST['action']) && $_POST['action'] == 'create_comment')
{
	$query = "INSERT INTO comments (message_id, user_id, content, created_at, updated_at) 
	VALUES ('{$_POST['message_id']}','{$_POST['user_id']}', '{$_POST['content']}',NOW(),NOW() )";
	run_mysql_query($query);
	header('Location: wall.php');
	exit();	

}

elseif(isset($_POST['action']) && $_POST['action'] == 'logoff')
{
		header('Location: index.php');

		exit();
}
?>