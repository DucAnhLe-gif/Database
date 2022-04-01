<?php
require_once('database.php');
require_once('functions.php');

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    //db delete
    delete_book($_POST['id']);
    redirect_to('index.php');
} else { // form loaded
    if(!isset($_GET['id'])) {
        redirect_to('index.php');
    }
    $id = $_GET['id'];
    $book = find_book_by_id($id);
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Delete Book</title>
    <style>
        .label {
            font-weight: bold;
            font-size: large;
        }
    </style>
</head>
<body>
    <h1>Delete Book</h1>
    <h2>Are you sure you want to delete this book?</h2>
    <p><span class="label">Book Title: </span><?php echo $book['title']; ?></p>
    <p><span class="label">Author: </span><?php echo $book['author']; ?></p>
    <p><span class="label">#Pages: </span><?php echo $book['page']; ?></p>
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <input type="hidden" name="id" value="<?php echo $book['id']; ?>" >
     
        <input type="submit" name="submit" value="Delete Book">
     
    </form>
    
    <br><br>
    <a href="index.php">Back to index</a> 
</body>
</html>


<?php
db_disconnect($db);
?>