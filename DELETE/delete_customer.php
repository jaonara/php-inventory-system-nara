<?php
include '../PHP/database.php';

$id = $_GET['id'];

if ($id > 0) {
  $sql = "DELETE FROM customers WHERE customer_id = $id";
  $conn->query($sql);
}

header("Location: ../PHP/manage_customers.php");
?>
