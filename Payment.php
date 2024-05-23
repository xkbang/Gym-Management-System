<?php
session_start();
require_once "login.php";
$connection = new mysqli($hn, $un, $pw, $db);

if ($connection->connect_error) {
    die("Fatal Error");
}

// Check if the member ID is stored in the session
if (isset($_SESSION["memberID"])) {
    $memberID = $_SESSION["memberID"];

    // Fetch payment history
    $paymentQuery = "SELECT * FROM payment WHERE member_id = {$memberID}";
    $paymentResult = $connection->query($paymentQuery);

    // Fetch supplement purchase history
    $supplementQuery = "SELECT * FROM supplement WHERE member_id = {$memberID}";
    $supplementResult = $connection->query($supplementQuery);

    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Payment and Supplement Purchase History</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
            }

            h1 {
                margin-bottom: 20px;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            .button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #4CAF50;
                color: white;
                text-decoration: none;
                border-radius: 4px;
            }
        </style>
    </head>
    <body>
        <h1>Payment and Supplement Purchase History</h1>

        <?php if ($paymentResult->num_rows > 0) { ?>
            <h2>Payment History</h2>
            <table>
                <tr>
                    <th>Payment ID</th>
                    <th>Member ID</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Payment Method</th>
                </tr>
                <?php while ($row = $paymentResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['payment_id']; ?></td>
                        <td><?php echo $row['member_id']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['payment_date']; ?></td>
                        <td><?php echo $row['payment_method']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <h2>Payment History</h2>
            <p>No Payment Records Found</p>
        <?php } ?>

        <?php if ($supplementResult->num_rows > 0) { ?>
            <h2>Supplement Purchase History</h2>
            <table>
                <tr>
                    <th>Supplement ID</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Member ID</th>
                </tr>
                <?php while ($row = $supplementResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['supplement_id']; ?></td>
                        <td><?php echo $row['item']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['member_id']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <h2>No Supplement Purchase Records Found</h2>
        <?php } ?>

        <a href="Dashboard.php" class="button">Go to Dashboard</a>
    </body>
    </html>

    <?php
}
$connection->close();
?>