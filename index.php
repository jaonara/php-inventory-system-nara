<?php
include 'database.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css">
  <title>Nara Site</title>
</head>
<body>
  <div class="bgcontainer">
  <img src="lazashopee.png" alt="LazaShopee Logo" class="logo" height="150px" width="150px">
  <h1>Welcome to LazaShopee!</h1>

<p class="nav">
  <a class="btn" href="add_product.php">Products</a>
  <a class="btn btn-secondary" href="manage_categories.php">Categories</a>
  <a class="btn" href="view_orders.php">Orders</a>
  <a class="btn btn-ghost" href="manage_customers.php">Customers</a>
</p>

  <?php
  $sql = "SELECT p.product_id, p.product_name, p.price, c.category_name
          FROM products p
          LEFT JOIN categories c ON p.category_id = c.category_id
          ORDER BY p.product_id ASC";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>ID</th>
            <th>Product</th>
            <th>Category</th>
            <th>Price</th>
            <th>Actions</th>
          </tr>";
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>".$row['product_id']."</td>";
      echo "<td>".htmlspecialchars($row['product_name'])."</td>";
      echo "<td>".htmlspecialchars($row['category_name'])."</td>";
      echo "<td>".$row['price']."</td>";
      echo "<td>
              <a href='edit_product.php?id=".$row['product_id']."'>Edit</a> |
              <a href='delete_product.php?id=".$row['product_id']."' onclick=\"return confirm('Delete this product?');\">Delete</a>
            </td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "<p>No products found.</p>";
  }

  $conn->close();
  ?>
  </div>
</body>
</html>
