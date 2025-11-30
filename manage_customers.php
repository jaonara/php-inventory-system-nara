<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Manage Customer</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrapper">
    <main>

<?php
include 'database.php';

$result = $conn->query("SELECT customer_id, first_name, last_name, email FROM customers ORDER BY customer_id ASC");

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Customers</title>
</head>
<body>
  <h1>Customers Record</h1>
  <p class="btn-customers">
    <button type="button" class="btn btn-ghost" onclick="location.href='index.php'">Back to products</button>
    <button type="button" class="btn" onclick="location.href='add_customer.php'">Add Customer</button>
  </p>

  <?php
  if ($result && $result->num_rows > 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr>";
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>".$row['customer_id']."</td>";
      echo "<td>".htmlspecialchars($row['first_name']." ".$row['last_name'])."</td>";
      echo "<td>".htmlspecialchars($row['email'])."</td>";
      echo "<td>
              <a href='edit_customer.php?id=".$row['customer_id']."'>Edit</a> |
              <a href='delete_customer.php?id=".$row['customer_id']."' onclick=\"return confirm('Delete this customer?');\">Delete</a>
            </td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "<p>No customers found.</p>";
  }
  $conn->close();
  ?>
</body>
</html>
    </main>
  </div>
</body>
</html>