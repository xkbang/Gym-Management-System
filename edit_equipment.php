<?php

session_start();
require_once "login.php";
$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) {
    die("Fatal Error");
}
$staffID = $_SESSION["id"];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit'])) {
        $equipmentID = $_POST['equipment_id'];

        // Retrieve the equipment record from the database
        $query = "SELECT * FROM equipment WHERE equipment_id = $equipmentID";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Display the edit form with the existing equipment details
            displayEditForm($row);
        } else {
            echo "Equipment record not found.";
        }
    } elseif (isset($_POST['update'])) {
        $equipmentID = $_POST['equipment_id'];
        $equipmentName = $_POST['equipment_name'];
        $equipmentType = $_POST['equipment_type'];
        $staff_ID_forUpdate = $_POST['staff_id'];
        $dateForMaintenance = $_POST['maintenance_history'];

        // Update the equipment record in the database
        $query = "UPDATE equipment SET equipment_name = '$equipmentName', equipment_type = '$equipmentType', staff_id = '$staff_ID_forUpdate', maintenance_history = '$dateForMaintenance' WHERE equipment_id = '$equipmentID'";
        $result = $connection->query($query);

        if ($result) {
            echo "<script>alert('Equipment record updated successfully.');</script>";
            echo "<script>window.location.href = 'Maintenance.php';</script>";
        } else {
            echo "<script>alert('Failed to update equipment record.');</script>";
        }

    } elseif (isset($_POST['add'])) {
        // Display the form for adding a new equipment record
        displayAddForm();
    } elseif (isset($_POST['save'])) {
        $equipmentID = $_POST['equipment_id'];
        $equipmentName = $_POST['equipment_name'];
        $equipmentType = $_POST['equipment_type'];
        $maintenanceHistory = $_POST['maintenance_history'];
        $purchaseDate = $_POST['purchase_date'];
        $staffID = $_POST['staff_id'];

        // Insert the new equipment record into the database
        $query = "INSERT INTO equipment (equipment_name, equipment_type, maintenance_history, purchase_date, staff_id) VALUES ('$equipmentName', '$equipmentType', '$maintenanceHistory', '$purchaseDate', $staffID)";
        $result = $connection->query($query);

        if ($result) {
            echo "<script>alert('New equipment record added successfully.');</script>";
            echo "<script>window.location.href = 'Maintenance.php';</script>";
        } else {
            echo "<script>alert('Failed to add new equipment record.');</script>";
        }
    }
}

function displayEditForm($row)
{
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Edit Equipment</title>
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

           form {
               margin-bottom: 20px;
           }

           label {
               display: block;
               margin-bottom: 8px;
           }

           input[type="text"],
           textarea,
           input[type="number"] {
               width: 100%;
               padding: 8px;
               border-radius: 4px;
               border: 1px solid #ddd;
               resize: vertical;
           }

           input[type="submit"] {
               background-color: #4CAF50;
               color: #ffffff;
               padding: 10px 20px;
               text-decoration: none;
               border-radius: 4px;
               transition: background-color 0.3s;
               cursor: pointer;
           }

           input[type="submit"]:hover {
               background-color: #45a049;
           }
       </style>
    </head>
    <body>
        <div class="container">
            <h2>Edit Equipment</h2>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                <input type="hidden" name="equipment_id" value="<?php echo $row['equipment_id']; ?>">
                <label for="equipment_name">Equipment Name:</label>
                <input type="text" name="equipment_name" id="equipment_name" value="<?php echo $row['equipment_name']; ?>" required>
                <label for="equipment_type">Equipment Type:</label>
                <input type="text" name="equipment_type" id="equipment_type" value="<?php echo $row['equipment_type']; ?>" required>
                <label for="maintenance_history">Maintenance History:</label>
                <input type="date" name="maintenance_history" id="maintenance_history" value="<?php echo $row['maintenance_history']; ?>" required>
                <label for="purchase_date">Purchase Date:</label>
                <input type="date" name="purchase_date" id="purchase_date" value="<?php echo $row['purchase_date']; ?>" required>
                <label for="staff_id">Staff ID:</label>
                <input type="number" name="staff_id" id="staff_id" value="<?php echo $row['staff_id']; ?>" required>
                <input type="submit" name="update" value="Update">
            </form>
        </div>
    </body>
    </html>
    <?php
}

function displayAddForm()
{
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Add New Equipment</title>
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

           form {
               margin-bottom: 20px;
           }

           label {
               display: block;
               margin-bottom: 8px;
           }

           input[type="text"],
           textarea,
           input[type="number"] {
               width: 100%;
               padding: 8px;
               border-radius: 4px;
               border: 1px solid #ddd;
               resize: vertical;
           }

           input[type="submit"] {
               background-color: #4CAF50;
               color: #ffffff;
               padding: 10px 20px;
               text-decoration: none;
               border-radius: 4px;
               transition: background-color 0.3s;
               cursor: pointer;
           }

           input[type="submit"]:hover {
               background-color: #45a049;
           }
       </style>
    </head>
    <body>
        <div class="container">
            <h2>Add New Equipment</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <label for="equipment_name">Equipment Name:</label>
                <input type="text" name="equipment_name" id="equipment_name" required>
                <label for="equipment_type">Equipment Type:</label>
                <input type="text" name="equipment_type" id="equipment_type" required>
                
                <label for="maintenance_history">Maintenance History:</label>
                <input type="date" name="maintenance_history" id="maintenance_history" required>
                
                <label for="purchase_date">Purchase Date:</label>
                <input type="date" name="purchase_date" id="purchase_date" required>
                <label for="staff_id">Staff ID:</label>
                <input type="number" name="staff_id" id="staff_id" required>
                <input type="submit" name="save" value="Save">
            </form>
        </div>
    </body>
    </html>
    <?php
}