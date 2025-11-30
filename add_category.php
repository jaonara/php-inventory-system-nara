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

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = trim($_POST['category_name']);

            if ($name !== "") {
                $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
                $stmt->bind_param("s", $name);
                $stmt->execute();
                $stmt->close();
                header("Location: manage_categories.php");
                exit;
            }
            }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="UTF-8">
        <title>Add Category</title>
        </head>
        <body>
            <h1>Add Category</h1>
                <form method="post">
                    <label>Category name:</label>
                    <input type="text" name="category_name" required>
                    <button type="submit">Save</button>
                </form>
                <p><a href="index.php">Back</a></p>
            </body>
        </html>

    </main>
  </div>
</body>
</html>
