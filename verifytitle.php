<?php
include 'db_connect.php';


if(isset($_POST['title'])) { //change isSet to isset (it will not make any difference)
    $title = mysqli_real_escape_string($con,$_POST['title']); //escape the string

    $sql_check = mysqli_query($con,"SELECT title FROM campaigns WHERE lower(title)=lower('$title')") or die(mysqli_error($con));
        if(mysqli_num_rows($sql_check) > 0) { //check rows greater then zero (although it will also not make any difference)
            echo 'error';
        } else {
            echo 'ok';
        }
}
?>