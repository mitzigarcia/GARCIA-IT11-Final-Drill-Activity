<?php

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'garcia';

$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($db, $_POST['id']);
    $author = mysqli_real_escape_string($db, $_POST['author']);
    $quote = mysqli_real_escape_string($db, $_POST['quote']);

    if (!empty($id) && !empty($author) && !empty($quote)) {
        $result = mysqli_query($db, "UPDATE fam_quotes SET author='$author', quote='$quote' WHERE id='$id'");
        header('location: index.php');
    } else {
        header('location: index.php');
    }
}

$id = $_GET['id'];

$result = mysqli_query($db, "SELECT * FROM fam_quotes WHERE id=$id");
while ($res = mysqli_fetch_array($result)) {
    $author = $res['author'];
    $quote = $res['quote'];
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
                <form action="edit.php" method="POST">
                    <input name="id" type="hidden" class="form-control form-control-lg" value="<?php echo $id; ?>" >
                    <div class="form-group">
                        <label>Author:</label>
                        <input name="author" type="text" class="form-control form-control-lg" value="<?php echo $author; ?>">
                    </div>
                    <div class="form-group">
                        <label>Famous Quote:</label>
                        <input name="quote" type="text" class="form-control form-control-lg" value="<?php echo $quote; ?>" >
                    </div>
                    <div class="form-group">
                        <button name="update" type="submit" class="btn btn-success btn-block">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>