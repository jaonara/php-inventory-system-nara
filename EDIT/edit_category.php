<?php
include '../PHP/database.php';

$id = $_GET['id'];

$sql = "SELECT category_name FROM categories WHERE category_id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if (!$row) {
  die("Category not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['category_name'];
  
  if ($name != '') {
    $sql = "UPDATE categories SET category_name = '$name' WHERE category_id = $id";
    if ($conn->query($sql)) {
      header("Location: ../PHP/manage_categories.php");
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Category</title>
  <link rel="stylesheet" href="../CSS/style.css?v=2">
</head>
<body>
  <div class="wrapper">
    <main>
      <h1>Edit Category</h1>
      
      <form method="post">
        <p>
          <label>Category name:</label>
          <input type="text" name="category_name" value="<?php echo $row['category_name']; ?>" required>
        </p>
        <div class="button-back">
          <button type="submit">Update</button>
          <button type="button" onclick="location.href='../PHP/manage_categories.php'">Back</button>
        </div>
      </form>
    </main>
  </div>
</body>
</html>
