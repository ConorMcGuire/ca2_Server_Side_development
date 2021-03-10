<?php
require('database.php');
$query = 'SELECT *
          FROM categories
          ORDER BY category_id';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();
?>
<!-- the head section -->
 <div class="container">
<?php
include('includes/header.php');
?>
        <h1>Add New Motorbike</h1>
        <form action="add_record.php" method="post" enctype="multipart/form-data"
              id="add_record_form">

            <label>Category:</label>
            <select name="category_id">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['category_id']; ?>">
                    <?php echo $category['category_name']; ?>
                </option>
            <?php endforeach; ?>
            </select>
            <br>
            <label>Make:</label>
            <input type="input" name="make" required placeholder="Enter manufacturer">
            <br>

            <label>Model:</label>
            <input type="input" name="model" required placeholder="Enter model">
            <br>

            <label>List Price:</label>
            <input type="input" name="price" required placeholder="Enter price" pattern="\d{1,5}\.\d{2}">
            <br>     
            
            <label>Year:</label>
            <input type="input" name="year" required placeholder="Enter year">
            <br>
            
            <label>Engine Size:</label>
            <input type="input" name="engine_size" required placeholder="Enter engine size">
            <br>   
            
            <label>Image:</label>
            <input type="file" name="image" accept="image/*" required/>
            <br>
            
            <label>&nbsp;</label>
            <input type="submit" value="Add Record">
            <br>
        </form>
        <p><a href="index.php">View Homepage</a></p>
    <?php
include('includes/footer.php');
?>