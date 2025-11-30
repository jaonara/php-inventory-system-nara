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

// load categories
$categories = [];
$res = $conn->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
if ($res) {
  while ($row = $res->fetch_assoc()) {
    $categories[] = $row;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = trim($_POST['product_name']);
  $price = (float)$_POST['price'];
  $catId = $_POST['category_id'] !== '' ? (int)$_POST['category_id'] : null;

  if ($name !== '') {
    $stmt = $conn->prepare("INSERT INTO products (product_name, category_id, price) VALUES (?, ?, ?)");
    $stmt->bind_param("sid", $name, $catId, $price);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
</head>
<body>
  <h1>Add Product</h1>
  <form method="post">
    <p>
      <label>Product name:</label>
      <input type="text" name="product_name" required>
    </p>
    <p>
      <label>Category:</label>
      <select name="category_id">
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $c): ?>
          <option value="<?php echo $c['category_id']; ?>">
            <?php echo htmlspecialchars($c['category_name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </p>
    <p>
      <label>Price:</label>
      <input type="number" name="price" step="0.01" required>
    </p>
    <div class="btn-add-product">
    <button type="submit">Save</button>
    </form>
    <p>
      <button type="button" class="btn btn-ghost" onclick="location.href='index.php'">Back</button>
    </p>
    </div>
</body>
</html>

    </main>
  </div>
</body>
</html>
