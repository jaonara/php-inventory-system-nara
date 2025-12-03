<?php
include '../PHP/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['product_name'];
  $price = $_POST['price'];
  $stock = isset($_POST['stock']) ? $_POST['stock'] : 0;
  $category_id = $_POST['category_id'];
  
  if ($name != '') {
    if ($category_id == '') {
      $sql = "INSERT INTO products (product_name, price, stock) VALUES ('$name', $price, $stock)";
    } else {
      $sql = "INSERT INTO products (product_name, category_id, price, stock) VALUES ('$name', $category_id, $price, $stock)";
    }
    
    if ($conn->query($sql)) {
      header("Location: ../PHP/index.php");
    } else {
      $error = "Error: " . $conn->error;
    }
  }
}

$categories = $conn->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
  <link rel="stylesheet" href="../CSS/style.css?v=2">
</head>
<body>
  <div class="wrapper">
    <main>
      <h1>Add Product</h1>
      
      <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
      
      <form method="post">
        <p>
          <label>Product name:</label>
          <input type="text" name="product_name" required>
        </p>
        <p>
          <label>Category:</label>
          <select name="category_id">
            <option value="">-- Select Category --</option>
            <?php
            while ($row = $categories->fetch_assoc()) {
              echo "<option value='".$row['category_id']."'>".$row['category_name']."</option>";
            }
            ?>
          </select>
        </p>
        <p>
          <label>Price (₱):</label>
          <input type="number" name="price" step="0.01" required>
        </p>
        <p>
          <label>Stock:</label>
          <input type="number" name="stock" min="0" value="0" required>
        </p>
        <div class="button-back">
          <button type="submit">Save</button>
          <button type="button" onclick="location.href='../PHP/index.php'">Back</button>
        </div>
      </form>
    </main>
  </div>
</body>
</html>
