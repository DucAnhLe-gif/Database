<?php
require_once('database.php');
require_once('functions.php');

$errors = [];

function isFormValidated(){
    global $errors;
    return count($errors) == 0;
}

function checkForm(){
    global $errors;
    if (empty($_POST['title'])){
        $errors[] = 'Book Title is required';
    }

    if (empty($_POST['author'])){
        $errors[] = 'Author is required';
    }
    
    if (empty($_POST['page'])){
        $errors[] = '#Pages is required';
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    checkForm();
    if (isFormValidated()){
        //do update
        $book = [];
        $book['id'] = $_POST['id'];
        $book['title'] = $_POST['title'];
        $book['author'] = $_POST['author'];
        $book['page'] = $_POST['page'];

        update_book($book);
        redirect_to('index.php');
    }
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
    <title>Edit Book</title>
    <style>
        label {
            font-weight: bold;
        }
        .error {
            color: #FF0000;
        }
        div.error{
            border: thin solid red; 
            display: inline-block;
            padding: 5px;
        }
    </style>
</head>
<body>
    <?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && !isFormValidated()): ?> 
        <div class="error">
            <span> Please fix the following errors </span>
            <ul>
                <?php
                foreach ($errors as $key => $value){
                    if (!empty($value)){
                        echo '<li>', $value, '</li>';
                    }
                }
                ?>
            </ul>
        </div><br><br>
    <?php endif; ?>
    
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <input type="hidden" name="id" 
        value="<?php echo isFormValidated()? $book['id']: $_POST['id'] ?>" >

        <label for="title">Book Title</label> <!--required-->
        <input type="text" id="title" name="title"  
        value="<?php echo isFormValidated()? $book['title']: $_POST['title'] ?>">
        <br><br>

        <label for="author">Author</label> <!--required-->
        <input type="text" id="author" name="author"  
        value="<?php echo isFormValidated()? $book['author']: $_POST['author'] ?>">
        <br><br>

        <label for="page">#Pages</label> <!--required-->
        <input type="number" id="page" name="page" min="1"  
        value="<?php echo isFormValidated()? $book['page']: $_POST['page'] ?>">
        <br><br>
        
        <input type="submit" name="submit" value="Submit">
        <input type="reset" name="reset" value="Reset">
    
    </form>
    
    <br><br>
    <a href="index.php">Back to index</a> 
</body>
</html>


<?php
db_disconnect($db);
?>