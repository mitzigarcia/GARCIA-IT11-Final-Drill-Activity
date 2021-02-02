<?php
require_once 'config/db.php';
$email = '';
$password = '';
$email_err = '';
$password_err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email)) {

    }
    if (empty($password)) {
        
    }

    if (empty($email_err) && empty($password_err)) {
        $sql = 'SELECT name, email, password FROM users WHERE email = :email';
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $hashed_password = $row['password'];
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION['email'] = $email;
                            $_SESSION['name'] = $row['name'];
                            header('location: index.php');
                        } else {
                            $password_err = 'Invalid password';
                        }
                    }
                } else {
                    $email_err = 'Account does not exist.';
                }
            } else {
                die('Something went wrong.');
            }
        }
        unset($stmt); 
    }
    unset($pdo);
}
?>
<html>
<head>
    <title>
        Login
    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="card m-5">
            <div class="card-header">
                <h2>Login</h2>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label>Email:<sup>*</sup></label>
                        <input name="email" type="text" class="form-control form-control-lg <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?> value="<?php echo $email; ?>">
                        <span class="invalid-feedback"><?php echo $email_err ?></span>
                    </div>
                    <div class="form-group">
                        <label>Password:<sup>*</sup></label>
                        <input name="password" type="password" class="form-control form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?> value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err ?></span>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <input type="submit" class="btn btn-success btn-block" value="Login">
                        </div>
                        <div class="col">
                            <a href="register.php" class="btn btn-light btn-block">No account? Register here.</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
