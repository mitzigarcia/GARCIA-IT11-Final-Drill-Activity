<?php

session_start();

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('location: login.php');
    exit;
}

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'garcia';

$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

$result = mysqli_query($db, "SELECT * FROM fam_quotes");

if (isset($_POST['save'])) {
    $author = mysqli_real_escape_string($db, $_POST['author']);
    $quote = mysqli_real_escape_string($db, $_POST['quote']);

    if (!empty($author) && !empty($quote)) {
        $result = mysqli_query($db, "INSERT INTO fam_quotes (author, quote) VALUES ('$author', '$quote')");
        header('location: index.php');
    }
}

?>
<html>
<head>
    <title>
        Famous Quotes | Mitzi Almira Garcia
    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="card m-5">
            <div class="card-header">
                <h2>Famous Quotes</h2>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <th>ID</th>
                        <th>AUTHOR</th>
                        <th>QUOTE</th>
                        <th colspan="2">ACTIONS</th>
                    </thead>
                    <tbody>
                        <?php
                        while ($res = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>".$res['id']."</td>";
                            echo "<td>".$res['author']."</td>";
                            echo "<td>".$res['quote']."</td>";
                            echo "<td><a href=\"edit.php?id=$res[id]\">Edit</a> | <a href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete this record?')\">Delete</a></td>";
                            echo "</tr>";
                        }                        
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card card-footer">
                <form action="index.php" method="POST">
                    <div class="form-group">
                        <label>Author:</label>
                        <input name="author" type="text" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <label>Famous Quote:</label>
                        <input name="quote" type="text" class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <button name="save" type="submit" class="btn btn-success btn-block">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>