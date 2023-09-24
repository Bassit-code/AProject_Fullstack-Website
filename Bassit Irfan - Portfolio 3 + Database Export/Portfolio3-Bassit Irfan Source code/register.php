<?php
// Connect to database
require_once('dbconnect.php');

// Checking  if the request method is POST & filters user inputs.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
	$confirm_password = $_POST['confirm-password'];
	$email = $_POST['email'];
	
	//Empty username validation
    if(empty($username)){
        echo"Please enter a username";
    }elseif(empty($email)){
		echo "Please Fill in the email field";
	}	
	//Empty/different password validation
    elseif(empty($password)){
        echo"Please enter a password";
    }elseif ($password !== $confirm_password) {
		echo 'Passwords do not match';
		exit;
	}

	// Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try{
	
        #register user by inserting the user info 
        $stat=$db->prepare("insert into users values(default,?,?,?)");
        $stat->execute(array($username, $hashed_password, $email));
    }
    catch (PDOexception $ex){
        echo "Sorry, a database error occurred! <br>";
        echo "Error details: <em>". $ex->getMessage()."</em>";
     }

	 // Redirect the user to a success page
     header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Registration Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
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
	</style>
</head>
<body>
<h1>Welcome to the registration page!</h1>
    
	<p>You can register below.</p>
	<div class="form-container">
		<h2 style="color: #8F00FF;">Register</h2>
		<form  id="registration-form" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" onsubmit="return validateForm()">
			<label for="username">Username:</label>
			<input type="text" id="username" name="username" required>
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" required>
			<label for="confirm-password">Confirm Password:</label>
			<input type="password" id="confirm-password" name="confirm-password" required>
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" required>
			<input type="submit" value="Register">
			<p>
				Are you an existing user? <a href="login.php">Login here!</a><br><br>
				Or you can simply return to the home page: <a href="index.php">Home</a>
			</p>
		</form>
	</div>
	<script>
		function validateForm() {
		var password = document.getElementById("password").value;
		var confirmPassword = document.getElementById("confirm-password").value;
		if (password !== confirmPassword) {
			alert("Passwords do not match");
			return false;
		}
		return true;
		}
	</script>
</body>
<footer>
      <div class="footer-info">
        <h2>Bassit Irfan</h2>
        <p>220115890@aston.ac.uk</p>
       <p>Copyright © 2023</p>
      </div>
      </footer>
</html>
