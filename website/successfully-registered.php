<?php session_start();?>
<!DOCTYPE html>
<html>
	<head>
		<title>You Have registered!</title>
		<meta name="description" content="Congratulations, you've been registered!">
		<meta charset="UTF-8">
	</head>
	<body>
		<p>Hi <?php echo $_SESSION['username']?>! Your access_token is <?php echo $_SESSION['access_token']?></p>
	</body>
</html>