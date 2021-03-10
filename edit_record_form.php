<?php
require('database.php');

$motorbike_id = filter_input(INPUT_POST, 'motorbike_id', FILTER_VALIDATE_INT);
$query = 'SELECT *
          FROM motorbikes
          WHERE motorbike_id = :motorbike_id';
$statement = $db->prepare($query);
$statement->bindValue(':motorbike_id', $motorbike_id);
$statement->execute();
$motorbikes = $statement->fetch(PDO::FETCH_ASSOC);
$statement->closeCursor();
?>
<!-- the head section -->
 <div class="container">
<?php
include('includes/header.php');
?>
        <h1>Edit Motorbike Details</h1>
        <form action="edit_record.php" method="post" enctype="multipart/form-data"
              id="add_record_form">
            <input type="hidden" name="original_image" value="<?php echo $motorbikes['image']; ?>" />
            <input type="hidden" name="motorbike_id"
                   value="<?php echo $motorbikes['motorbike_id']; ?>">

            <label>Category ID:</label>
            <input type="category_id" name="category_id"
                   value="<?php echo $motorbikes['category_id']; ?>" required>
            <br>

            <label>Make:</label>
            <input type="input" name="make"
                   value="<?php echo $motorbikes['make']; ?>" required placeholder="Enter manufacturer">
            <br>

            <label>Model:</label>
            <input type="input" name="model"
                   value="<?php echo $motorbikes['model']; ?>" required placeholder="Enter model">
            <br>

            <label>List Price:</label>
            <input type="input" name="price" pattern="\d{1,5}\.\d{2}"
                   value="<?php echo $motorbikes['price']; ?>" required placeholder="Enter Price">
            <br>

            <label>Year:</label>
            <input type="input" name="year"
                   value="<?php echo $motorbikes['year']; ?>" required placeholder="Enter year">
            <br>

            <label>Engine Size:</label>
            <input type="input" name="engine_size"
                   value="<?php echo $motorbikes['engine_size']; ?>" required placeholder="Enter engine size">
            <br>

            <label>Image:</label>
            <input type="file" name="image" accept="image/*" required/>
            <br>            
            <?php if ($motorbikes['image'] != "") { ?>
            <p><img src="image_uploads/<?php echo $motorbikes['image']; ?>" height="150" /></p>
            <?php } ?>
            
            <label>&nbsp;</label>
            <input type="submit" value="Save Changes">
            <br>
        </form>
        <p><a href="index.php">View Homepage</a></p>
    <?php
include('includes/footer.php');
?>