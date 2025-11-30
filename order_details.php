<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Page title here</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrapper">
    <main>

<?php
include 'database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get order + customer
$stmt = $conn->prepare("SELECT o.order_id, o.order_date,
                               c.first_name, c.last_name
                        FROM orders o
                        JOIN customers c ON o.customer_id = c.customer_id
                        WHERE o.order_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
  die("Order not found.");
}

// Get items with JOIN to products
$sql = "SELECT oi.quantity,
               p.product_name,
               p.price,
               (oi.quantity * p.price) AS line_total
        FROM order_items oi
        JOIN products p ON oi.product_id = p.product_id
        WHERE oi.order_id = ?";
$stmt2 = $conn->prepare($sql);
$stmt2->bind_param("i", $id);
$stmt2->execute();
$itemsResult = $stmt2->get_result();

$total = 0;
$items = [];
while ($row = $itemsResult->fetch_assoc()) {
  $items[] = $row;
  $total += $row['line_total'];
}
$stmt2->close();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Order Details</title>
</head>
<body>
  <h1>Order #<?php echo $order['order_id']; ?></h1>
  <p>
    Customer: <?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?><br>
    Date: <?php echo $order['order_date']; ?>
  </p>

  <?php if (count($items) > 0): ?>
    <table border="1" cellpadding="5" cellspacing="0">
      <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Sub Total</th>
      </tr>
      <?php foreach ($items as $it): ?>
        <tr>
          <td><?php echo htmlspecialchars($it['product_name']); ?></td>
          <td><?php echo $it['price']; ?></td>
          <td><?php echo $it['quantity']; ?></td>
          <td><?php echo $it['line_total']; ?></td>
        </tr>
      <?php endforeach; ?>
      <tr>
        <td colspan="3" style="text-align:right;"><strong>Order Total:</strong></td>
        <td><strong><?php echo $total; ?></strong></td>
      </tr>
    </table>
  <?php else: ?>
    <p>No items in this order.</p>
  <?php endif; ?>

  <p class="order_details_btn">
    <button type="button" class="btn btn-ghost" onclick="location.href='view_orders.php'">Back to orders</button>
  </p>
</body>
</html>
    </main>
  </div>
</body>
</html>