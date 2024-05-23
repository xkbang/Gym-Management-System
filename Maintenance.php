<?php

session_start();
require_once "login.php";
$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) {
    die("Fatal Error");
}

$staffID = $_SESSION["id"];
$query = "SELECT e.*, s.first_name, s.last_name, 
          TIMESTAMPDIFF(MONTH, e.maintenance_history, CURDATE()) >= 6 AS maintenance_required
          FROM equipment e 
          JOIN staff s ON e.staff_id = s.staff_id ORDER BY `e`.`maintenance_history` ASC";
$result = $connection->query($query);

// Check if a search query is provided
if (isset($_GET['search_query'])) {
    $searchQuery = trim($_GET['search_query']);
    // Modify the original query to include the search condition
    $query = "SELECT *, TIMESTAMPDIFF(MONTH, e.maintenance_history, CURDATE()) >= 6 AS maintenance_required 
              FROM equipment e
              JOIN staff s ON e.staff_id = s.staff_id
              WHERE equipment_name LIKE '%$searchQuery%'";
    $result = $connection->query($query);
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Equipment Maintenance</title>
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

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .search-form {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .search-input {
            padding: 8px;
            width: 300px;
            border-radius: 5px 0 0 5px;
            border: 1px solid #ccc;
        }

        .search-submit {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .navigation {
            margin-top: 20px;
            text-align: center;
        }

        .button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .add-button {
            margin-left: 10px;
        }

    </style>
</head>
<body>
    <form action="Maintenance.php" method="get">
    <label for="search_query">Search Equipment:</label>
    <input type="text" name="search_query" required>
    <input type="submit" value="Search">
    </form>
    <div class="container">
        <h2>Equipment Maintenance Records</h2>
        <p>Please note that the equipment in the gym needs maintenance every six months</p>
        <?php if ($result->num_rows > 0) : ?>
            <table>
                <tr>
                    <th>Equipment ID</th>
                    <th>Equipment Name</th>
                    <th>Equipment Type</th>
                    <th>Maintenance History</th>
                    <th>Purchase Date</th>
                    <th>Maintenance Required</th>
                    <th>Person in Charge</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row["equipment_id"]; ?></td>
                        <td><?php echo $row["equipment_name"]; ?></td>
                        <td><?php echo $row["equipment_type"]; ?></td>
                        <td><?php echo $row["maintenance_history"]; ?></td>
                        <td><?php echo $row["purchase_date"]; ?></td>
                        <td><?php echo $row["maintenance_required"] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row["first_name"] . " " . $row["last_name"]; ?></td>
                        <td>
                            <form action="edit_equipment.php" method="post">
                                <input type="hidden" name="equipment_id" value="<?php echo $row['equipment_id']; ?>">
                                <input type="submit" name="edit" value="Edit">
                            </form>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="hidden" name="equipment_id" value="<?php echo $row['equipment_id']; ?>">
                                <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this equipment record?');">
                            </form>
                            

                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Check if the delete button was clicked
                    if (isset($_POST['delete'])) {
                        $equipmentID = $_POST['equipment_id'];

                        // Perform the deletion query or call a function to delete the promotion record
                        $deleteQuery = "DELETE FROM equipment WHERE equipment_id = $equipmentID";
                        $deleteResult = $connection->query($deleteQuery);

                        if ($deleteResult) {
                            // Deletion successful
                            echo "<script>alert('equipment record deleted successfully.');</script>";
                        } else {
                            // Deletion failed
                            echo "<script>alert('Failed to delete equipment record.');</script>";
                        }

                        // Redirect back to the promotion list or show a success message
                        echo "<script>window.location.href = 'Maintenance.php';</script>";
                    }
                }

                
                
                
                
                
                ?>
            </table>
        <?php else : ?>
            <p>No equipment maintenance records found.</p>
        <?php endif; ?>

        <div class="navigation">
            <div class="button-container">
                <a href="Dashboard_staff.php" class="button">Go back to the Homepage</a>
                <a href="Promotion_Record.php" class="button">Go to Promotions</a>
                <form action="edit_equipment.php" method="post" class="add-button">
                    <input type="hidden" name="add" value="add">
                    <input type="submit" name="submit" value="Add" class="button">
                </form>
            </div>
        </div>
    </div>
</body>
</html>