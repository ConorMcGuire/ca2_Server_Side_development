<?php
require_once('database.php');

// Get IDs
$motorbike_id = filter_input(INPUT_POST, 'motorbike_id', FILTER_VALIDATE_INT);
$category_id = filter_input(INPUT_POST, 'category_id');

// Delete the product from the database
if ($motorbike_id != false && $category_id != false) {
    $query = "DELETE FROM motorbikes
              WHERE motorbike_id = :motorbike_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':motorbike_id', $motorbike_id);
    $statement->execute();
    $statement->closeCursor();
}

// display the Product List page
include('index.php');
?>