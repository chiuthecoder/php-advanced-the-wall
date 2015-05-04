<?php
require('connection.php');
session_start();
// session_destroy();
// var_dump($_POST);
?>
<html>
<head>
	<title>coding dojo wall</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="header">
		<h1>Coding Dojo Wall</h1>
		<p>Welcome,  <?= $_SESSION['user']['first_name']?></p>
		<form action="process.php" method="post">
			<input type="hidden" name="action" value="logoff">
			<input type="submit" value="Log Off">
		</form>
	</div>

	<h2>Create a message</h2>	
	<form action="process.php" method="post">
		<input type="hidden" name="user_id" value="<?= $_SESSION['user']['id']?>">
		<input type="hidden" name="action" value="create_message">
		<textarea type="text" name="content"></textarea>
		<input type="submit" value="Post a message">
	</form>	
	
	<h2>Messages:</h2>
	<div class="messages">
<?php
$query = "SELECT messages.id, content, users.first_name, users.last_name, messages.created_at, messages.user_id 
FROM messages
LEFT JOIN users
ON users.id = messages.user_id
ORDER BY messages.created_at DESC
";
$messages = fetch_all($query);
foreach ($messages as $message) {
?>
		<!--message loop-->
		<div class="message">
			<h2><?= $message['first_name']." ".$message['last_name']. ", ". $message['created_at']?></h3>	
			<p><?= $message['content']?></p>

			<div class="comments">
<?php
			$query = "SELECT comments.id, comments.message_id, comments.content, first_name, last_name, comments.created_at
			FROM comments
			INNER JOIN users
			ON users.id = comments.user_id
			WHERE comments.message_id = {$message['id']}
			";
			$comments = fetch_all($query);
			foreach ($comments as $comment) {
?>
				<!--comment loop-->
				<div class="comment">
					<h4>comment: <?= $comment['first_name']." ".$comment['created_at'] ?></h4>
					<p><?= $comment['content']?></p>
				</div>
				<!--END comment loop-->
<?php
			}
?>
			</div>
				<h3 class="comments">Post a comment</h3>
				<form class="comments" action="process.php" method="post">
					<input type="hidden" name="action" value="create_comment">
					<input type="hidden" name="message_id" value="<?= $message['id'] ?>">
					<input type="hidden" name="user_id" value="<?= $message['user_id'] ?>">
					<textarea name="content"></textarea>
					<input type="submit" value="Post a comment">
				</form>
		</div>
		<!--END message loop-->
<?php
}
?>
	</div>

<?php
// session_destroy();

?>
</body>
</html>