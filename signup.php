<?php
// require all libs
require_once "public/paritals/header.php";
require_once "./config/db.php";
require_once "utils/functions.php";
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = htmlentities($_POST['firstname'], ENT_QUOTES, "utf-8");
    $lastname = htmlentities($_POST['lastname'], ENT_QUOTES, "utf-8");
    $email = htmlentities($_POST['email'], ENT_QUOTES, "utf-8");
    $password = htmlentities($_POST['password'], ENT_QUOTES, "utf-8");
    $confirm_password = htmlentities($_POST['confirm_password'], ENT_QUOTES, "utf-8");
    $gendor = htmlentities($_POST['gendor'], ENT_QUOTES, "utf-8");
    $pattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/';
    $image = 'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png';

    if (empty($firstname)) {
        $errors[] = 'firstname is require!';
    }
    if (!empty($firstname) && strlen($firstname) < 3) {
        $errors[] = 'firstname should be more than 3 character !';
    }

    if (empty($lastname)) {
        $errors[] = 'lastname is require!';
    }
    if (!empty($lastname) && strlen($lastname) < 3) {
        $errors[] = 'last$lastname should be more than 3 character !';
    }
    if (empty($email)) {
        $errors[] = 'email is require!';
    } else {
        // check if email is already exist in DB
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email;");
        $statement->bindValue(':email', $email);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            $errors[] = 'email is already exist!';

        }
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($password)) {
        $errors[] = 'password is require!';
    }
    if (!preg_match($pattern, $password)) {
        $errors[] = "password must be min 8 characters, at least 1 number, at least one uppercase, at least one lowercase";
    }
    if ($password != $confirm_password) {
        $errors[] = "confirm password must be same as password";
    }

    if (empty($gendor)) {
        $errors[] = 'gendor is require!';
    }
    // check if input filed is selected
    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) { 
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $image = "public/upload/" . random() . $file_name;
        $image = str_replace(' ', '_', $image);
        $extensions = array("jpg", "png");
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if (in_array($ext, $extensions) === false) {
            $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
        }
        if ($file_size > 2097152) {
            $errors[] = 'File size must less than 2 MB';
        } else {
            move_uploaded_file($file_tmp, $image);
        }
    }
    if (empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $statment = $pdo->prepare("INSERT INTO users (email,firstname,lastname,gendor,photo,password)
        VALUES (:email,:firstname,:lastname,:gendor,:photo,:password);");
        $statment->bindValue(':email', $email);
        $statment->bindValue(':firstname', $firstname);
        $statment->bindValue(':lastname', $lastname);
        $statment->bindValue(':gendor', $gendor);
        $statment->bindValue(':photo', $image);
        $statment->bindValue(':password', $password);
        $statment->execute();
        $_SESSION['succuss'] = 'user ' . $firstname . " is succuessful singup to the page";
        $_SESSION["loggedin"] = true;
        $_SESSION["fullname"] = $firstname . " " . $lastname;
        $_SESSION["email"] = $email;
        $_SESSION["image"] = $image;
        header("Location: welcome.php");
        // exit();
    }
}
?>


<body>
    <div class="container">
        <div class="row">
            <div class="container my-5">
                <div class="row">
                    <div class="col-3">

                    </div>
                    <div class="col-6">
                        <?php
                        if (($errors)) {
                            foreach ($errors as $error) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error; ?>
                                </div>
                        <?php }
                        }
                        ?>
                        <form action="signup.php" method="POST" id='form-vaild' enctype="multipart/form-data">
                            <div class="row">
                                <h1 class="text-center mx-x">Registeration Form</h1>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <div class="form-group form-inline">
                                            <label for="firstname" class="form-label">Firstname</label>
                                            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="firstname" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Lastname</label>
                                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Lastname" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="example@example.com" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <div class="form-group form-inline">
                                            <label for="Password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="Password" name="password" placeholder="Password" required>
                                            <small id="password" class="form-text text-muted">Must be more than 8 characters</small>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="confirm password" class="form-label">confirm password</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="confirm password" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <fieldset class="row mb-3">
                                        <legend class="col-form-label col-sm-2 pt-0">Gendor</legend>
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gendor" id="male" value="Male" checked>
                                                <label class="form-check-label" for="male">
                                                    Male
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gendor" id="female" value="Female">
                                                <label class="form-check-label" for="female">
                                                    Female
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Choose image for profile image</label>
                                        <input class="form-control" name="image" accept=".jpg,.png" type="file" id="formFile">
                                    </div>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name='terms' id="terms">
                                    <label class="form-check-label" for="exampleCheck1">I accept the <a href="">Terms and Conditions</a></label>
                                </div>
                                <p>Already have an account? <a href="login.php">Login here.</a></p>
                                <div class="d-grid gap-2 col-12 mx-auto">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-3 border-danger">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    require_once "public/paritals/footer.php";
    ?>