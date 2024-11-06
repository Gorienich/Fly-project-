<?php
require_once 'include/CheckLogin.php';
test_only_include(false);
global $conn, $current_user;

if (!($current_user->super_admin())) {
    header("Location: index.php");
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $plane_id = $_POST['plane_id'];
        $plane_id = $conn->real_escape_string($plane_id);
        $query = "INSERT INTO planes (type, manufacturer) SELECT type, manufacturer FROM planes WHERE id = ?;";
        $stmt = $conn->prepare($query);
        try {
            $stmt->bind_param('s', $plane_id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $plane_id = $stmt->insert_id;
                header("Location: Planes.php?plane_id=$plane_id&duplicate=success");
            } else {
                header("Location: Planes.php?plane_id=$plane_id&duplicate=failed&error=query");
            }
        } finally {
            $stmt->close();
        }
    } catch (Exception $e) {
        header("Location: Planes.php?plane_id=$plane_id&duplicate=failed&error=exception");
    }
} else {
    header("Location: Planes.php");
}
?>