<?php
// Get the category data
$category_name = filter_input(INPUT_POST, 'category_name');
$category_id = filter_input(INPUT_POST, 'category_id');

// Validate inputs
if ($category_name == null || $category_id == null) {
    $error = "Invalid category data. Check all fields and try again.";
    include('error.php');
} else {
    require_once('database.php');

    // Add the product to the database
    $query = "INSERT INTO categories
              VALUES (:id, :name)";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $category_name);
    $statement->bindValue(':id', $category_id);
    $statement->execute();
    $statement->closeCursor();

    // Display the Category List page
    include('category_list.php');
}
?>