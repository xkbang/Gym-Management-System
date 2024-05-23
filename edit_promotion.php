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
        $promotionID = $_POST['promotion_id'];

        // Retrieve the promotion record from the database
        $query = "SELECT * FROM promotion WHERE promotion_id = $promotionID";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Display the edit form with the existing promotion details
            displayEditForm($row);
        } else {
            echo "Promotion record not found.";
        }
    } elseif (isset($_POST['update'])) {
        $promotionID = $_POST['promotion_id'];
        $promotionName = $_POST['promotion_name'];
        $promotionDescription = $_POST['promotion_description'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $courseID= $_POST['course_id'];
        $staff_ID_forUpdate = $_POST['staff_id'];
        
        // Update the promotion record in the database
        $query = "UPDATE promotion SET promotion_name = '$promotionName', promotion_description = '$promotionDescription', start_date = '$startDate', end_date = '$endDate', course_id = '$courseID', staff_id = '$staff_ID_forUpdate', last_modified = '$staffID' WHERE promotion_id = $promotionID";
        $result = $connection->query($query);

        if ($result) {
            echo "<script>alert('Promotion record updated successfully.');</script>";
            echo "<script>window.location.href = 'Promotion_Record.php';</script>";
        } else {
            echo "<script>alert('Failed to update promotion record.');</script>";
        }
    
    } elseif (isset($_POST['add'])) {
        // Display the form for adding a new promotion record
        displayAddForm();
    } elseif (isset($_POST['save'])) {
        $promotionName = $_POST['promotion_name'];
        $promotionDescription = $_POST['promotion_description'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $courseID= $_POST['course_id'];
        $staff_ID_forEdit = $_POST['staff_id'];

        // Insert the new promotion record into the database
        $query = "INSERT INTO promotion (promotion_name, promotion_description, start_date, end_date, course_id, staff_id, last_modified) VALUES ('$promotionName', '$promotionDescription', '$startDate', '$endDate', '$courseID', '$staff_ID_forEdit', $staffID)";
        $result = $connection->query($query);

        if ($result) {
            echo "<script>alert('New promotion record added successfully.');</script>";
            echo "<script>window.location.href = 'Promotion_Record.php';</script>";
        } else {
            echo "<script>alert('Failed to add new promotion record.');</script>";
        }
    }
}




function displayEditForm($row)
{
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Edit Promotion</title>
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
           textarea {
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
            <h2>Edit Promotion</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="hidden" name="promotion_id" value="<?php echo $row['promotion_id']; ?>">
                <label for="staff_id">Staff ID:</label>
                <input type="number" name="staff_id" value="<?php echo $row['staff_id']; ?>">
                <label for="course_id">Course ID:</label>
                <input type="number" name="course_id" value="<?php echo $row['course_id']; ?>">
                <label for="promotion_name">Promotion Name:</label>
                <input type="text" name="promotion_name" id="promotion_name" value="<?php echo $row['promotion_name']; ?>" required>
                <label for="promotion_description">Description:</label>
                <textarea name="promotion_description" id="promotion_description" required><?php echo $row['promotion_description']; ?></textarea>
                <label for="start_date">Start Date:</label>
                <input type="text" name="start_date" id="start_date" value="<?php echo $row['start_date']; ?>" required>
                <label for="end_date">End Date:</label>
                <input type="text" name="end_date" id="end_date" value="<?php echo $row['end_date']; ?>" required>
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
        <title>Add New Promotion</title>
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
                   textarea {
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
            <h2>Add New Promotion</h2>
            <form action="edit_promotion.php" method="post">
                <label for="promotion_name">Promotion Name:</label>
                <input type="text" name="promotion_name" id="promotion_name" required>
                <label for="promotion_description">Description:</label>
                <textarea name="promotion_description" id="promotion_description" required></textarea>
                <label for="start_date">Start Date (yy-mm-dd):</label>
                <input type="text" name="start_date" id="start_date" required>
                <label for="end_date">End Date (yy-mm-dd):</label>
                <input type="text" name="end_date" id="end_date" required>
                <label for="staff_id">Staff ID:</label>
                <input type="number" name="staff_id" id="staff_id" required>
                <label for="course_id">Course ID:</label>
                <input type="number" name="course_id" id="course_id" required>
                <input type="submit" name="save" value="Save">
            </form>
        </div>
    </body>
    </html>
    <?php
}