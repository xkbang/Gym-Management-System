<?php
session_start();

require_once "login.php";
$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) {
    die("Fatal Error");
}

$memberID = $_SESSION["memberID"];

// Get current month and last month
$currentMonth = date('Y-m');
$lastMonth = date('Y-m', strtotime('-1 month'));

// Query for current month
$queryCurrentMonth = "SELECT 
            member_id, 
            COUNT(attendance_id) AS total_attendance, 
            AVG(duration) AS average_duration
          FROM members_attendance
          WHERE member_id = '$memberID'
          AND DATE_FORMAT(attendance_date, '%Y-%m') = '$currentMonth'";

$resultCurrentMonth = $connection->query($queryCurrentMonth);

if ($resultCurrentMonth === false) {
    echo "Query error: " . $connection->error;
    exit;
}

$current_total_attendance = 0;
$current_average_duration = 0;

if ($row = $resultCurrentMonth->fetch_assoc()) {
    $current_total_attendance = $row['total_attendance'];
    $current_average_duration = $row['average_duration'];
}

// Query for previous month
$queryLastMonth = "SELECT 
            member_id, 
            COUNT(attendance_id) AS total_attendance, 
            AVG(duration) AS average_duration
          FROM members_attendance
          WHERE member_id = '$memberID'
          AND DATE_FORMAT(attendance_date, '%Y-%m') = '$lastMonth'";

$resultLastMonth = $connection->query($queryLastMonth);

if ($resultLastMonth === false) {
    echo "Query error: " . $connection->error;
    exit;
}

$last_total_attendance = 0;
$last_average_duration = 0;

if ($row = $resultLastMonth->fetch_assoc()) {
    $last_total_attendance = $row['total_attendance'];
    $last_average_duration = $row['average_duration'];
}

$connection->close();
?>

<!DOCTYPE html>
<html>
    <h1>Attendance Comparison Chart</h1>
<head>
    <title>Attendance Comparison</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
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
    <canvas id="attendanceChart"></canvas>
    <p id="attendanceSummary" class="summary"></p>
    <canvas id="durationChart"></canvas>
    <p id="durationSummary" class="summary"></p>

    <script>
        // Chart for attendance comparison
        var attendanceChart = new Chart(document.getElementById('attendanceChart'), {
            type: 'bar',
            data: {
                labels: ['<?php echo $lastMonth; ?>', '<?php echo $currentMonth; ?>'],
                datasets: [{
                    label: 'Total Attendance',
                    data: [<?php echo $last_total_attendance; ?>, <?php echo $current_total_attendance; ?>], // Replace with actual values
                    backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Attendance Comparison',
                        font: {
                            size: 24
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Chart for average duration comparison
        var durationChart = new Chart(document.getElementById('durationChart'), {
            type: 'bar',
            data: {
                labels: ['<?php echo $lastMonth; ?>', '<?php echo $currentMonth; ?>'],
                datasets: [{
                    label: 'Average Duration',
                    data: [<?php echo $last_average_duration; ?>, <?php echo $current_average_duration; ?>], // Replace with actual values
                    backgroundColor: ['rgba(75, 192, 192, 0.5)', 'rgba(255, 205, 86, 0.5)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 205, 86, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Average Duration Comparison',
                        font: {
                            size: 24
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Summary sentences
        var attendanceSummary = document.getElementById('attendanceSummary');
        var durationSummary = document.getElementById('durationSummary');

        var attendanceIncrease = true; // Replace with actual comparison logic
        var durationIncrease = false; // Replace with actual comparison logic

        attendanceSummary.innerHTML = getAttendanceSummary(attendanceIncrease);
        durationSummary.innerHTML = getDurationSummary(durationIncrease);

        function getAttendanceSummary(increase) {
            if (increase) {
                return "Great job! Your total attendance this month has increased compared to last month.";
            } else {
                return "Keep it up! Although your total attendance this month is lower than last month, every effort counts.";
            }
        }

        function getDurationSummary(increase) {
            if (increase) {
                return "Awesome! Your average duration this month has increased compared to last month.";
            } else {
                return "Well done! Even though your average duration this month is lower than last month, consistency is key.";
            }
        }
    </script>
    
    <a href="Dashboard.php" class ="button">Go to Dashboard</a>

</body>
</html>