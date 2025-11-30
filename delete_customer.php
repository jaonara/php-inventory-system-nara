<?php
include 'database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// optional: check if this customer has orders first

if ($id > 0) {
  $stmt = $conn->prepare("DELETE FROM customers WHERE customer_id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();
}

header("Location: manage_customers.php");
exit;
