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

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT category_name FROM categories WHERE category_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name);
if (!$stmt->fetch()) {
  $stmt->close();
  die("Category not found.");
}
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['category_name']);
  if ($name !== '') {
    $stmt = $conn->prepare("UPDATE categories SET category_name = ? WHERE category_id = ?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_categories.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Category</title>
</head>
<body>
  <h1>Edit Category</h1>
  <form method="post">
    <p>
      <label>Category name:</label>
      <input type="text" name="category_name" value="<?php echo htmlspecialchars($name); ?>" required>
    </p>
    <div class="btn-edit-category">
      <button type="submit">Update</button>
      </form>
      <p>
        <button type="button" onclick="window.location.href='manage_categories.php'">
          Back to Categories
        </button>
      </p>
    </div>
</body>
</html>
    </main>
  </div>
</body>
</html>