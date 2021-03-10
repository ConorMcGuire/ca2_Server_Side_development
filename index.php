<?php
require_once('database.php');

// Get category ID
if (!isset($category_id)) {
    $category_id = filter_input(
        INPUT_GET,
        'category_id'
        //FILTER_VALIDATE_INT
    );
    if ($category_id == NULL || $category_id == FALSE) {
        $category_id = "SPORT";
    }
}

// Get name for current category
$queryCategory = "SELECT * FROM categories
WHERE category_id = :category_id";
$statement1 = $db->prepare($queryCategory);
$statement1->bindValue(':category_id', $category_id);
$statement1->execute();
$category = $statement1->fetch();
$statement1->closeCursor();
$category_name = $category['category_name'];

// Get all categories
$queryAllCategories = 'SELECT * FROM categories
ORDER BY category_id';
$statement2 = $db->prepare($queryAllCategories);
$statement2->execute();
$categories = $statement2->fetchAll();
$statement2->closeCursor();

// Get motorbikes for selected category
$queryRecords = "SELECT * FROM motorbikes
WHERE category_id = :category_id
ORDER BY motorbike_id";
$statement3 = $db->prepare($queryRecords);
$statement3->bindValue(':category_id', $category_id);
$statement3->execute();
$motorbikes = $statement3->fetchAll();
$statement3->closeCursor();
?>
<div class="container">
    <?php
    include('includes/header.php');
    ?>
    <h1>Motorbike List</h1>

    <aside>
        <!-- display a list of categories -->
        <h2>Categories</h2>
        <nav>
            <ul>
                <?php foreach ($categories as $category) : ?>
                    <li><a href=".?category_id=<?php echo $category['category_id']; ?>">
                            <?php echo $category['category_name']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </aside>

    <section>
        <!-- display a table of motorbikes -->
        <h2><?php echo $category_name; ?></h2>
        <table>
            <tr>
                <th>Image</th>
                <th>Make</th>
                <th>Model</th>
                <th>Price</th>
                <th>Year</th>
                <th>Engine Size</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>
            <?php foreach ($motorbikes as $motorbike) : ?>
                <tr>
                    <td><img src="image_uploads/<?php echo $motorbike['image']; ?>" width="100px" height="100px" /></td>
                    <td><?php echo $motorbike['make']; ?></td>
                    <td class="right"><?php echo $motorbike['model']; ?></td>
                    <td class="right"><?php echo $motorbike['price']; ?></td>
                    <td class="right"><?php echo $motorbike['year']; ?></td>
                    <td class="right"><?php echo $motorbike['engine_size']; ?></td>
                    <td>
                        <form action="delete_record.php" method="post" id="delete_record_form">
                            <input type="hidden" name="motorbike_id" value="<?php echo $motorbike['motorbike_id']; ?>">
                            <input type="hidden" name="category_id" value="<?php echo $motorbike['category_id']; ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                    <td>
                        <form action="edit_record_form.php" method="post" id="delete_record_form">
                            <input type="hidden" name="motorbike_id" value="<?php echo $motorbike['motorbike_id']; ?>">
                            <input type="hidden" name="category_id" value="<?php echo $motorbike['category_id']; ?>">
                            <input type="submit" value="Edit">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p><a href="add_record_form.php">Add Motorbike</a></p>
        <p><a href="category_list.php">Manage Categories</a></p>
    </section>
    <?php
    include('includes/footer.php');
    ?>