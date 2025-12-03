<?php
include '../PHP/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $customer_id = $_POST['customer_id'];
  $product_id = $_POST['product_id'];
  $quantity = $_POST['quantity'];
  
  if ($customer_id > 0 && $product_id > 0 && $quantity > 0) {
    $sql = "INSERT INTO orders (customer_id, order_date) VALUES ($customer_id, NOW())";
    if ($conn->query($sql)) {
      $order_id = $conn->insert_id;
      $sql2 = "INSERT INTO order_items (order_id, product_id, quantity) VALUES ($order_id, $product_id, $quantity)";
      if ($conn->query($sql2)) {
        header("Location: ../ORDER/order_details.php?id=$order_id");
      }
    }
  }
}

$customers = $conn->query("SELECT customer_id, first_name, last_name FROM customers ORDER BY first_name");
$products = $conn->query("SELECT product_id, product_name, price FROM products ORDER BY product_name");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Create Order</title>
  <link rel="stylesheet" href="../CSS/style.css?v=2">
</head>
<body>
  <div class="wrapper">
    <main>
      <h1>Create Order</h1>
      
      <form method="post">
        <p>
          <label>Customer:</label>
          <select name="customer_id" required>
            <option value="">-- Select Customer --</option>
            <?php
            while ($row = $customers->fetch_assoc()) {
              echo "<option value='".$row['customer_id']."'>";
              echo $row['first_name']." ".$row['last_name'];
              echo "</option>";
            }
            ?>
          </select>
        </p>
        <p>
          <label>Product:</label>
          <select name="product_id" required>
            <option value="">-- Select Product --</option>
            <?php
            while ($row = $products->fetch_assoc()) {
              echo "<option value='".$row['product_id']."'>";
              echo $row['product_name'];
              echo "</option>";
            }
            ?>
          </select>
        </p>
        <p>
          <label>Quantity:</label>
          <input type="number" name="quantity" min="1" value="1" required>
        </p>
        <div class="button-back">
          <button type="submit">Create Order</button>
          <button type="button" onclick="location.href='../PHP/index.php'">Back</button>
        </div>
      </form>
    </main>
  </div>
</body>
</html>
