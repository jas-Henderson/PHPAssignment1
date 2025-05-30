<?php
require_once('database.php');

// Get updated product data
$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
$code = filter_input(INPUT_POST, 'code');
$name = filter_input(INPUT_POST, 'name');
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

// Validate inputs
if ($product_id == NULL || $product_id == FALSE ||
    $category_id == NULL || $category_id == FALSE ||
    $code == NULL || $name == NULL ||
    $price == NULL || $price == FALSE) {

    $error = "Invalid product data. Check all fields and try again.";
    include('error.php');
    exit();
}

// Update the product in the database
$query = 'UPDATE products
          SET categoryID = :category_id,
              productCode = :code,
              productName = :name,
              listPrice = :price
          WHERE productID = :product_id';

$statement = $db->prepare($query);
$statement->bindValue(':category_id', $category_id);
$statement->bindValue(':code', $code);
$statement->bindValue(':name', $name);
$statement->bindValue(':price', $price);
$statement->bindValue(':product_id', $product_id);
$statement->execute();
$statement->closeCursor();

// Redirect to product list
include('index.php');