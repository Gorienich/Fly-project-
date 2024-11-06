<?php
$home_active = true;
$html_title = "User connect";
include "include/Header.php";
global $current_user;
?>

<!-- Content -->
<div>
<h1>Welcome <?php echo (is_null($current_user) ? "" : $current_user->firstName() . ' ' . $current_user->lastName()); ?>!</h1>
<br /><br /><br /><br /><br /><br /><br /><br />
<?php
if (is_null($current_user)) {
    echo "<h2>Please sign in or sign up to continue</h2>";
} elseif (!$current_user->enabled()) {
    echo "<h2>You're not authorized yet, please wait for an admin's approval</h2>";
} elseif ($current_user->admin()) {
    echo "<h2>Hooray! You're " . ($current_user->super_admin() ? "a super" : "an") . " admin!</h2>";
}
?>
</div>
<!-- End content -->

<?php
include "include/Footer.php"
?>