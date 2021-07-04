<?php require_once "../app/views/paritals/header.php"; ?>
<?php
    $errors = [];
    if(isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];
        unset($_SESSION['errors']);
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

                        <!-- check if the is errors -->
                        <?php
                        if (($errors)) {
                            foreach ($errors as $error) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error; ?>
                                </div>
                        <?php }
                        }
                        ?>
                        <form action="http://localhost/login-system/users/signup" method="POST" id='form-vaild' enctype="multipart/form-data">
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
                                <p>Already have an account? <a href="http://localhost/login-system/users/login">Login here.</a></p>
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
    <?php require_once "../app/views/paritals/footer.php"; ?>