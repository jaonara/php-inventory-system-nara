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

$stmt = $conn->prepare("SELECT first_name, last_name, email FROM customers WHERE customer_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($first, $last, $email);
if (!$stmt->fetch()) {
  $stmt->close();
  die("Customer not found.");
}
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $first = trim($_POST['first_name']);
  $last  = trim($_POST['last_name']);
  $email = trim($_POST['email']);

  if ($first !== '' && $last !== '') {
    $stmt = $conn->prepare("UPDATE customers SET first_name = ?, last_name = ?, email = ? WHERE customer_id = ?");
    $stmt->bind_param("sssi", $first, $last, $email, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_customers.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Customer</title>
</head>
<body>
  <h1>Edit Customer</h1>
  <form method="post">
    <p>
      <label>First name:</label>
      <input type="text" name="first_name" value="<?php echo htmlspecialchars($first); ?>" required>
    </p>
    <p>
      <label>Last name:</label>
      <input type="text" name="last_name" value="<?php echo htmlspecialchars($last); ?>" required>
    </p>
    <p>
      <label>Email:</label>
      <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
    </p>
    <button type="submit">Update</button>
  </form>
  <p><a href="manage_customers.php">Back to customers</a></p>
</body>
</html>
    </main>
  </div>
</body>
</html>