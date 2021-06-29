<?php
require_once "public/paritals/header.php";
$msgs = [];
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    if (isset($_SESSION['succuss'])) {
        $msgs[] =  $_SESSION['succuss'];
        unset($_SESSION['succuss']);
    }
} else {
    $_SESSION['error'] = 'your have to be login in ';
    header("Location: login.php");
    exit();
}
?>

<body>
    <?php
    if (($msgs)) {
        foreach ($msgs as $msg) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $msg; ?>
            </div>
    <?php }
    }
    ?>
    <h1>welcome page</h1>
    <?php
    require_once "public/paritals/footer.php";
    ?>