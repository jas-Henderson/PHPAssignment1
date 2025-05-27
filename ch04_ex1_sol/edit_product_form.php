<?php
require('database.php');

// Get product ID from the query string
$product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);
if ($product_id == null || $product_id == false) {
    $error = "Missing or incorrect product ID.";
    include('error.php');
    exit();
}

// Get the product details
$query = 'SELECT * FROM products WHERE productID = :product_id';
$statement = $db->prepare($query);
$statement->bindValue(':product_id', $product_id);
$statement->execute();
$product = $statement->fetch();
$statement->closeCursor();

// Get all categories for dropdown
$queryCategories = 'SELECT * FROM categories ORDER BY categoryID';
$statement = $db->prepare($queryCategories);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <header><h1>Edit Product</h1></header>
    <main>
        <form action="update_product.php" method="post" id="edit_product_form">
            <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">

            <label>Category:</label>
            <select name="category_id">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category['categoryID']; ?>"
                        <?php if ($category['categoryID'] == $product['categoryID']) echo 'selected'; ?>>
                        <?php echo $category['categoryName']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label>Code:</label>
            <input type="text" name="code" value="<?php echo htmlspecialchars($product['productCode']); ?>"><br>

            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['productName']); ?>"><br>

            <label>List Price:</label>
            <input type="text" name="price" value="<?php echo htmlspecialchars($product['listPrice']); ?>"><br>

            <label>&nbsp;</label>
            <input type="submit" value="Update Product">
        </form>
        <p><a href="index.php">Cancel and Return to Product List</a></p>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Guitar Shop, Inc.</p>
    </footer>
</body>
</html>