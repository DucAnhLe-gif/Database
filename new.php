<?php
require_once('database.php');
$errors = [];

function isFormValidated(){
    global $errors;
    return count($errors) == 0;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
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

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Create New Book</title>
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
        <label for="title">Book Title</label> <!--required-->
        <input type="text" id="title" name="title"  
        value="<?php echo isFormValidated()? '': $_POST['title'] ?>">
        <br><br>

        <label for="author">Author</label> <!--required-->
        <input type="text" id="author" name="author"  
        value="<?php echo isFormValidated()? '': $_POST['author'] ?>">
        <br><br>

        <label for="page">#Pages</label> <!--required-->
        <input type="number" id="page" name="page" min="1"  
        value="<?php echo isFormValidated()? '': $_POST['page'] ?>">
        <br><br>
        
        <input type="submit" name="submit" value="Submit">
        <input type="reset" name="reset" value="Reset">
    
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && isFormValidated()): ?> 
        <?php 
        $book = [];
        $book['title'] = $_POST['title'];
        $book['author'] = $_POST['author'];
        $book['page'] = $_POST['page'];
        $result = insert_book($book);
        $newBookId = mysqli_insert_id($db);
        ?>
        <h2>A new book (ID: <?php echo $newBookId ?>) has been created:</h2>
        <ul>
        <?php 
            foreach ($_POST as $key => $value) {
                if ($key == 'submit') continue;
                if(!empty($value)) echo '<li>', $key.': '.$value, '</li>';
            }        
        ?>
        </ul>
    <?php endif; ?>
    
    <br><br>
    <a href="index.php">Back to index</a> 
</body>
</html>


<?php
db_disconnect($db);
?>