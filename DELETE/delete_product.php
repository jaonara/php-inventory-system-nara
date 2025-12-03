<?php
include '../PHP/database.php';

$id = $_GET['id'];

if ($id > 0) {
  $sql = "DELETE FROM products WHERE product_id = $id";
  $conn->query($sql);
}

header("Location: ../PHP/index.php");
?>
