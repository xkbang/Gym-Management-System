<?php
session_start();
require_once "login.php";
$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) {
    die("Fatal Error");
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit'])) {
        
        $staffID = $_POST['staff_id'];
        // Retrieve the member record from the database
        $query = "SELECT * FROM staff WHERE staff_id = $staffID";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Display the edit form with the existing member details
            displayForm($row, "edit");
        } else {
            echo "Staff record not found.";
        }
    } elseif (isset($_POST['Update'])) {
        // Handle the update operation
        $staffID = $_POST['staff_id'];
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $phoneNumber = $_POST['phone_number'];
        $hireDate = $_POST['hire_date'];
        $email = $_POST['email'];
        $identityCardNo = $_POST['identity_card_no'];

        // Update the member record in the database
        $query = "UPDATE staff SET 
            first_name = '$firstName',
            last_name = '$lastName',
            email = '$email',
            phone = '$phoneNumber',
            hire_date = '$hireDate',
            identity_card_no = '$identityCardNo'
            WHERE staff_id = $staffID";
        
        $result = $connection->query($query);

        if ($result) {
            echo "<script>alert('Update successfully.');</script>";
            echo "<script>window.location.href = 'staff_info.php';</script>";
        } else {
            echo "<script>alert('Failed to update staff record.');</script>";
        }
    } elseif (isset($_POST['add'])) {
        displayForm(null, "add");
        
     }elseif (isset($_POST['Save'])) {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $phoneNumber = $_POST['phone_number'];
        $hireDate = $_POST['hire_date'];
        $email = $_POST['email'];
        $identityCardNo = $_POST['identity_card_no'];

        // Update the member record in the database
        $query = "INSERT INTO staff(
                    first_name, last_name , email, phone, hire_date, identity_card_no)
                  VALUES(
                    '$firstName', '$lastName', '$email', '$phoneNumber', '$hireDate', '$identityCardNo')";
        
        $result = $connection->query($query);

        if ($result) {
            echo "<script>alert('New staff record added successfully.');</script>";
            echo "<script>window.location.href = 'staff_info.php';</script>";
        } else {
            echo "<script>alert('Failed to add new staff record.');</script>";
        }

    }
}



function displayForm($row, $mode)
{
    $title = ($mode === "edit") ? "Edit Staff" : "Add New Staff";
    $submitLabel = ($mode === "edit") ? "Update" : "Save";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?php echo $title; ?></title>
    <style>
        .container {
            max-width: 400px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"] {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    </head>
    <body>
        <div class="container">
            <h2><?php echo $title; ?></h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <?php if ($mode === "edit"): ?>
                    <input type="hidden" name="staff_id" value="<?php echo $row['staff_id']; ?>">
                <?php endif; ?>
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" value="<?php echo ($row) ? $row['first_name'] : ''; ?>" required>
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" value="<?php echo ($row) ? $row['last_name'] : ''; ?>" required>
                
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo ($row) ? $row['email'] : ''; ?>" required>
                
                
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number" value="<?php echo ($row) ? $row['phone'] : ''; ?>" required>
                
                
               
                <label for="hire_date">Hire Date:</label>
                <input type="text" name="hire_date" id="registration_date" value="<?php echo ($row) ? $row['hire_date'] : ''; ?>" required>
              
                
                <label for="identity_card_no">Identity Card No.:</label>
                <input type="text" name="identity_card_no" id="identity_card_no" value="<?php echo ($row) ? $row['identity_card_no'] : ''; ?>" required>
                
                <input type="submit" name="<?php echo $submitLabel; ?>" value="<?php echo $submitLabel; ?>">
                
                
                
            </form>
        </div>
    </body>
    </html>
    <?php
}

mysqli_close($connection);
?>