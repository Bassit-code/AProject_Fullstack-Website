<?php
require_once('dbconnect.php');

// Check if the search form has been submitted
if (isset($_POST['search'])) {
    // Get the search term and sanitize it
    $search_term = filter_var($_POST['search_term'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Prepare the SQL query to search for projects with matching title or start date
    $stmt = $db->prepare('SELECT title, start_date, description FROM projects WHERE title LIKE :search_term OR DATE_FORMAT(start_date, "%Y/%m/%d") LIKE :search_term');


    // Bind the search term to the prepared statement
    $stmt->bindValue(':search_term', "%$search_term%");

    // Execute the query
    $stmt->execute();

    // Fetch the results as an associative array
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!-- Display the search form and search results -->
<head>
    <title>Home</title>
    <style>
        .header {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .button-container {
            display: flex;
        }
        .button-container button {
            background-color: #8F00FF;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
        .button-container a:first-child button {
            background-color: #fff;
			color: #8F00FF;
			border: 2px solid #8F00FF;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
        }

        h1 {
			font-size: 36px;
			margin-top: 50px;
			text-align: center;
			color: #8F00FF;
            text-shadow: 5px 0px 5px #8F00FF;
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
    <div class="header">
        <div class="button-container">
            <a href="register.php"><button>Register</button></a>
            <a href="login.php"><button>Login</button></a>
        </div>
    </div>
<link rel="stylesheet" href="style.css">

<div style="max-width: 600px; margin: 0 auto;">
<h1>Welcome to AProject</h1>
    <h2 style="font-family: sans-serif;">Search Projects</h2>
    <form action="index.php" method="post">
        <!-- Make sure to use the format shown in the brackets using / to separate the values for i.e. = 2023/04/20 -->
        <label for="search_term", style="font-family: sans-serif;">Search by title or start date (use YYYY/MM/DD format for start date):</label>
        <input type="text" id="search_term" name="search_term">
        <button type="submit" name="search">Search</button>
    </form>
        <h2>Newly added projects:</h2>
    
    <!-- Search results will be displayed at the top in a different colour with the other projects under them -->
    <?php if (isset($_POST['search']) && !empty($projects)): ?>
        <h3>Search Results:</h3>
        <?php foreach ($projects as $project): ?>
            <div style="background-color: #f5f5f5; padding: 20px; margin-bottom: 20px; border-radius: 10px 10px; box-shadow: 2px 2px 10px #00FF00, 2px 2px 15px black; font-family: sans-serif; border: 2px solid #00FF00;">
                <h2 style="margin-top: 0;"><?php echo $project['title']; ?></h2>
                <p><strong>Starting date:</strong> <?php echo $project['start_date']; ?></p>
                <p><strong>Short description:</strong> <?php echo $project['description']; ?></p>
            </div>
        <?php endforeach; ?>
    <?php elseif (isset($_POST['search']) && empty($projects)): ?>
        <p>No results found.</p>
    <?php endif; ?>
    <?php
require_once('dbconnect.php');

// Prepare the SQL query
$stmt = $db->prepare('SELECT title, start_date, description FROM projects');

// Execute the query
$stmt->execute();

// Fetch the results as an associative array
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Display the project information with some inline CSS for styling -->
<div style="max-width: 600px; margin: 0 auto;">
    <?php foreach ($projects as $project) : ?>
        <div style="background-color: #f5f5f5; border-radius: 10px 10px; box-shadow: 2px 2px 10px #8F00FF, 2px 2px 15px black; font-family: sans-serif; border: 2px solid #8F00FF; padding: 20px; margin-bottom: 20px;">
            <h2 style="margin-top: 0;"><?php echo $project['title']; ?></h2>
            <p><strong>Starting date:</strong> <?php echo $project['start_date']; ?></p>
            <p><strong>Short description:</strong> <?php echo $project['description']; ?></p>
        </div>
    <?php endforeach; ?>
</div>
</div>
<footer>
      <div class="footer-info">
        <h2>Bassit Irfan</h2>
        <p>220115890@aston.ac.uk</p>
       <p>Copyright © 2023</p>
      </div>
      </footer>
      </body>
