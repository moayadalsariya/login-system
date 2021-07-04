<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/style.css">
    <header class="p-3 mb-3 border-bottom bg-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="http://localhost/login-system/users/login" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                    <span class="fs-5">Login System</span>
                </a>
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="http://localhost/login-system/users/login" class="nav-link px-2 link-secondary">Home page</a></li>
                </ul>
                <!-- if user is login -->
                <?php
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                    <div class="text-end">
                        <a href="login.php" class="text-dark me-2"><?php echo $_SESSION["fullname"]; ?></a>
                    </div>
                    <div class="dropdown text-end">
                        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src=<?php echo substr($_SESSION['image'],3); ?> alt="mdo" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="http://localhost/login-system/users/logout">logout</a></li>
                        </ul>
                    </div>
                    <!-- if user not login, show login and signup buttons -->
                <?php } else {  ?>
                    <div class="text-end">
                        <a href="http://localhost/login-system/users/login" class="btn btn-light text-dark me-2"> Login</a>
                        <a href="http://localhost/login-system/users/signup" class="btn btn-primary">Sign-up</a>
                    </div>
                <?php  } ?>
            </div>
        </div>
    </header>