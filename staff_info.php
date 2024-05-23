<!DOCTYPE html>
<html>
<head>
    <title>Staff Table</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td {
            text-align: center;
            padding: 8px 4px;
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

        .add-staff-button {
            margin-left: 4px;
        }

        .add-staff-button input {
            padding: 8px 16px;
            font-size: 14px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-staff-button input:hover {
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
        .action-form {
            display: flex;
            justify-content: flex-start;
            gap: 4px;
         }
         
        .action-buttons {
            display: flex;
            justify-content: left;
            gap: 10px;
            margin-right: 20px;
            padding: 2px 10px;
          }

        .action-buttons form {
          display: inline-block;
        }
        
        
    </style>
</head>
<body>
    <h1>Staff Table</h1>
    <div id="search-container">
        <input type="text" id="search-input" placeholder="Search...">
    </div>

    <table id="staff-table">
        <thead>
            <tr>
                <th>Staff ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>email</th>
                <th>Phone Number</th>
                <th>Hire Date</th>
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
                $query = "SELECT * FROM staff";
                $result = mysqli_query($connection, $query);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                    
                        echo "<tr>";
                        echo "<td>" . $row['staff_id'] . "</td>";
                        echo "<td>" . $row['first_name'] . "</td>";
                        echo "<td>" . $row['last_name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>" . $row['hire_date'] . "</td>";
                        echo "<td>" . $row['identity_card_no'] . "</td>";
                        echo "<td>";
                        
                        echo "<td class='action-cell'>";
                        echo "<div class='action-buttons'>";
                        echo "<form action='edit_staff.php' method='post'>";
                        echo "<input type='hidden' name='staff_id' value='" . $row['staff_id'] . "'>";
                        echo "<input type='submit' name='edit' value='Edit'>";
                        echo "</form>";
                        echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post' onsubmit='return confirm(\"Are you sure you want to delete this staff record?\");'>";
                        echo "<input type='hidden' name='staff_id' value='" . $row['staff_id'] . "'>";
                        echo "<input type='submit' name='delete' value='Delete' onclick=\"return confirm('Are you sure you want to delete this staff record?');\">";
                        echo "</form>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                        
                    }
                } else {
                    echo "Error executing query: " . mysqli_error($connection);
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Check if the delete button was clicked
                    if (isset($_POST['delete'])) {
                        $staffID = $_POST['staff_id'];

                        // Perform the deletion query or call a function to delete the promotion record
                        $deleteQuery = "DELETE FROM staff WHERE staff_id = $staffID";
                        $deleteResult = $connection->query($deleteQuery);

                        if ($deleteResult) {
                            // Deletion successful
                            echo "<script>alert('staff record deleted successfully.');</script>";
                        } else {
                            // Deletion failed
                            echo "<script>alert('Failed to delete staff record.');</script>";
                        }

                        // Redirect back to the promotion list or show a success message
                        echo "<script>window.location.href = 'staff_info.php';</script>";
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
        <div class="add-staff-button">
            <form action="edit_staff.php" method="post">
                <input type="hidden" name="add" value="add">
                <input type="submit" name="submit" value="Add staff">
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