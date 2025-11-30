<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Product</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrapper">
    <main>

<?php

include 'database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// load product
$stmt = $conn->prepare("SELECT product_name, category_id, price FROM products WHERE product_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($productName, $categoryId, $price);
if (!$stmt->fetch()) {
  $stmt->close();
  die("Product not found.");
}
$stmt->close();

// load categories
$categories = [];
$res = $conn->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
if ($res) {
  while ($row = $res->fetch_assoc()) {
    $categories[] = $row;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $productName = trim($_POST['product_name']);
  $categoryId  = $_POST['category_id'] !== '' ? (int)$_POST['category_id'] : null;
  $price       = (float)$_POST['price'];

  $stmt = $conn->prepare("UPDATE products SET product_name = ?, category_id = ?, price = ? WHERE product_id = ?");
  $stmt->bind_param("sidi", $productName, $categoryId, $price, $id);
  $stmt->execute();
  $stmt->close();
  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Product</title>
</head>
<body>
  <h1>Edit Product</h1>
  <form method="post">
        <p>
            <label>Product name:</label>
            <input type="text" name="product_name" value="<?php echo htmlspecialchars($productName); ?>" required>
        </p>
        <p>
        <label>Category:</label>
        <select name="category_id">
            <option value="">-- Select Category --</option>
            <?php foreach ($categories as $c): ?>
            <option value="<?php echo $c['category_id']; ?>"
                <?php if ($c['category_id'] == $categoryId) echo 'selected'; ?>>
                <?php echo htmlspecialchars($c['category_name']); ?>
            </option>
            <?php endforeach; ?>
        </select>
        </p>
        <p>
            <label>Price:</label>
            <input type="number" step="0.01" name="price" value="<?php echo $price; ?>" required>
        </p>
        <button type="submit">Update</button>
  </form>
     <p>
        <button type="button" class="btn btn-ghost" onclick="location.href='index.php'">Back</button>
    </p>
</body>
</html>
    </main>
  </div>
</body>
</html>