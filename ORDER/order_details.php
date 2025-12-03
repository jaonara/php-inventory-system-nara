<?php
include '../PHP/database.php';

$id = $_GET['id'];

$sql = "SELECT o.order_id, o.order_date, c.first_name, c.last_name
        FROM orders o
        JOIN customers c ON o.customer_id = c.customer_id
        WHERE o.order_id = $id";
$result = $conn->query($sql);
$order = $result->fetch_assoc();

if (!$order) {
  die("Order not found.");
}

$sql2 = "SELECT oi.quantity, p.product_name, p.price, (oi.quantity * p.price) AS line_total
         FROM order_items oi
         JOIN products p ON oi.product_id = p.product_id
         WHERE oi.order_id = $id";
$result2 = $conn->query($sql2);

$total = 0;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Order Details</title>
  <link rel="stylesheet" href="../CSS/style.css?v=2">
</head>
<body>
  <div class="wrapper">
    <main>
      <h1>Order #<?php echo $order['order_id']; ?></h1>
      <p>
        <strong>Customer:</strong> <?php echo $order['first_name']." ".$order['last_name']; ?><br>
        <strong>Date:</strong> <?php echo $order['order_date']; ?>
      </p>
      
      <?php
      if ($result2->num_rows > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Product</th><th>Price</th><th>Qty</th><th>Sub Total</th></tr>";
        while ($item = $result2->fetch_assoc()) {
          echo "<tr>";
          echo "<td>".$item['product_name']."</td>";
          echo "<td>₱ ".number_format($item['price'], 2)."</td>";
          echo "<td>".$item['quantity']."</td>";
          echo "<td>₱ ".number_format($item['line_total'], 2)."</td>";
          echo "</tr>";
          $total += $item['line_total'];
        }
        echo "<tr>";
        echo "<td colspan='3' style='text-align:right;'><strong>Order Total:</strong></td>";
        echo "<td><strong>₱ ".number_format($total, 2)."</strong></td>";
        echo "</tr>";
        echo "</table>";
      } else {
        echo "<p>No items in this order.</p>";
      }
      ?>
      
      <p class="order_details_btn">
        <button type="button" onclick="location.href='../EDIT/edit_order.php?id=<?php echo $order['order_id']; ?>'">Edit Order</button>
        <button type="button" onclick="location.href='view_orders.php'">Back to orders</button>
      </p>
    </main>
  </div>
</body>
</html>
