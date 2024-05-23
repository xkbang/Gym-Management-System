<?php
session_start();
require_once "login.php";
$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) {
    die("Fatal Error");
}


echo "<style>";
echo ".info-container {";
echo " margin-top: 20px;";
echo " border: 1px solid #ddd;";
echo " padding: 10px;";
echo "}";
echo ".info-container p {";
echo " margin: 0;";
echo " padding: 5px 0;";
echo " font-weight: bold;";
echo "}";
echo ".button-bar {";
echo " margin-top: 20px;";
echo " display: flex;";
echo " justify-content: space-between;";
echo "}";
echo ".button-bar button {";
echo " padding: 10px 20px;";
echo " background-color: #4CAF50;";
echo " color: white;";
echo " border: none;";
echo " cursor: pointer;";
echo " font-size: 16px;";
echo "}";
echo ".button-bar button.logout-button {";
echo " background-color: #555;";
echo "}";
echo ".logout-button {";
echo "  position: fixed;";
echo "  top: 10px;";
echo "  right: 10px;";
echo " padding: 10px 20px;";
echo " background-color: #4CAF50;";
echo " color: white;";
echo " border: none;";
echo " cursor: pointer;";
echo " font-size: 16px;";
echo "}";
echo "</style>";

echo "<button class='logout-button' onclick='logout()'>Logout</button>";

if ($_SESSION["AccountType"] == 'Member') {
    // Member section
    $query = "SELECT member_id, CONCAT(first_name, ' ', last_name) AS member_name, phone, membership_status, registration_date, membership_duration FROM members WHERE member_id = {$_SESSION["id"]}";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $memberID = $row["member_id"];
        $_SESSION["memberID"] = $memberID; // Save member ID in the session
        $memberName = $row["member_name"];
        $phone = $row["phone"];
        $membershipStatus = $row["membership_status"];
        $registrationDate = $row["registration_date"];
        $membershipDuration = $row["membership_duration"];

        echo "<h2>Welcome, $memberName!</h2>";
        echo "<div class='info-container'>";
        echo "<p>Member ID: $memberID</p>";
        echo "<p>Name: $memberName</p>";
        echo "<p>Phone: $phone</p>";
        echo "<p>Membership Status: $membershipStatus</p>";
        echo "<p>Registration Date: $registrationDate</p>";
        echo "<p>Membership Duration: $membershipDuration</p>";
        echo "</div>";
        echo "<div class='button-bar'>";
        echo "<button onclick='goToCalendar()'>Calendar</button>";
        echo "<button onclick='goToAttendance()'>Attendance</button>";
        echo "<button onclick='goToPayment()'>Payment</button>";
        echo "</div>";
    } else {
        echo "No member found.";
    }
} else if ($_SESSION["AccountType"] == 'Coach') {
    // Coach section
    $query = "SELECT coach_id, CONCAT(first_name, ' ', last_name) AS coach_name, phone, email, hire_date, specialty FROM coaches WHERE coach_id = {$_SESSION["id"]}";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $coachID = $row["coach_id"];
        $_SESSION["coachID"] = $coachID; // Save coach ID in the session
        $coachName = $row["coach_name"];
        $phone = $row["phone"];
        $email = $row["email"];
        $hireDate = $row["hire_date"];
        $speciality = $row["specialty"];

        echo "<h2>Welcome, $coachName!</h2>";
        echo "<div class='info-container'>";
        echo "<p>Coach ID: $coachID</p>";
        echo "<p>Name: $coachName</p>";
        echo "<p>Phone: $phone</p>";
        echo "<p>Email: $email</p>";
        echo "<p>HireDate: $hireDate</p>";
        echo "<p>Speciality: $speciality</p>";
        echo "</div>";
        echo "<div class='button-bar'>";
        echo "<button onclick='goToCalendar()'>Calendar</button>";
        echo "</div>";
    } else {
        echo "No coach found.";
    }
} else {
    echo "Invalid account type.";
}

?>

<script>
function logout() {
    // Clear session storage
    sessionStorage.clear();

    // Clear local storage
    localStorage.clear();


    // Redirect to the login page
    window.location.href = "UserLogin.php";
}

    function goToCalendar() {
        // Redirect to the calendar page
        window.location.href = "Calender.php";
    }

    function goToAttendance() {
        window.location.href = "Attendance.php";
    }

    function goToPayment() {
        // Redirect to the payment page
        window.location.href = "Payment.php";
    }
</script>