<?php
include '../PHP/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get order info
$sql = "SELECT order_id, customer_id, order_date FROM orders WHERE order_id = $id";
$result = $conn->query($sql);
$order = $result->fetch_assoc();

if (!$order) {
  die("Order not found.");
}

// Get order items
$sql2 = "SELECT oi.order_item_id, oi.product_id, oi.quantity, p.product_name, p.price 
         FROM order_items oi 
         JOIN products p ON oi.product_id = p.product_id 
         WHERE oi.order_id = $id";
$result2 = $conn->query($sql2);

// Get customers
$customers = $conn->query("SELECT customer_id, first_name, last_name FROM customers ORDER BY first_name");

// Get products
$products = $conn->query("SELECT product_id, product_name, price FROM products ORDER BY product_name");

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $customer_id = (int)$_POST['customer_id'];
  
  // Update customer
  $sql = "UPDATE orders SET customer_id = $customer_id WHERE order_id = $id";
  $conn->query($sql);
  
  // Update quantities
  if (isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $item_id => $qty) {
      $item_id = (int)$item_id;
      $qty = (int)$qty;
      if ($qty > 0) {
        $sql = "UPDATE order_items SET quantity = $qty WHERE order_item_id = $item_id";
        $conn->query($sql);
      } else {
        $sql = "DELETE FROM order_items WHERE order_item_id = $item_id";
        $conn->query($sql);
      }
    }
  }
  
  // Delete checked items
  if (isset($_POST['delete'])) {
    foreach ($_POST['delete'] as $item_id) {
      $item_id = (int)$item_id;
      $sql = "DELETE FROM order_items WHERE order_item_id = $item_id";
      $conn->query($sql);
    }
  }
  
  // Add new item
  if (isset($_POST['new_product_id']) && $_POST['new_product_id'] != '' && isset($_POST['new_quantity'])) {
    $new_product_id = (int)$_POST['new_product_id'];
    $new_quantity = (int)$_POST['new_quantity'];
    if ($new_product_id > 0 && $new_quantity > 0) {
      $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES ($id, $new_product_id, $new_quantity)";
      $conn->query($sql);
    }
  }
  
  header("Location: ../ORDER/order_details.php?id=$id");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Order</title>
  <link rel="stylesheet" href="../CSS/style.css?v=2">
</head>
<body>
  <div class="wrapper">
    <main>
      <h1>Edit Order #<?php echo $order['order_id']; ?></h1>
      <p><strong>Date:</strong> <?php echo $order['order_date']; ?></p>
      
      <form method="post">
        <p>
          <label>Customer:</label>
          <select name="customer_id">
            <?php
            while ($row = $customers->fetch_assoc()) {
              $selected = ($row['customer_id'] == $order['customer_id']) ? 'selected' : '';
              echo "<option value='".$row['customer_id']."' $selected>";
              echo $row['first_name']." ".$row['last_name'];
              echo "</option>";
            }
            ?>
          </select>
        </p>
        
        <h2>Current Items</h2>
        <table border="1" cellpadding="5" cellspacing="0">
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Delete</th>
          </tr>
          <?php
          while ($item = $result2->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$item['product_name']."</td>";
            echo "<td>₱ ".number_format($item['price'], 2)."</td>";
            echo "<td>";
            echo "<input type='number' name='quantity[".$item['order_item_id']."]' value='".$item['quantity']."' min='1' style='width: 60px;'>";
            echo "</td>";
            echo "<td>₱ ".number_format($item['price'] * $item['quantity'], 2)."</td>";
            echo "<td>";
            echo "<input type='checkbox' name='delete[]' value='".$item['order_item_id']."'>";
            echo "</td>";
            echo "</tr>";
          }
          ?>
        </table>
        
        <h2>Add New Item</h2>
        <p>
          <label>Product:</label>
          <select name="new_product_id">
            <option value="">-- Select Product --</option>
            <?php
            while ($row = $products->fetch_assoc()) {
              echo "<option value='".$row['product_id']."'>";
              echo $row['product_name']." - ₱ ".number_format($row['price'], 2);
              echo "</option>";
            }
            ?>
          </select>
        </p>
        <p>
          <label>Quantity:</label>
          <input type="number" name="new_quantity" min="1" value="1">
        </p>
        
        <div class="button-back">
          <button type="submit">Update Order</button>
          <button type="button" onclick="location.href='../ORDER/order_details.php?id=<?php echo $id; ?>'">Cancel</button>
        </div>
      </form>
    </main>
  </div>
</body>
</html>
