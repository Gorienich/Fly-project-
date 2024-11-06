<?php
$planes_active = true;
$html_title = "Planes";
include "include/Header.php";
global $current_user;
?>

<!-- Content -->
<?php
if (!($current_user) || !($current_user->super_admin())) {
    echo "<script type='text/javascript'>document.location.href='index.php';</script>";
    exit();
}
$selected_id = null;
$delete = false;
$selected_plane = null;
$create_plane = false;
if (isset($_GET['plane_id'])) {
    $selected_id = $_GET['plane_id'];
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['plane_id'])) {
    $selected_id = $_POST['plane_id'];
    if (isset($_POST['delete'])) {
        $selected_plane = load_plane($selected_id);
        if (!is_null($selected_plane)) {
            $delete = true;
        }
    }
}
if (!$delete) {
    $planes = load_planes();
    if (!is_null($selected_id)) {
        foreach ($planes as $plane):
            if ($plane->ID() == $selected_id) {
                $selected_plane = $plane;
                break;
            }
        endforeach;
    }
    if (is_null($selected_id) || is_null($selected_plane)) {
        $create_plane = true;
    }
}
?>
    <?php if ($delete): ?>
        <form action="PlaneDelete.php" method="post">
            <h2>Confirmation: delete plane <?php echo $selected_plane->ID() . " " . $selected_plane->type() . (is_null($selected_plane->manufacturer()) ? "" : " - " . $selected_plane->manufacturer()); ?>?</h2>
            <button type="submit" name="confirm">Yes</button>
            <button type="submit">No</button>
            <input type="hidden" name="plane_id" value="<?php echo $selected_plane->ID(); ?>">
            <input type="hidden" name="return_url" value="<?php echo current(explode("?", htmlspecialchars($_SERVER['REQUEST_URI']))); ?>">
        </form>
    <?php else: ?>
        <div id="plane-select">
            <form action="Planes.php" method="post">
                <select name="plane_id" id="plane_id_dropdown" onchange="this.form.submit()">
                    <option value=""<?php if ($create_plane) { echo " selected"; }?>>Create plane</option>
                    <?php foreach ($planes as $plane): ?>
                        <option value="<?php echo $plane->ID(); ?>"<?php if (!is_null($selected_id) && $plane->ID() == $selected_id) { echo " selected"; }?>>
                            <?php echo $plane->ID() . " " . $plane->type() . (is_null($plane->manufacturer()) ? "" : " - " . $plane->manufacturer()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <?php if ($create_plane): ?>
        <div id="plane-create">
            <form action="PlaneCreate.php" method="post">
                <input type="text" name="name" placeholder="Name" class="input-field" minlength="1" maxlength="50">
                <input type="text" name="manufacturer" placeholder="Manufacturer" class="input-field" maxlength="50">
                <button type="submit">Create</button>
            </form>
        </div>
        <?php else: ?>
        <div id="plane-edit">
            <table>
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Manufacturer</td>
                    <td>Options</td>
                </tr>
                <tr>
                    <td><?php echo $selected_plane->ID(); ?></td>
                    <td><?php echo $selected_plane->type(); ?></td>
                    <td><?php echo $selected_plane->manufacturer(); ?></td>
                    <td>
                        <form action="Planes.php" method="post">
                            <button type="submit" name="plane_id" value="<?php echo $selected_plane->ID(); ?>">Delete</button>
                            <input type="hidden" name="delete">
                        </form>
                        <form action="PlaneDuplicate.php" method="post">
                            <button type="submit" name="plane_id" value="<?php echo $selected_plane->ID(); ?>">Duplicate</button>
                            <input type="hidden" name="return_url" value="<?php echo current(explode("?", htmlspecialchars($_SERVER['REQUEST_URI']))); ?>">
                        </form>
                    </td>
                </tr>
            </table>
        </div>
        <?php endif; ?>
    <?php endif; ?>
<!-- End content -->

<?php
include "include/Footer.php"
?>