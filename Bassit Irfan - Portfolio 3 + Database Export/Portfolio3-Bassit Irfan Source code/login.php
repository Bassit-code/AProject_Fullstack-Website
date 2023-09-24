<?php

session_start();
require_once('dbconnect.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        header('Location: addprojects.php');
        exit;
    } else {
        $error = "Incorrect username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="style.css">
    <style>
		body {
			background-color: #f7f7f7;
			font-family: Arial, sans-serif;
			color: #444444;
			margin: 0;
			padding: 0;
		}
		h1 {
			font-size: 36px;
			margin-top: 50px;
			text-align: center;
			color: #8F00FF;
		}
		p {
			font-size: 18px;
			margin-top: 20px;
			text-align: center;
			color: #8F00FF;
		}
		input[type="submit"] {
		background-color: #8F00FF;
		}
		footer {
            
            background-color: black;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin-top: 10%;
        }

        .footer-info h2{
            margin-right: 5%;
            font-family: sans-serif;
            font-size: 30px;
        }

        .footer-info p{
            margin-right: 5%;
            margin-top: 1%;
            font-family: sans-serif;
        }
		.error{
			color: red;
		}
	</style>
</head>
<body>

    <h1>Welcome to the login page!</h1>
    
	<p>Thank you for registering. You can now log below in using your username and password.</p>
	<div class="form-container">
		<h2 style="color: #8F00FF;">Login</h2>
		<form action="login.php" method="post">
			<label for="username">Username:</label>
			<input type="text" name="username" required>

			<label for="password">Password:</label>
			<input type="password" name="password" required>

			<input type="submit" value="Login">
			<p>
				Not registered yet? <a href="register.php">Register today!</a><br><br>
				Or you can simply return to the home page: <a href="index.php">Home</a>
			</p>
		</form>
        <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>
	</div>
	<footer>
      <div class="footer-info">
        <h2>Bassit Irfan</h2>
        <p>220115890@aston.ac.uk</p>
       <p>Copyright © 2023</p>
      </div>
      </footer>
</body>
</html>
