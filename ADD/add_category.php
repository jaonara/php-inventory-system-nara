<?php
include '../PHP/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['category_name'];
  
  if ($name != '') {
    $sql = "INSERT INTO categories (category_name) VALUES ('$name')";
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
  <title>Add Category</title>
  <link rel="stylesheet" href="../CSS/style.css?v=2">
</head>
<body>
  <div class="wrapper">
    <main>
      <h1>Add Category</h1>
      
      <form method="post">
        <p>
          <label>Category name:</label>
          <input type="text" name="category_name" required>
        </p>
        <div class="button-back">
          <button type="submit">Save</button>
          <button type="button" onclick="location.href='../PHP/manage_categories.php'">Back</button>
        </div>
      </form>
    </main>
  </div>
</body>
</html>
