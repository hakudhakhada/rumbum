<?php

include('conn.php');

session_start();

$message = '';

if(isset($_SESSION['user_id']))
{
	header('location:index.php');
}

if(isset($_POST['login']))
{
	$email = $_POST["useremail"];
	$password = md5($_POST["password"]);

	$query = mysqli_query($conn,"SELECT * FROM login WHERE email = '".$email."' AND password = '".$password."'");
	$count = mysqli_num_rows($query);

	if($count > 0)
	{
		$row = mysqli_fetch_assoc($query);

		$_SESSION['user_id'] = $row['user_id'];
		$_SESSION['username'] = $row['username'];

		header('location:index.php');
	}
	else
	{
		$message = '<label>Wrong Email or Password</labe>';
	}
}


?>

<html>  
    <head>  
        <title>Chat Application</title>  
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>  
    <body>  
        <div class="container">
			<br />
			<h3 align="center">Chat Application</h3><br />
			<br />
			<div class="panel panel-default">
  				<div class="panel-heading">User Login</div>
				<div class="panel-body">
					<p class="text-danger"><?php echo $message; ?></p>
					<form method="post">
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="useremail" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control" required />
						</div>
						<div class="form-group">
							<input type="submit" name="login" class="btn btn-info" value="Login" />
						</div>
					</form>
				</div>
			</div>
		</div>
    </body>  
</html>