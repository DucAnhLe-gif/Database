<?php
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "1808g");

function db_connect() {
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    return $connection;
}

/******
 * Open connection to database
 */
$db = db_connect();


function db_disconnect($connection) { //call at the end of each page
    if(isset($connection)) {
      mysqli_close($connection);
    }
}

function confirm_query_result($result){
    global $db;
    if (!$result){
        echo mysqli_error($db);
        db_disconnect($db);
        exit; //terminate php
    } else {
        return $result;
    }
}

function insert_book($book) {
    global $db;

    $sql = "INSERT INTO book ";
    $sql .= "(title, author, page) ";
    $sql .= "VALUES (";
    $sql .= "'" . $book['title'] . "',"; //be careful of single quotes
    $sql .= "'" . $book['author'] . "',";//be careful of single quotes
    $sql .= "'" . $book['page'] . "'";//be careful of single quotes
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // // For INSERT statements, $result is true/false
    // if($result) {
    //   return true;
    // } else {
    //   // INSERT failed
    //   echo mysqli_error($db);
    //   db_disconnect($db);
    //   exit; //terminate php
    // }
    return confirm_query_result($result);
}

function find_all_books(){
    global $db;

    $sql = "SELECT * FROM book ";
    $sql .= "ORDER BY title";
    //echo $sql;
    $result = mysqli_query($db, $sql); 
    // For SELECT statements, $result is a set of data
    // return $result;
    return confirm_query_result($result);
}

function find_book_by_id($id) {
    global $db;

    $sql = "SELECT * FROM book ";
    $sql .= "WHERE id='" . $id . "'";
    $result = mysqli_query($db, $sql);
    confirm_query_result($result);
    $book = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $book; // returns an assoc. array
}

function update_book($book) {
    global $db;

    $sql = "UPDATE book SET ";
    $sql .= "title='" . $book['title'] . "', ";
    $sql .= "author='" . $book['author'] . "', ";
    $sql .= "page='" . $book['page'] . "' ";
    $sql .= "WHERE id='" . $book['id'] . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // // For UPDATE statements, $result is true/false
    // if($result) {
    //   return true;
    // } else {
    //   // UPDATE failed
    //   echo mysqli_error($db);
    //   db_disconnect($db);
    //   exit;
    // }
    return confirm_query_result($result);
}

function delete_book($id) {
    global $db;

    $sql = "DELETE FROM book ";
    $sql .= "WHERE id='" . $id . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // // For DELETE statements, $result is true/false
    // if($result) {
    //   return true;
    // } else {
    //   // DELETE failed
    //   echo mysqli_error($db);
    //   db_disconnect($db);
    //   exit;
    // }
    return confirm_query_result($result);
}


?>