<?php

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'garcia';

$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    $id = $_GET['id'];

    $result = mysqli_query($db, "DELETE FROM fam_quotes WHERE id=$id");

    header('location: index.php')

?>