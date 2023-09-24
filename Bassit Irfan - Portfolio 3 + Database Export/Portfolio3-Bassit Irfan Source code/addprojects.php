<?php
// Start the session, check if the user is not logged in, redirect to start.
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

// Connect to database.
require_once('dbconnect.php');



// Display Welcome Message to user.
$username = $_SESSION['username'];
echo "<h2>Welcome $username!</h2>";

// Get the user ID
$query = "SELECT uid FROM users WHERE username = ?";
$stmt = $db->prepare($query);
$stmt->execute([$username]);
$user = $stmt->fetch();
$uid = $user['uid'];

// Check if the form has been submitted, then add the new project to the database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(empty($start_date)) {
        $error_msg = 'Please enter a start date.';
    }

	if(empty($end_date)) {
        $error_msg = 'Please enter a start date.';
    }
  try {
    // Prepare an insert statement
    $query = "INSERT INTO projects (title, start_date, end_date, phase, description, uid)
              VALUES (:title, :start_date, :end_date, :phase, :description, :uid)";
    $stmt = $db->prepare($query);
    // Bind parameters
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->bindParam(':phase', $phase);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':uid', $uid);
    // Set parameters
    $title = $_POST['title'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $phase = $_POST['phase'];
    $description = $_POST['description'];
    // Execute the statement
    $stmt->execute();
    echo "<p>The project has been added successfully!</p>";
  } catch (PDOException $ex) {
    echo "Sorry, a database error occurred! <br>";
    echo "Error details: <em>" . $ex->getMessage() . "</em>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add projects</title>
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
		#start_date {
		border: 1px solid #ccc;
		border-radius: 5px;
		padding: 10px;
		font-size: 16px;
		color: #555;
		background-color: #fff;
}

		#end_date {
		border: 1px solid #ccc;
		border-radius: 5px;
		padding: 10px;
		font-size: 16px;
		color: #555;
		background-color: #fff;
}

		.textarea-field{
			height: 150px;
			width: 400px;
			padding-top: 10px;
			border-radius: 10px 20px;
			
		}

		#phase{
		border: 1px solid #ccc;
		border-radius: 5px;
		padding: 10px;
		font-size: 16px;
		color: #555;
		background-color: #fff;
		}

		.button-container {
			position: absolute;
			top: 0;
			right: 0;
			margin: 20px;
			display: flex;
			align-items: center;
		}

		.view-projects-btn {
			background-color: #8F00FF;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
			margin-right: 10px;
		}

		.logout-btn {
			background-color: #fff;
			color: #8F00FF;
			border: 2px solid #8F00FF;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
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
		<div class="button-container">
		<a href="index.php"><button class="view-projects-btn">View Projects</button></a>
		<a href="login.php"><button class="logout-btn">Log out</button></a>
	
		</div>
    
		<h1>Welcome to the Add Projects Page</h1>

    <p>Here you can add new projects!</p>
    <div class="form-container">
		<h2 style="color: #8F00FF;">Add a new project</h2>
		<form action="addprojects.php" method="post">
			<label for="title">Project Title:</label>
			<input type="text" id="title" name="title" required>
            <label for="start-date">Start Date:</label>
            <input type="date" id="start_date" name="start_date">
            <label for="end-date">End Date:</label>
            <input type="date" id="end_date" name="end_date">
            <label for="new_project_phase">New Project Phase:</label>
			<select id="phase" name="phase" required>
				<option value="">Select Status</option>
				<option value="design">design</option>
				<option value="development">development</option>
				<option value="testing">testing</option>
				<option value="deployment">deployment</option>
				<option value="complete">complete</option>
			</select>
			<label for="new_project_phase">Description:</label>
			<textarea class="entryField textarea-field" name="description"></textarea><br><br>
			<input type="submit" value="Add Project">
			
		</form>
	</div>
</body>
<footer>
      <div class="footer-info">
        <h2>Bassit Irfan</h2>
        <p>220115890@aston.ac.uk</p>
       <p>Copyright © 2023</p>
      </div>
      </footer>
</html>	