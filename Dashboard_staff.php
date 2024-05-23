<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
            margin-right: 10px;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            session_start();
            require_once "login.php";
            $connection = new mysqli($hn, $un, $pw, $db);

            if ($connection->connect_error) {
                die("Fatal Error");
            }

            $staffID = $_SESSION["id"];
            $query = "SELECT * FROM staff WHERE staff_id = $staffID";
            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $staff_name = $row["first_name"] . " " . $row["last_name"];

                echo "<h1>Welcome, $staff_name</h1>";

                // Add button to go to Promotion_Record.php
                

            }
            ?>
        
        <div class="button-container">
            <a href="Member.php" class="button">Member info</a>
            <a href="staff_info.php" class="button">Staff info</a>
            <a href="Promotion_Record.php" class="button">Promotion Record</a>
            <a href="Maintenance.php" class="button">Maintenance Record</a>
            <a href="CourseAnalytics.php" class="button">Course and User Analytics</a>
            
        </div>
        

        
    </div>
</body>
</html>