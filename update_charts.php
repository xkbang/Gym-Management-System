<?php
session_start();
require_once "login.php";
$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) {
    die("Fatal Error");
}

$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

// Adjust the SQL query based on the selected date range
$queryCourse = "SELECT course_name, COUNT(member_id) AS enrollment_count
                FROM courses
                GROUP BY course_name
                ORDER BY enrollment_count DESC";

$queryRating = "SELECT YEAR(attendance_date) AS year,
                       MONTH(attendance_date) AS month,
                       AVG(rating) AS average_rating
                FROM members_attendance
                WHERE attendance_date >= '$startDate' AND attendance_date <= '$endDate'
                GROUP BY YEAR(attendance_date), MONTH(attendance_date)
                ORDER BY YEAR(attendance_date), MONTH(attendance_date)";

$resultCourse = mysqli_query($connection, $queryCourse);
$resultRating = mysqli_query($connection, $queryRating);

if ($resultCourse && $resultRating) {
    // Initialize arrays to store chart data
    $courseNames = [];
    $enrollmentCounts = [];
    $months = [];
    $averageRatings = [];

    // Fetch data and populate arrays for course popularity
    while ($row = mysqli_fetch_assoc($resultCourse)) {
        $courseNames[] = $row['course_name'];
        $enrollmentCounts[] = $row['enrollment_count'];
    }

    // Fetch data and populate arrays for average satisfaction ratings
    while ($row = mysqli_fetch_assoc($resultRating)) {
        $months[] = $row['year'] . '-' . $row['month'];
        $averageRatings[] = $row['average_rating'];
    }

    // Close the database connection
    mysqli_close($connection);

    // Prepare the response data array
    $responseData = [
        'courseNames' => $courseNames,
        'enrollmentCounts' => $enrollmentCounts,
        'months' => $months,
        'averageRatings' => $averageRatings
    ];

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($responseData);
} else {
    // Handle query error
    echo "Error executing query: " . mysqli_error($connection);
}
?>