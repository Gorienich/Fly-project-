<?php
require_once 'include/CheckLogin.php';
test_only_include(false);
global $conn, $current_user;

if (!($current_user->super_admin())) {
    header("Location: index.php");
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pilot_id = $_POST['pilot_id'];
        $pilot_id = $conn->real_escape_string($pilot_id);
        $permission = $_POST['permission'];
        $query = "UPDATE pilots SET admin = ?, super_admin = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        try {
            $admin = $permission == 1 ? 1 : 0;
            $super_admin = $permission == 2 ? 1 : 0;
            $stmt->bind_param('iis', $admin, $super_admin, $pilot_id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                header("Location: Users.php?pilot_id=$pilot_id&change=success");
            } else {
                header("Location: Users.php?pilot_id=$pilot_id&change=failed&error=query");
            }
        } finally {
            $stmt->close();
        }
    } catch (Exception $e) {
        header("Location: Users.php?pilot_id=$pilot_id&change=failed&error=exception");
    }
} else {
    header("Location: Users.php");
}
?>
