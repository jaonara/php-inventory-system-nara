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

// load customers
$customers = [];
$r1 = $conn->query("SELECT customer_id, first_name, last_name FROM customers ORDER BY first_name");
if ($r1) {
  while ($row = $r1->fetch_assoc()) {
    $customers[] = $row;
  }
}

// load products
$products = [];
$r2 = $conn->query("SELECT product_id, product_name, price FROM products ORDER BY product_name");
if ($r2) {
  while ($row = $r2->fetch_assoc()) {
    $products[] = $row;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $customerId = (int)$_POST['customer_id'];
  $productId  = (int)$_POST['product_id'];
  $qty        = (int)$_POST['quantity'];

  if ($customerId > 0 && $productId > 0 && $qty > 0) {
    // create order
    $stmt = $conn->prepare("INSERT INTO orders (customer_id, order_date) VALUES (?, NOW())");
    $stmt->bind_param("i", $customerId);
    $stmt->execute();
    $orderId = $stmt->insert_id;
    $stmt->close();

    // add order item
    $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
    $stmt2->bind_param("iii", $orderId, $productId, $qty);
    $stmt2->execute();
    $stmt2->close();

    header("Location: order_details.php?id=".$orderId);
    exit;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Create Order</title>
</head>
<body>
  <h1>Create Order</h1>
  <form method="post">
    <p>
      <label>Customer:</label>
      <select name="customer_id" required>
        <option value="">-- Select Customer --</option>
        <?php foreach ($customers as $c): ?>
          <option value="<?php echo $c['customer_id']; ?>">
            <?php echo htmlspecialchars($c['first_name']." ".$c['last_name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </p>
    <p>
      <label>Product:</label>
      <select name="product_id" required>
        <option value="">-- Select Product --</option>
        <?php foreach ($products as $p): ?>
          <option value="<?php echo $p['product_id']; ?>">
            <?php echo htmlspecialchars($p['product_name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </p>
    <p>
      <label>Quantity:</label>
      <input type="number" name="quantity" min="1" value="1" required>
    </p>
    <div class="btn-order">
        <button type="submit">Create Order</button>
      </form>
      <p class="btn-add-order">
        <button type="button" class="btn btn-ghost" onclick="location.href='index.php'">Back</button>
      </p>
    </div>
</body>
</html>
    </main>
  </div>
</body>
</html>