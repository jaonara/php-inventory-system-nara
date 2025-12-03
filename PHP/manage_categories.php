<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Manage Categories</title>
  <link rel="stylesheet" href="../CSS/style.css?v=2">
</head>
<body>
      <div class="wrapper">
        <main>

    <?php
    include 'database.php';

    $result = $conn->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
    ?>
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="UTF-8">
      <title>Categories</title>
    </head>
      <body>
          <h1>Categories</h1>
          <p class="btn-row-categories">
            <button type="button" class="btn btn-ghost" onclick="location.href='index.php'">Back</button>
            <button type="button" class="btn" onclick="location.href='../ADD/add_category.php'">Add Category</button>
          </p>

          <?php
            if ($result && $result->num_rows > 0) {
              echo "<table border='1' cellpadding='5' cellspacing='0'>";
              echo "<tr><th>ID</th><th>Name</th><th>Actions</th></tr>";
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['category_id']."</td>";
                echo "<td>".htmlspecialchars($row['category_name'])."</td>";
                echo "<td>
                        <a href='../EDIT/edit_category.php?id=".$row['category_id']."'>Edit</a> |
                        <a href='../DELETE/delete_category.php?id=".$row['category_id']."' onclick=\"return confirm('Delete this category?');\">Delete</a>
                      </td>";
                echo "</tr>";
              }
              echo "</table>";
            } else {
              echo "<p>No categories found.</p>";
            }
            $conn->close();
          ?>
      </body>
    </html>
    </main>
  </div>
</body>
</html>
