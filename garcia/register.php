<?php
require_once 'config/db.php';

$name = '';
$email = '';
$password = '';
$confirm_password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($name)) {
        $name_err = 'Please enter your name.';
    }

    if (empty($email)) {
        $email_err = 'Please enter an email address.';
    } else {
        $sql = 'SELECT id FROM users WHERE email = :email';
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            if ($stmt->execute()) {
                if ($stmt->rowCount() === 1) {
                    $email_err = 'Email already exists.';
                }
            } else {
                die('Something went wrong.');
            }
        }
        unset($stmt);
    }

    if (empty($password)) {
        $password_err = 'Please enter a password.';
    } elseif (strlen($password < 6)) {
        $password_err = 'Password must be at least 6 characters.';
    }

    if (empty($confirm_password)) {
        $confirm_password_err = 'Please confirm your password.';
    } else {
        if ($password !== $confirm_password) {
            $confirm_password_err = 'Password does not match.';
        }
    }
    
    if (empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);

            if ($stmt->execute()) {
                header('location: login.php');
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
        Register
    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="card m-5">
            <div class="card-header">
                <h2>Register</h2>
            </div>
            <div class="card-body">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group">
                        <label>Name:<sup>*</sup></label>
                        <input name="name" type="text" class="form-control form-control-lg <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?> value="<?php echo $name; ?>">
                        <span class="invalid-feedback"><?php echo $name_err ?></span>
                    </div>
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
                    <div class="form-group">
                        <label>Confirm Password:<sup>*</sup></label>
                        <input name="confirm_password" type="password" class="form-control form-control-lg <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?> value="<?php echo $confirm_password; ?>">
                        <span class="invalid-feedback"><?php echo $confirm_password_err ?></span>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <input type="submit" class="btn btn-success btn-block" value="Register">
                        </div>
                        <div class="col">
                            <a href="login.php" class="btn btn-light btn-block">Have an account? Login here.</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
