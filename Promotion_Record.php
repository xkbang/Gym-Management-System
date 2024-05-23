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

$currentMonth = date('m');
$currentYear = date('Y');
$startDate = "$currentYear-$currentMonth-01";
$endDate = date('Y-m-t', strtotime($startDate));

if (isset($_GET['month']) && isset($_GET['year'])) {
    $targetMonth = $_GET['month'];
    $targetYear = $_GET['year'];
    $startDate = "$targetYear-$targetMonth-01";
    $endDate = date('Y-m-t', strtotime($startDate));
}

// Calculate previous month and next month values
$prevMonth = date('m', strtotime('-1 month', strtotime($startDate)));
$prevYear = date('Y', strtotime('-1 month', strtotime($startDate)));
$nextMonth = date('m', strtotime('+1 month', strtotime($startDate)));
$nextYear = date('Y', strtotime('+1 month', strtotime($startDate)));

$query = "SELECT p.*, s.first_name, s.last_name 
      FROM promotion p 
      JOIN staff s ON p.staff_id = s.staff_id 
      WHERE (p.start_date BETWEEN '$startDate' AND '$endDate') 
      OR (p.end_date BETWEEN '$startDate' AND '$endDate')";
$result = $connection->query($query);

?>


<!DOCTYPE html>
<html>
<head>
    <title>Promotion Dashboard</title>
    <style>
       body {
           background-color: #f2f2f2;
           font-family: Arial, sans-serif;
           margin: 0;
           padding: 20px;
       }

       .container {
           max-width: 800px;
           margin: 0 auto;
           background-color: #ffffff;
           padding: 20px;
           border-radius: 5px;
           box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
       }

       h2 {
           text-align: center;
           margin-bottom: 20px;
       }

       table {
           width: 100%;
           border-collapse: collapse;
           margin-bottom: 20px;
       }

       th,
       td {
           padding: 8px;
           text-align: left;
           border-bottom: 1px solid #ddd;
       }

       th {
           background-color: #f2f2f2;
       }

       .navigation {
           display: flex; /* Added */
           justify-content: center; /* Added */
           align-items: center; /* Added */
           margin-bottom: 20px;
       }

       .navigation a {
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

       .navigation a:hover {
           background-color: #45a049;
       }

       /* Styling for add a new record button */
       .navigation .add-button {
           background-color: #4CAF50;
           color: #ffffff;
           padding: 10px 20px;
           text-decoration: none;
           border-radius: 4px;
           transition: background-color 0.3s;
           margin-left: 10px; /* Modified */
       }

       .navigation .add-button:hover {
           background-color: #45a049;
       }
   </style>
</head>
<body>
    <div class="container">
        <h2>Promotion Events for <?php echo date('F Y', strtotime($startDate)); ?></h2>
        <?php if ($result->num_rows > 0) : ?>
            <table>
                <tr>
                    <th>Promotion Name</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Person in Charge</th>
                    <th>Actions</th> <!-- Added column for buttons -->
                </tr>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row["promotion_name"]; ?></td>
                        <td><?php echo $row["promotion_description"]; ?></td>
                        <td><?php echo $row["start_date"]; ?></td>
                        <td><?php echo $row["end_date"]; ?></td>
                        <td><?php echo $row["first_name"] . " " . $row["last_name"]; ?></td>
                        <td>
                            <form action="edit_promotion.php" method="post">
                                <input type="hidden" name="promotion_id" value="<?php echo $row['promotion_id']; ?>">
                                <input type="submit" name="edit" value="Edit">
                            </form>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="hidden" name="promotion_id" value="<?php echo $row['promotion_id']; ?>">
                                <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this promotion record?');">
                            </form>
                            

                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Check if the delete button was clicked
                    if (isset($_POST['delete'])) {
                        $promotionID = $_POST['promotion_id'];

                        // Perform the deletion query or call a function to delete the promotion record
                        $deleteQuery = "DELETE FROM promotion WHERE promotion_id = $promotionID";
                        $deleteResult = $connection->query($deleteQuery);

                        if ($deleteResult) {
                            // Deletion successful
                            echo "<script>alert('Promotion record deleted successfully.');</script>";
                        } else {
                            // Deletion failed
                            echo "<script>alert('Failed to delete promotion record.');</script>";
                        }

                        // Redirect back to the promotion list or show a success message
                        echo "<script>window.location.href = 'Promotion_Record.php';</script>";
                    }
                }

                
                
                
                
                
                ?>
            </table>
        <?php else : ?>
            <p>No promotion events found for <?php echo date('F Y', strtotime($startDate)); ?></p>
        <?php endif; ?>

        <div class="navigation">
            <?php
            $prevDate = date('Y-m', strtotime('-1 month', strtotime($startDate)));
            $nextDate = date('Y-m', strtotime('+1 month', strtotime($startDate)));
            ?>
            <a href="Promotion_Record.php?month=<?php echo substr($prevDate, 5, 2); ?>&year=<?php echo substr($prevDate, 0, 4); ?>">Previous Month</a>
            <a href="Promotion_Record.php?month=<?php echo substr($nextDate, 5, 2); ?>&year=<?php echo substr($nextDate, 0, 4); ?>">Next Month</a>
            <form action="edit_promotion.php" method="post">
                <input type="hidden" name="add" value="add">
                <input type="submit" name="submit" value="Add a new record" class="add-button">
            </form>
        </div>

        <div class="navigation">
            <a href="Dashboard_staff.php" class="button">Go back to the Homepage</a>
            <a href="Maintenance.php" class="button">Go to Maintenance</a>
        </div>
    </div>
</body>
</html>