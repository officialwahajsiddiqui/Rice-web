<?php
session_start();
include 'db.php'; // Ensure PDO connection

if (!isset($_GET['order_id'])) {
    die("Order ID is required.");
}

$order_id = $_GET['order_id'];

try {
    // Fetch order details
    $orderStmt = $conn->prepare("SELECT * FROM orders WHERE order_id = :order_id");
    $orderStmt->execute(['order_id' => $order_id]);
    $order = $orderStmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        die("Order not found.");
    }

    // Fetch order items with product details and popularity
    $itemsStmt = $conn->prepare("
        SELECT 
            oi.order_item_id, 
            oi.quantity, 
            p.p_name, 
            p.p_image, 
            p.p_price, 
            p.p_description, 
            p.p_brand, 
            p.cat_name, 
            IF(pp.p_id IS NOT NULL, 'Yes', 'No') AS popular 
        FROM order_items oi
        JOIN products p ON oi.product_id = p.p_id
        LEFT JOIN popular_products pp ON p.p_id = pp.p_id
        WHERE oi.order_id = :order_id
    ");
    $itemsStmt->execute(['order_id' => $order_id]);
    $orderItems = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Debug: Check if order items were fetched
    if (empty($orderItems)) {
        die("No items found for this order. Please check your data.");
    }
} catch (PDOException $e) {
    die("Failed to fetch order details: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
</head>
<body>

<h2>Order Details for Order ID: <?php echo htmlspecialchars($order_id); ?></h2>
<p><strong>Customer Name:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
<p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
<p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
<p><strong>Total Amount:</strong> <?php echo htmlspecialchars($order['total_amount']); ?></p>
<p><strong>Order Date:</strong> <?php echo htmlspecialchars($order['order_date']); ?></p>

<h3>Order Items</h3>
<?php if (!empty($orderItems)): ?>
<table border="1">
<tr>
    <th>Order Item ID</th>
    <th>Product Name</th>
    <th>Image</th>
    <th>Price</th>
    <th>Description</th>
    <th>Brand</th>
    <th>Category Name</th>
    <th>Kg/Quantity</th>
    <th>Popular</th>
</tr>

<?php foreach ($orderItems as $item): ?>
<tr>
    <td><?php echo htmlspecialchars($item['order_item_id']); ?></td>
    <td><?php echo htmlspecialchars($item['p_name']); ?></td>
    <td><img src="<?php echo htmlspecialchars($item['p_image']); ?>" alt="<?php echo htmlspecialchars($item['p_name']); ?>" style="width:50px;height:50px;"></td>
    <td><?php echo htmlspecialchars($item['p_price']); ?></td>
    <td><?php echo htmlspecialchars($item['p_description']); ?></td>
    <td><?php echo htmlspecialchars($item['p_brand']); ?></td>
    <td><?php echo htmlspecialchars($item['cat_name']); ?></td>
    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
    <td><?php echo htmlspecialchars($item['popular']); ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php else: ?>
<p>No items found for this order.</p>
<?php endif; ?>

<a href="orders.php">Back to Orders</a>

</body>
</html>
