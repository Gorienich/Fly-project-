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
        if (isset($_POST['confirm'])) {
            $conn->begin_transaction();
            try {
                $query = "UPDATE flights SET id = ? WHERE id = ?;";
                $stmt = $conn->prepare($query);
                try {
                    $new_plane_id = null;
                    $stmt->bind_param('ss', $new_plane_id, $plane_id);
                    $stmt->execute();
                } finally {
                    $stmt->close();
                }
                $query = "DELETE FROM planes WHERE id = ?;";
                $stmt = $conn->prepare($query);
                try {
                    $stmt->bind_param('s', $plane_id);
                    $stmt->execute();
                    if ($stmt->affected_rows > 0) {
                        $conn->commit();
                        header("Location: Planes.php?delete=success");
                    } else {
                        $conn->rollback();
                        header("Location: Planes.php?plane_id=$plane_id&delete=failed&error=query");
                    }
                } finally {
                    $stmt->close();
                }
            } catch (Exception $e) {
                $conn->rollback();
                header("Location: Planes.php?plane_id=$plane_id&delete=failed&error=exception&msg=" . $e->getMessage());
            }
        } else {
            header("Location: Planes.php?plane_id=$plane_id");
        }
    } catch (Exception $e) {
        header("Location: Planes.php?plane_id=$plane_id&delete=failed&error=exception");
    }
} else {
    header("Location: Planes.php");
}
?>