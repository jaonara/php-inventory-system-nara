<?php
include '../PHP/database.php';

$sql = "SELECT o.order_id, o.order_date, c.first_name, c.last_name, SUM(oi.quantity) AS total_items
        FROM orders o
        JOIN customers c ON o.customer_id = c.customer_id
        LEFT JOIN order_items oi ON o.order_id = oi.order_id
        GROUP BY o.order_id, o.order_date, c.first_name, c.last_name
        ORDER BY o.order_id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>View Orders</title>
  <link rel="stylesheet" href="../CSS/style.css?v=2">
</head>
<body>
  <div class="wrapper">
    <main>
      <h1>Orders</h1>
      <p class="btn-row">
        <button type="button" onclick="location.href='../PHP/index.php'">Back</button>
        <button type="button" onclick="location.href='../ADD/add_order.php'">Create Order</button>
      </p>
      
      <?php
      if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID</th><th>Customer</th><th>Date</th><th>Total items</th><th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>".$row['order_id']."</td>";
          echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
          echo "<td>".$row['order_date']."</td>";
          $total = $row['total_items'] ? $row['total_items'] : 0;
          echo "<td>".$total."</td>";
          echo "<td>";
          echo "<a href='order_details.php?id=".$row['order_id']."'>View</a> | ";
          echo "<a href='../EDIT/edit_order.php?id=".$row['order_id']."'>Edit</a>";
          echo "</td>";
          echo "</tr>";
        }
        echo "</table>";
      } else {
        echo "<p>No orders found.</p>";
      }
      $conn->close();
      ?>
    </main>
  </div>
</body>
</html>
