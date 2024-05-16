<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intern";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $tracking_number = $_POST['tracking_number'];
    $tracking_link = $_POST['tracking_link'];
    $status = $_POST['status'];

    $sql = "INSERT INTO tracking (order_id, tracking_number, tracking_link, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $order_id, $tracking_number, $tracking_link, $status);

    if ($stmt->execute()) {
        $updateOrderStatus = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
        $updateOrderStatus->bind_param("si", $status, $order_id);
        $updateOrderStatus->execute();

        $_SESSION['message'] = "Tracking information assigned successfully!";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

header("Location: index1.php");
exit();
?>
