<?php
require_once 'include/CheckLogin.php';
test_only_include(false);
global $conn, $current_user;

if (!($current_user->super_admin())) {
    header("Location: index.php");
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $type = $_POST['name'];
        $type = trim($conn->real_escape_string($type));
        if (empty($type)) {
            header("Location: Planes.php?create=failed&error=no-type");
        } elseif (strlen($type) > 50) {
            header("Location: Planes.php?create=failed&error=type");
        } else {
            $manufacturer = $_POST['manufacturer'];
            $manufacturer = trim($conn->real_escape_string($manufacturer));
            if (empty($manufacturer) || strlen($manufacturer) <= 50) {
                if (empty($manufacturer)) {
                    $manufacturer = null;
                }
                $query = "INSERT INTO planes (type, manufacturer) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                try {
                    $stmt->bind_param('ss', $type, $manufacturer);
                    $stmt->execute();
                    if ($stmt->affected_rows > 0) {
                        $plane_id = $stmt->insert_id;
                        header("Location: Planes.php?plane_id=$plane_id&create=success");
                    } else {
                        header("Location: Planes.php?create=failed&error=query");
                    }
                } finally {
                    $stmt->close();
                }
            } else {
                header("Location: Planes.php?create=failed&error=manufacturer");
            }
        }
    } catch (Exception $e) {
        header("Location: Planes.php?create=failed&error=exception");
    }
} else {
    header("Location: Planes.php");
}
$conn->close();
?>