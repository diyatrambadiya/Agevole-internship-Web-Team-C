<!DOCTYPE html>
<html>
<head>
    <title>Dispatch Panel</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<?php
// Sample orders array
$orders = [
    ['id' => 1, 'customer' => 'John Smith', 'product' => 'Item A', 'tracking_number' => '', 'tracking_link' => '', 'status' => 'Pending'],
    ['id' => 2, 'customer' => 'Jane Doe', 'product' => 'Item B', 'tracking_number' => '', 'tracking_link' => '', 'status' => 'Pending'],
    ['id' => 3, 'customer' => 'Alex Johnson', 'product' => 'Item C', 'tracking_number' => '', 'tracking_link' => '', 'status' => 'Pending']
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update tracking numbers, tracking links, and status
    foreach ($orders as &$order) {
        if (isset($_POST['tracking_number_'.$order['id']])) {
            $order['tracking_number'] = $_POST['tracking_number_'.$order['id']];
            $order['tracking_link'] = $_POST['tracking_link_'.$order['id']];
            $order['status'] = $_POST['status_'.$order['id']];
        }
    }
}

?>

<h2>Dispatch Panel</h2>

<table>
    <tr>
        <th>Order ID</th>
        <th>Customer Name</th>
        <th>Product</th>
        <th>Tracking Number</th>
        <th>Tracking Link</th>
        <th>Status</th>
    </tr>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php foreach ($orders as $order): ?>
    <tr>
        <td><?php echo $order['id']; ?></td>
        <td><?php echo $order['customer']; ?></td>
        <td><?php echo $order['product']; ?></td>
        <td><input type="text" name="tracking_number_<?php echo $order['id']; ?>" value="<?php echo $order['tracking_number']; ?>"></td>
        <td><input type="text" name="tracking_link_<?php echo $order['id']; ?>" value="<?php echo $order['tracking_link']; ?>"></td>
        <td>
            <select name="status_<?php echo $order['id']; ?>">
                <option value="Pending" <?php if ($order['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="Picked" <?php if ($order['status'] == 'Picked') echo 'selected'; ?>>Picked</option>
                <option value="In Transit" <?php if ($order['status'] == 'In Transit') echo 'selected'; ?>>In Transit</option>
                <option value="Delivered" <?php if ($order['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
            </select>
        </td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="6"><input type="submit" value="Update"></td>
    </tr>
    </form>
</table>

</body>
</html>
        