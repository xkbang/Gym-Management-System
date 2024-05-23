
<!DOCTYPE html>
<html>
<head>
    <title>Course Popularity and Satisfaction Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #dateRange {
            text-align: center;
            margin-top: -200px;
            margin-bottom: 40px; /* Increase the margin bottom to create more space */
        }

        #chart-title {
            font-size: 30px; /* Increase the font size for the title */
            margin-bottom: 10px;
        }

        #chart-container {
            margin-bottom: 60px; /* Increase the margin bottom to create more space */
        }
        
        .navigation {
           display: flex; /* Added */
           justify-content: flex-start; /* Added */
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
 
       }

       .navigation a:hover {
           background-color: #45a049;
       }
    </style>
</head>
<h1 id="chart-title">Course Popularity Chart</h1>
<body>


    <?php
           session_start();
           require_once "login.php";
           $connection = new mysqli($hn, $un, $pw, $db);

           if ($connection->connect_error) {
               die("Fatal Error");
           }

           $startDate = $_POST['startDate'] ?? null;
           $endDate = $_POST['endDate'] ?? null;

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
           } else {
               // Handle query error
               echo "Error executing query: " . mysqli_error($connection);
           }
       ?>
    <canvas id="courseChart"></canvas>
    <h1 id="chart-title">Satisfaction Chart</h1>
    <div id="chart-container">
        <canvas id="courseChart"></canvas>
    </div>
    <div id="dateRange">
        <label for="startDate">Select Start Date:</label>
        <input type="date" id="startDate" name="startDate">
        <label for="endDate">Select End Date:</label>
        <input type="date" id="endDate" name="endDate">
        <button id="updateButton">Update Charts</button>
    </div>
        <canvas id="ratingChart"></canvas>
    <script>
        // Get the data from PHP variables
        var courseNames = <?php echo json_encode($courseNames); ?>;
        var enrollmentCounts = <?php echo json_encode($enrollmentCounts); ?>;
        var months = <?php echo json_encode($months); ?>;
        var averageRatings = <?php echo json_encode($averageRatings); ?>;

        // Create the course popularity chart
        var ctx1 = document.getElementById('courseChart').getContext('2d');
        var courseChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: courseNames,
                datasets: [{
                    label: 'Enrollment Count',
                    data: enrollmentCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });

        // Create the average satisfaction ratings chart
        var ctx2 = document.getElementById('ratingChart').getContext('2d');
        var ratingChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Average Rating',
                    data: averageRatings,
                    borderColor: 'blue',
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Average Rating'
                        },
                        beginAtZero: true,
                        max: 5
                    }
                }
            }
        });

        // Function to update the charts based on the selected date range
        // Function to update the charts based on the selected date range
        function updateCharts() {
            var startDate = document.getElementById('startDate').value;
            var endDate = document.getElementById('endDate').value;

            // Make an AJAX request to update the charts with the selected date range
            fetch('update_charts.php?startDate=' + startDate + '&endDate=' + endDate)
                .then(function(response) {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Error updating charts: ' + response.status);
                    }
                })
                .then(function(data) {
                    // Update the chart data
                    courseChart.data.labels = data.courseNames;
                    courseChart.data.datasets[0].data = data.enrollmentCounts;
                    courseChart.update();

                    ratingChart.data.labels = data.months;
                    ratingChart.data.datasets[0].data = data.averageRatings;
                    ratingChart.update();
                })
                .catch(function(error) {
                    console.error(error);
                });
        }

        // Add event listener to the button
        document.getElementById('updateButton').addEventListener('click', updateCharts);
    </script>
    <div class="navigation">
        <a href="Dashboard_staff.php" class="button">Go back to the Homepage</a>
    </div>
</body>
</html>