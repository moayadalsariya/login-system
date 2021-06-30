<?php
// require the lib
require_once "public/paritals/header.php";
$msgs = [];
// check if user is login 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // if have success message
    if (isset($_SESSION['succuss'])) {
        $msgs[] =  $_SESSION['succuss'];
        unset($_SESSION['succuss']);
    }
} else {
    // check if user is not login
    $_SESSION['error'] = 'Your have to be login in';
    // redirect to login page
    header("Location: login.php");
    exit();
}
?>

<body>
<!-- show success messages -->
    <?php
    if (($msgs)) {
        foreach ($msgs as $msg) { ?>
            <div class="alert alert-success text-center" role="alert">
                <?php echo $msg; ?>
            </div>
    <?php }
    }
    ?>
    <h1 class="text-center">welcome page</h1>
    <?php
    require_once "public/paritals/footer.php";
    ?>