<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intern";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM orders WHERE status = 'confirmed'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dispatch Panel</title>
    
<link rel="stylesheet" href="style.css">
</head>
<style>
    .pic {
    display: flex;
    justify-content: start;   
}


.pic img {
    max-width: 80px; 
}
#dev{
margin-left:1067px;
}
.container {
    width: 80%;
}

h2 {
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;

}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

a {
    text-decoration: none;
    color: blue;
}

</style>
<body>
<div class="container">
    <div class="pic">
    <h1>Dispatch Panel</h1>
<img id="dev" src="https://media.licdn.com/dms/image/D4D0BAQHErC8QoKIkQQ/company-logo_200_200/0/1683782830707?e=2147483647&v=beta&t=Za_bzvxwFl0i4yYIHNNoRMfNr9cgBwWqcz6_wEu5aWw" alt="">
    </div>
    <br><br>
    <?php
    if (isset($_SESSION['message'])) {
        echo "<p>{$_SESSION['message']}</p>";
        unset($_SESSION['message']); 
    }
    ?>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Consumer Name</th>
            <th>Order Date</th>
            <th>Assign Tracking</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['consumer_name']}</td>
                        <td>{$row['order_date']}</td>
                        <td>
                            <form action='assign_tracking.php' method='POST'>
                                <input type='hidden' name='order_id' value='{$row['id']}'>
                                <input type='text' name='tracking_number' placeholder='Tracking Number' required>
                                <input type='text' name='tracking_link' placeholder='Tracking Link' required>
                                <select name='status'>
                                    <option value='pending'>Pending</option>
                                    <option value='picked'>Picked</option>
                                    <option value='in transit'>In Transit</option>
                                    <option value='delivered'>Delivered</option>
                                </select>
                                <button type='submit'>Assign</button>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No confirmed orders</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    </div>
</body>
</html>
