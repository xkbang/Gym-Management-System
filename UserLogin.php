

<html>
<head>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-form {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-form h1 {
            text-align: center;
        }

        .login-form label {
            display: block;
            margin-bottom: 10px;
        }

        .login-form input[type="text"],
        .login-form input[type="password"],
        .login-form select {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .login-form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h1>Login</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <label for="AccountType">Account Type (Member/Coach/Staff):</label><br>
            <select name="AccountType" required>
                <option value="Member">Member</option>
                <option value="Coach">Coach</option>
                <option value="Staff">Staff</option>
            </select><br>
            <label for="ID">ID:</label><br>
            <input type="text" name="ID" required><br>
            <label for="password">Password:</label><br>
            <input type="password" name="password" required><br>
            <input type="submit" name="login" value="Login">
        </form>
           <?php
            require_once "login.php";
            $connection = new mysqli($hn, $un, $pw, $db);

            if ($connection->connect_error) {
                die("Fatal Error");
            }

            if (isset($_POST["ID"]) && isset($_POST["password"])) {
                $id_temp = mysql_entities_fix_string($connection, $_POST["ID"]);
                $pw_temp = mysql_entities_fix_string($connection, $_POST["password"]);
                $accountType = null;

                if (isset($_POST['login'])) {
                    $accountType = $_POST['AccountType'];
                    $table = '';
                    $idColumn = '';
                    $redirectPage = '';

                    switch ($accountType) {
                        case 'Member':
                            $table = 'members';
                            $idColumn = 'member_id';
                            $redirectPage = 'Dashboard.php';
                            break;
                        case 'Coach':
                            $table = 'coaches';
                            $idColumn = 'coach_id';
                            $redirectPage = 'Dashboard.php';
                            break;
                        case 'Staff':
                            $table = 'staff';
                            $idColumn = 'staff_id';
                            $redirectPage = 'Dashboard_staff.php';
                            break;
                        default:
                            echo "Invalid account type";
                            return;
                    }

                $query = "SELECT * FROM $table WHERE $idColumn = '$id_temp'";
                $result = $connection->query($query);

                if (!$result) {
                    die("User not found");
                } elseif ($result->num_rows) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $result->close();

                    // Verify the hashed password
                    if ($pw_temp == $row['identity_card_no']) {
                        session_start();
                        $_SESSION["id"] = $id_temp;
                        $_SESSION["AccountType"] = $accountType;
                        header("Location: $redirectPage");
                        exit();
                    } else {
                        echo "Invalid username/password combination";
                    }
                } else {
                    echo "Invalid username/password combination";
                }
            }
        }

            $connection->close();

            function mysql_entities_fix_string($connection, $string)
            {
                return htmlentities(mysql_fix_string($connection, $string));
            }

            function mysql_fix_string($connection, $string)
            {
                return $connection->real_escape_string($string);
            }
            ?>
    </div>
</body>
</html>