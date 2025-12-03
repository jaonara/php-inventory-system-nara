<?php
include '../PHP/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $first = $_POST['first_name'];
  $last = $_POST['last_name'];
  $email = $_POST['email'];
  
  if ($first != '' && $last != '') {
    $sql = "INSERT INTO customers (first_name, last_name, email) VALUES ('$first', '$last', '$email')";
    if ($conn->query($sql)) {
      header("Location: add_order.php");
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Customer</title>
  <link rel="stylesheet" href="../CSS/style.css?v=2">
</head>
<body>
  <div class="wrapper">
    <main>
      <h1>Add Customer</h1>
      
      <form method="post">
        <p>
          <label>First name:</label>
          <input type="text" name="first_name" required>
        </p>
        <p>
          <label>Last name:</label>
          <input type="text" name="last_name" required>
        </p>
        <p>
          <label>Email:</label>
          <input type="email" name="email">
        </p>
        <div class="button-back">
          <button type="submit">Save</button>
          <button type="button" onclick="location.href='../PHP/index.php'">Back</button>
        </div>
      </form>
    </main>
  </div>
</body>
</html>
