<?php
include '../PHP/database.php';

$id = $_GET['id'];

$sql = "SELECT product_name, category_id, price, stock FROM products WHERE product_id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if (!$row) {
  die("Product not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['product_name'];
  $price = $_POST['price'];
  $stock = $_POST['stock'];
  $category_id = $_POST['category_id'];
  
  if ($category_id == '') {
    $sql = "UPDATE products SET product_name = '$name', category_id = NULL, price = $price, stock = $stock WHERE product_id = $id";
  } else {
    $sql = "UPDATE products SET product_name = '$name', category_id = $category_id, price = $price, stock = $stock WHERE product_id = $id";
  }
  
  if ($conn->query($sql)) {
    header("Location: ../PHP/index.php");
  }
}

$categories = $conn->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Product</title>
  <link rel="stylesheet" href="../CSS/style.css?v=2">
</head>
<body>
  <div class="wrapper">
    <main>
      <h1>Edit Product</h1>
      
      <form method="post">
        <p>
          <label>Product name:</label>
          <input type="text" name="product_name" value="<?php echo $row['product_name']; ?>" required>
        </p>
        <p>
          <label>Category:</label>
          <select name="category_id">
            <option value="">-- Select Category --</option>
            <?php
            while ($cat = $categories->fetch_assoc()) {
              $selected = ($cat['category_id'] == $row['category_id']) ? 'selected' : '';
              echo "<option value='".$cat['category_id']."' $selected>".$cat['category_name']."</option>";
            }
            ?>
          </select>
        </p>
        <p>
          <label>Price (₱):</label>
          <input type="number" name="price" step="0.01" value="<?php echo $row['price']; ?>" required>
        </p>
        <p>
          <label>Stock:</label>
          <input type="number" name="stock" min="0" value="<?php echo $row['stock']; ?>" required>
        </p>
        <div class="button-back">
          <button type="submit">Update</button>
          <button type="button" onclick="location.href='../PHP/index.php'">Back</button>
        </div>
      </form>
    </main>
  </div>
</body>
</html>
