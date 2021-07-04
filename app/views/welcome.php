<?php require_once "../app/views/paritals/header.php"; ?>
<?php
$msgs = [];
// check if user is login 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // if have success message
    if (isset($_SESSION['succuss'])) {
        $msgs[] =  $_SESSION['succuss'];
        unset($_SESSION['succuss']);
    }
}
?>
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
<h1>welcome</h1>
<?php require_once "../app/views/paritals/footer.php"; ?>