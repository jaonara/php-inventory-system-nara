<?php
include '../PHP/database.php';

$id = $_GET['id'];

$sql = "SELECT first_name, last_name, email FROM customers WHERE customer_id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if (!$row) {
  die("Customer not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $first = $_POST['first_name'];
  $last = $_POST['last_name'];
  $email = $_POST['email'];
  
  if ($first != '' && $last != '') {
    $sql = "UPDATE customers SET first_name = '$first', last_name = '$last', email = '$email' WHERE customer_id = $id";
    if ($conn->query($sql)) {
      header("Location: ../PHP/manage_customers.php");
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Customer</title>
  <link rel="stylesheet" href="../CSS/style.css?v=2">
</head>
<body>
  <div class="wrapper">
    <main>
      <h1>Edit Customer</h1>
      
      <form method="post">
        <p>
          <label>First name:</label>
          <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required>
        </p>
        <p>
          <label>Last name:</label>
          <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required>
        </p>
        <p>
          <label>Email:</label>
          <input type="email" name="email" value="<?php echo $row['email']; ?>">
        </p>
        <div class="button-back">
          <button type="submit">Update</button>
          <button type="button" onclick="location.href='../PHP/manage_customers.php'">Back</button>
        </div>
      </form>
    </main>
  </div>
</body>
</html>
