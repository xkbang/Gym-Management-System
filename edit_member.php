<?php
session_start();
require_once "login.php";
$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) {
    die("Fatal Error");
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit'])) {
        
        $memberID = $_POST['member_id'];
        // Retrieve the member record from the database
        $query = "SELECT * FROM members WHERE member_id = $memberID";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Display the edit form with the existing member details
            displayForm($row, "edit");
        } else {
            echo "Member record not found.";
        }
    } elseif (isset($_POST['Update'])) {
        // Handle the update operation
        $memberID = $_POST['member_id'];
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $phoneNumber = $_POST['phone_number'];
        $membershipStatus = $_POST['membership_status'];
        $registrationDate = $_POST['registration_date'];
        $address = $_POST['address'];
        $emergencyContact = $_POST['emergency_contact'];
        $email = $_POST['email'];
        $dateOfBirth = $_POST['date_of_birth'];
        $medicalConditions = $_POST['medical_conditions'];
        $duration = $_POST['duration'];
        $identityCardNo = $_POST['identity_card_no'];

        // Update the member record in the database
        $query = "UPDATE members SET 
            first_name = '$firstName',
            last_name = '$lastName',
            phone = '$phoneNumber',
            membership_status = '$membershipStatus',
            registration_date = '$registrationDate',
            address = '$address',
            emergency_contact = '$emergencyContact',
            email = '$email',
            date_of_birth = '$dateOfBirth',
            medical_conditions = '$medicalConditions',
            membership_duration = '$duration',
            identity_card_no = '$identityCardNo'
            WHERE member_id = $memberID";
        
        $result = $connection->query($query);

        if ($result) {
            echo "<script>alert('Update successfully.');</script>";
            echo "<script>window.location.href = 'Member.php';</script>";
        } else {
            echo "<script>alert('Failed to update member record.');</script>";
        }
    } elseif (isset($_POST['add'])) {
        displayForm(null, "add");
        
     }elseif (isset($_POST['Save'])) {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $phoneNumber = $_POST['phone_number'];
        $membershipStatus = $_POST['membership_status'];
        $registrationDate = $_POST['registration_date'];
        $address = $_POST['address'];
        $emergencyContact = $_POST['emergency_contact'];
        $email = $_POST['email'];
        $dateOfBirth = $_POST['date_of_birth'];
        $medicalConditions = $_POST['medical_conditions'];
        $duration = $_POST['duration'];
        $identityCardNo = $_POST['identity_card_no'];

        // Update the member record in the database
        $query = "INSERT INTO members(
                    first_name, last_name , phone, membership_status, registration_date, address,
                    emergency_contact,email,date_of_birth,medical_conditions, membership_duration,identity_card_no)
                  VALUES(
                    '$firstName', '$lastName', '$phoneNumber', '$membershipStatus',
                    '$registrationDate', '$address', '$emergencyContact', '$email',
                    '$dateOfBirth', '$medicalConditions', '$duration', '$identityCardNo')";
        
        $result = $connection->query($query);

        if ($result) {
            echo "<script>alert('New member record added successfully.');</script>";
            echo "<script>window.location.href = 'Member.php';</script>";
        } else {
            echo "<script>alert('Failed to add new member record.');</script>";
        }

    }
}



function displayForm($row, $mode)
{
    $title = ($mode === "edit") ? "Edit Member" : "Add New Member";
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
                    <input type="hidden" name="member_id" value="<?php echo $row['member_id']; ?>">
                <?php endif; ?>
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" value="<?php echo ($row) ? $row['first_name'] : ''; ?>" required>
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" value="<?php echo ($row) ? $row['last_name'] : ''; ?>" required>
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number" value="<?php echo ($row) ? $row['phone'] : ''; ?>" required>
                <label for="membership_status">Membership Status:</label>
                <input type="text" name="membership_status" id="membership_status" value="<?php echo ($row) ? $row['membership_status'] : ''; ?>" required>
                <label for="registration_date">Registration Date:</label>
                <input type="text" name="registration_date" id="registration_date" value="<?php echo ($row) ? $row['registration_date'] : ''; ?>" required>
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" value="<?php echo ($row) ? $row['address'] : ''; ?>" required>
                <label for="emergency_contact">Emergency Contact:</label>
                <input type="text" name="emergency_contact" id="emergency_contact" value="<?php echo ($row) ? $row['emergency_contact'] : ''; ?>" required>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo ($row) ? $row['email'] : ''; ?>" required>
                <label for="date_of_birth">Date of Birth:</label>
                <input type="text" name="date_of_birth" id="date_of_birth" value="<?php echo ($row) ? $row['date_of_birth'] : ''; ?>" required>
                <label for="medical_conditions">Medical Conditions:</label>
                <input type="text" name="medical_conditions" id="medical_conditions" value="<?php echo ($row) ? $row['medical_conditions'] : ''; ?>" required>
                
            
                
                <label for="duration">Membership Duration:</label>
                <input type="number" name="duration" id="duration" value="<?php echo ($row) ? $row['membership_duration'] : ''; ?>" required>
                
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