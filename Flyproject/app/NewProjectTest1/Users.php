<?php
$users_active = true;
$html_title = "Users";
include "include/Header.php";
global $current_user;
?>

<!-- Content -->
<?php
if (!($current_user) || !($current_user->admin())) {
    echo "<script type='text/javascript'>document.location.href='index.php';</script>";
    exit();
}
$users = load_users();
$selected_id = $current_user->ID();
if (isset($_GET['pilot_id'])) {
    $selected_id = $_GET['pilot_id'];
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pilot_id'])) {
    $selected_id = $_POST['pilot_id'];
}
$selected_user = null;
foreach ($users as $user):
    if ($user->ID() == $selected_id) {
        $selected_user = $user;
        break;
    }
endforeach;
if (is_null($selected_user)) {
    echo "<script type='text/javascript'>document.location.href='Users.php';</script>";
    exit();
}
?>
        <div id="user-select">
            <form action="Users.php" method="post">
                <select name="pilot_id" id="pilot_id_dropdown" onchange="this.form.submit()">
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user->ID(); ?>"<?php if ($user->ID() == $selected_id) { echo " selected"; }?>> <!-- name="<?php #echo $user->firstname() . " " . $user->lastname(); ?>"-->
                            <?php echo $user->ID() . " " . $user->firstname() . " " . $user->lastname(); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <div id="user-edit">
            <table>
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Age</td>
                    <td>Approval</td>
                    <?php if ($current_user->super_admin()) { echo "<td>Permission</td>"; } ?>
                </tr>
                <tr>
                    <td><?php echo $selected_user->ID(); ?></td>
                    <td><?php echo $selected_user->firstname() . " " . $selected_user->lastname(); ?></td>
                    <td><?php echo $selected_user->age(); ?></td>
                    <td>
                        <?php if ($selected_user->strictly_enabled()): ?>
                            Enabled
                        <?php else: ?>
                        <form action="UserEnable.php" method="post">
                            <button type="submit" name="pilot_id" value="<?php echo $selected_user->ID(); ?>">Enable</button>
                        </form>
                        <?php endif; ?>
                    </td>
                    <?php if ($current_user->super_admin()): ?>
                    <td>
                        <form action="UserChange.php" method="post">
                            <select name="permission">
                                <option value="0"<?php if (!($selected_user->admin())) { echo " selected"; }?>>Regular</option>
                                <option value="1"<?php if ($selected_user->strictly_admin()) { echo " selected"; }?>>Admin</option>
                                <option value="2"<?php if ($selected_user->super_admin()) { echo " selected"; }?>>Super admin</option>
                            </select>
                            <button type="submit" name="pilot_id" value="<?php echo $selected_user->ID(); ?>">Change</button>
                        </form>
                    </td>
                    <?php endif; ?>
                </tr>
            </table>
        </div>
<!-- End content -->

<?php
include "include/Footer.php"
?>