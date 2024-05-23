<!DOCTYPE html>
<html>
<head>
    <title>Member Table</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #search-container {
            margin-bottom: 20px;
        }

        #search-input {
            width: 300px;
            padding: 5px;
            font-size: 16px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination button {
            margin: 0 5px;
            padding: 8px 16px;
            font-size: 14px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .pagination button:hover {
            background-color: #45a049;
        }

        .add-member-button {
            margin-left: 10px;
        }

        .add-member-button input {
            padding: 8px 16px;
            font-size: 14px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-member-button input:hover {
            background-color: #0069d9;
        }
        .homepage-link {
            display: inline-block;
            margin-right: 10px;
            padding: 8px 16px;
            font-size: 14px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .homepage-link:hover {
            background-color: #0069d9;
        }
    </style>
</head>
<body>
    <h1>Member Table</h1>
    <div id="search-container">
        <input type="text" id="search-input" placeholder="Search...">
    </div>

    <table id="member-table">
        <thead>
            <tr>
                <th>Member ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone Number</th>
                <th>Membership Status</th>
                <th>Registration Date</th>
                <th>Address</th>
                <th>Emergency Contact</th>
                <th>Email</th>             
                <th>Date Of Birth</th>
                <th>Medical Conditions</th>
                <th>Membership Duration</th>
                <th>Membership Expiry Date</th>
                <th>Identity Card No.</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Your database connection code
                session_start();
                require_once "login.php";
                $connection = new mysqli($hn, $un, $pw, $db);

                if ($connection->connect_error) {
                    die("Fatal Error");
                }
                
                
                // Fetch member information from the database
                $query = "SELECT * FROM members";
                $result = mysqli_query($connection, $query);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // The calculation of the membership expiry date
                        $registrationDate = new DateTime($row['registration_date']);
                        $membershipDuration = $row['membership_duration'];

                        $dateInterval = new DateInterval("P{$membershipDuration}M");
                        $registrationDate->add($dateInterval);

                        $newDate = $registrationDate->format('Y-m-d');
                        
                        
                        
                        echo "<tr>";
                        echo "<td>" . $row['member_id'] . "</td>";
                        echo "<td>" . $row['first_name'] . "</td>";
                        echo "<td>" . $row['last_name'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>" . $row['membership_status'] . "</td>";
                        echo "<td>" . $row['registration_date'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['emergency_contact'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['date_of_birth'] . "</td>";
                        echo "<td>" . $row['medical_conditions'] . "</td>";
                        echo "<td>" . $row['membership_duration'] . "</td>";
                        echo "<td>" . $newDate . "</td>";
                        echo "<td>" . $row['identity_card_no'] . "</td>";
                        echo "<td>";
                        
                        echo "<td>";
                        echo "<form action='edit_member.php' method='post'>";
                        echo "<input type='hidden' name='member_id' value='" . $row['member_id'] . "'>";
                        echo "<input type='submit' name='edit' value='Edit'>";
                        echo "</form>";
                        
                        echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post' onsubmit='return confirm(\"Are you sure you want to delete this member?\");'>";
                        echo "<input type='hidden' name='member_id' value='" . $row['member_id'] . "'>";
                        echo "<input type='submit' name='delete' value='Delete' onclick=\"return confirm('Are you sure you want to delete this member record?');\">";
                        echo "</form>";
                        
                        
                        
                        echo "</td>";
                        echo "</tr>";
                        
                    }
                } else {
                    echo "Error executing query: " . mysqli_error($connection);
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Check if the delete button was clicked
                    if (isset($_POST['delete'])) {
                        $memberID = $_POST['member_id'];

                        // Perform the deletion query or call a function to delete the promotion record
                        $deleteQuery = "DELETE FROM members WHERE member_id = $memberID";
                        $deleteResult = $connection->query($deleteQuery);

                        if ($deleteResult) {
                            // Deletion successful
                            echo "<script>alert('member record deleted successfully.');</script>";
                        } else {
                            // Deletion failed
                            echo "<script>alert('Failed to delete member record.');</script>";
                        }

                        // Redirect back to the promotion list or show a success message
                        echo "<script>window.location.href = 'Member.php';</script>";
                    }
                }
                mysqli_close($connection);
            ?>
        </tbody>
    </table>

    <div class="pagination">
        <a href="Dashboard_staff.php" class="homepage-link">Go back to the Homepage</a>
        <button onclick="previousPage()">Previous</button>
        <button onclick="nextPage()">Next</button>
        <div class="add-member-button">
            <form action="edit_member.php" method="post">
                <input type="hidden" name="add" value="add">
                <input type="submit" name="submit" value="Add Member">
            </form>
        </div>
    </div>

    <script>
        var searchInput = document.getElementById('search-input');
        var memberTable = document.getElementById('member-table');
        var currentPage = 0;

        searchInput.addEventListener('keyup', function() {
            var searchValue = searchInput.value.toLowerCase();

            for (var i = 1; i < memberTable.rows.length; i++) {
                var row = memberTable.rows[i];
                var match = false;

                for (var j = 0; j < row.cells.length - 1; j++) {
                    var cell = row.cells[j];
                    if (cell.innerHTML.toLowerCase().indexOf(searchValue) > -1) {
                        match = true;
                        break;
                    }
                }

                if (match) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });

        function loadMembers() {
            var rows = Array.from(memberTable.rows).slice(1); // Exclude the header row
rows.forEach(function(row) {
                row.style.display = 'none';
            });

            var startIndex = currentPage * 10;
            var endIndex = startIndex + 10;
            var currentRows = rows.slice(startIndex, endIndex);

            currentRows.forEach(function(row) {
                row.style.display = '';
            });
        }

        function nextPage() {
            currentPage++;
            var maxPage = Math.ceil((memberTable.rows.length - 1) / 10);
            if (currentPage >= maxPage) {
                currentPage = maxPage - 1;
            }
            loadMembers();
        }

        function previousPage() {
            currentPage--;
            if (currentPage < 0) {
                currentPage = 0;
            }
            loadMembers();
        }


        window.onload = function() {
            loadMembers();
        };
    </script>
</body>
</html>