<?php
require_once "public/paritals/header.php";
require_once "./config/db.php";
$errors = [];
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("Location: welcome.php");
    exit();
}
if (isset($_SESSION['error'])) {
    $errors[] = $_SESSION['error'];
    unset($_SESSION['error']);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlentities($_POST['email'], ENT_QUOTES, "utf-8");
    $password = htmlentities($_POST['password'], ENT_QUOTES, "utf-8");

    if (empty($email)) {
        $errors[] = 'email is require!';
    }

    if (empty($password)) {
        $errors[] = 'password is require!';
    }
    if (empty($errors)) {
        $statment = $pdo->prepare("SELECT * FROM users WHERE email = :email;");
        $statment->bindValue(':email', $email);
        $statment->execute();
        $user = $statment->fetch();
        if (empty($user)) {
            $errors[] = "email does not exist";
        } else {
            if (password_verify($password, $user['password'])) {
                $_SESSION["loggedin"] = true;
                $_SESSION["email"] = $email;
                $_SESSION["fullname"] = $firstname . " " . $lastname;
                $_SESSION['succuss'] = 'user ' . $user['firstname'] . " is succuessful login to the page";
                $_SESSION["image"] = $user['photo'];
                // Redirect user to welcome page
                header("location: welcome.php");
            } else {
                $errors[] = "password incorrect";
            }
        }
    }
}
?>



<body>
    <div class="container">
        <div class="row">
            <div class="container my-5">
                <div class="row">
                    <div class="col-4">

                    </div>
                    <div class="col-4">
                        <?php
                        if (($errors)) {
                            foreach ($errors as $error) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error; ?>
                                </div>
                        <?php }
                        }
                        ?>
                        <form action="login.php" method="POST" id='form-vaild'>
                            <div class="row">
                                <h1 class="text-center mx-x">Login page</h1>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="example@example.com" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="form-group form-inline">
                                            <label for="Password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="Password" name="password" placeholder="Password" required>
                                            <small id="password" class="form-text text-muted">Must be more than 8 characters</small>
                                        </div>
                                    </div>
                                </div>
                                <p>Don't have account? <a href="signup.php"> Sign up here </a></p>
                                <div class="d-grid gap-2 col-12 mx-auto">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-4 border-danger">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    require_once "public/paritals/footer.php";
    ?>