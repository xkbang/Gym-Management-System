<?php
session_start();

require_once "login.php";
$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) {
    die("Fatal Error");
}

$accountType = $_SESSION['AccountType'];
$id = $_SESSION['id'];

if ($accountType === 'Member') {
    $query = "SELECT c.course_name, c.course_time, CONCAT(co.first_name, ' ', co.last_name) AS coach_name 
              FROM courses c
              JOIN coaches co ON c.coach_id = co.coach_id
              WHERE c.member_id = $id
              ORDER BY c.course_time";
} elseif ($accountType === 'Coach') {
    $query = "SELECT c.course_name, c.course_time, CONCAT(co.first_name, ' ', co.last_name) AS coach_name  
              FROM courses c
              JOIN coaches co ON c.coach_id = co.coach_id
              WHERE c.coach_id = $id
              ORDER BY c.course_time";
} else {
    echo $accountType;
    die("Invalid account type");
}

$result = $connection->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lesson Calendar</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lesson Calendar</h1>

    <table>
        <tr>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
            <th>Sunday</th>
        </tr>

        <?php
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Create an array to store the lessons for each day
        $lessonsByDay = array_fill(0, 7, []);

        // Loop through each lesson and group them by day
        while ($row = $result->fetch_assoc()) {
            $courseName = $row['course_name'];
            $courseTime = $row['course_time'];
            $coachMemberName = ($accountType === 'coach') ? $row['member_name'] : $row['coach_name'];

            // Determine the day index based on the course time
            $dayIndex = array_search(explode(' ', $courseTime)[0], $daysOfWeek);

            // Add the lesson to the corresponding day
            $lessonsByDay[$dayIndex][] = [
                'courseName' => $courseName,
                'courseTime' => $courseTime,
                'coachMemberName' => $coachMemberName
            ];
        }

        // Find the maximum number of lessons in a day
        $maxLessonsPerDay = max(array_map('count', $lessonsByDay));

        // Loop through each lesson slot and display the lessons
        for ($i = 0; $i < $maxLessonsPerDay; $i++) {
            echo "<tr>";
            for ($j = 0; $j < 7; $j++) {
                $dayLessons = $lessonsByDay[$j];
                if (isset($dayLessons[$i])) {
                    $lesson = $dayLessons[$i];
                    echo "<td>";
                    echo "<strong>{$lesson['courseName']}</strong><br>";
                    echo "{$lesson['courseTime']}<br>";
                    echo ($accountType === 'coach') ? "Member: {$lesson['coachMemberName']}" : "Coach: {$lesson['coachMemberName']}";
                    echo "</td>";
                } else {
                    echo "<td></td>";
                }
            }
            echo "</tr>";
        }

        ?>
    </table>

    <?php
    // Check if any lessons were found
    if ($result->num_rows <= 0) {
        echo "No lessons found.";
    }

    // Close the database connection
    $connection->close();
    ?>
</body>
</html>