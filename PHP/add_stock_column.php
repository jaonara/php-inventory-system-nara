<?php
include 'database.php';

// Check if stock column already exists
$checkColumn = $conn->query("SHOW COLUMNS FROM `products` LIKE 'stock'");

if ($checkColumn->num_rows == 0) {
    // Add stock column
    $sql = "ALTER TABLE `products` ADD `stock` INT(11) NOT NULL DEFAULT 0 AFTER `price`";
    
    if ($conn->query($sql)) {
        echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Stock Column Added</title>
    <link rel='stylesheet' href='../CSS/style.css?v=2'>
</head>
<body>
    <div class='wrapper'>
        <main>
            <h1>Success!</h1>
            <p style='color: green; font-size: 18px; margin: 20px 0;'>Stock column has been successfully added to the products table.</p>
            <p><a href='index.php' class='btn'>Go to Products</a></p>
        </main>
    </div>
</body>
</html>";
    } else {
        echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Error</title>
    <link rel='stylesheet' href='../CSS/style.css?v=2'>
</head>
<body>
    <div class='wrapper'>
        <main>
            <h1>Error</h1>
            <p style='color: red; font-size: 18px; margin: 20px 0;'>Error adding stock column: " . $conn->error . "</p>
            <p><a href='index.php' class='btn'>Go Back</a></p>
        </main>
    </div>
</body>
</html>";
    }
} else {
    echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Stock Column Already Exists</title>
    <link rel='stylesheet' href='../CSS/style.css?v=2'>
</head>
<body>
    <div class='wrapper'>
        <main>
            <h1>Stock Column Already Exists</h1>
            <p style='color: #f97316; font-size: 18px; margin: 20px 0;'>The stock column already exists in the products table.</p>
            <p><a href='index.php' class='btn'>Go to Products</a></p>
        </main>
    </div>
</body>
</html>";
}

$conn->close();
?>

