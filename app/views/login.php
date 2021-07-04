<?php require_once "../app/views/paritals/header.php"; ?>
<?php
$errors = [];
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
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
                        <!-- if there is any error -->
                        <?php
                        if (($errors)) {
                            foreach ($errors as $error) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error; ?>
                                </div>
                        <?php }
                        }
                        ?>
                        <form action="http://localhost/login-system/users/login" method="POST" id='form-vaild'>
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
                                <p>Don't have account? <a href="http://localhost/login-system/users/signup"> Sign up here </a></p>
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

    <?php require_once "../app/views/paritals/footer.php"; ?>