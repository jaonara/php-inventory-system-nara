<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Customer</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrapper">
    <main>

<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $first = trim($_POST['first_name']);
  $last  = trim($_POST['last_name']);
  $email = trim($_POST['email']);

  if ($first !== '' && $last !== '') {
    $stmt = $conn->prepare("INSERT INTO customers (first_name, last_name, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $first, $last, $email);
    $stmt->execute();
    $stmt->close();
    header("Location: add_order.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Customer</title>
</head>
<body>
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

    <div class="btn-add-customer">
      <button type="submit">Save</button>
      </form>
        <p>
          <button type="button" class="btn btn-ghost" onclick="location.href='index.php'">Back to products</button>
        </p>
    </div>
</body>
</html>
    </main>
  </div>
</body>
</html>