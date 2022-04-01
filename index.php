<?php
require_once('database.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Book</title>
    <style>
        table {
        border-collapse: collapse;
        vertical-align: top;
        }

        table.list {
        width: 100%;
        }

        table.list tr td {
        border: 1px solid #999999;
        }

        table.list tr th {
        border: 1px solid #0055DD;
        background: #0055DD;
        color: white;
        text-align: left;
        }
    </style>
</head>
<body>
    <a href="new.php">Create new book</a> <br><br>
    <table class="list">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>#Pages</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
  	    </tr>

        <?php  
        $book_set = find_all_books();
        $count = mysqli_num_rows($book_set);
        for ($i = 0; $i < $count; $i++):
            $book = mysqli_fetch_assoc($book_set); 
            //alternative: mysqli_fetch_row($book_set) returns indexed array
        ?>
            <tr>
                <td><?php echo $book['title']; ?></td>
                <td><?php echo $book['author']; ?></td>
                <td><?php echo $book['page']; ?></td>
                <td><a href="<?php echo 'edit.php?id='.$book['id']; ?>">Edit</a></td>
                <td><a href="<?php echo 'delete.php?id='.$book['id']; ?>">Delete</a></td>
            </tr>
        <?php 
        endfor; 
        mysqli_free_result($book_set);
        ?>
    </table>
</body>
</html>

<?php
db_disconnect($db);
?>