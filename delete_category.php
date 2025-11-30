
<?php
include 'database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// optional: check if any products use this category first

if ($id > 0) {
  $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();
}

header("Location: manage_categories.php");
exit;
