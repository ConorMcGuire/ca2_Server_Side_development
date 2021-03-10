<?php

// Get the record data
$motorbike_id = filter_input(INPUT_POST, 'motorbike_id', FILTER_VALIDATE_INT);
$category_id = filter_input(INPUT_POST, 'category_id');
$make = filter_input(INPUT_POST, 'make');
$model = filter_input(INPUT_POST, 'model');
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
$engine_size = filter_input(INPUT_POST, 'engine_size', FILTER_VALIDATE_INT);

// Validate inputs
if ($motorbike_id == NULL || $motorbike_id == FALSE || $category_id == NULL ||
empty($category_id) || empty($make) || empty($model) || 
$price == NULL || $price == FALSE ||
$year == NULL || $year == FALSE ||
$engine_size == NULL || $engine_size == FALSE) {
$error = "Invalid motorbike data. Check all fields and try again.";
include('error.php');
} else {

/**************************** Image upload ****************************/

$imgFile = $_FILES['image']['name'];
$tmp_dir = $_FILES['image']['tmp_name'];
$imgSize = $_FILES['image']['size'];
$original_image = filter_input(INPUT_POST, 'original_image');

if ($imgFile) {
$upload_dir = 'image_uploads/'; // upload directory	
$imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
$image = rand(1000, 1000000) . "." . $imgExt;
if (in_array($imgExt, $valid_extensions)) {
if ($imgSize < 5000000) {
if (filter_input(INPUT_POST, 'original_image') !== "") {
unlink($upload_dir . $original_image);                    
}
move_uploaded_file($tmp_dir, $upload_dir . $image);
} else {
$errMSG = "Sorry, your file is too large it should be less then 5MB";
}
} else {
$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
}
} else {
// if no image selected the old image remain as it is.
$image = $original_image; // old image from database
}

/************************** End Image upload **************************/

// If valid, update the record in the database
require_once('database.php');

$query = 'UPDATE motorbikes
SET category_id = :category_id,
make = :make,
model = :model,
price = :price,
year = :year,
engine_size = :engine_size,
image = :image
WHERE motorbike_id = :motorbike_id';
$statement = $db->prepare($query);
$statement->bindValue(':category_id', $category_id);
$statement->bindValue(':make', $make);
$statement->bindValue(':model', $model);
$statement->bindValue(':engine_size', $engine_size);
$statement->bindValue(':year', $year);
$statement->bindValue(':price', $price);
$statement->bindValue(':image', $image);
$statement->bindValue(':motorbike_id', $motorbike_id);
$statement->execute();
$statement->closeCursor();

// Display the Product List page
include('index.php');
}
?>