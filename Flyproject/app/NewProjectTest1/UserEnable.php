<?php
require_once 'include/CheckLogin.php';
require_once 'Users.php';
test_only_include(false);
global $conn;
global $current_user;



if (!($current_user->admin())) {
    header("Location: index.php");
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pilot_id = $_POST['pilot_id'];
        $pilot_id = $conn->real_escape_string($pilot_id);
        $query = "UPDATE pilots SET enabled = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        try {
            $enabled = 1;
            $stmt->bind_param('is', $enabled, $pilot_id);
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