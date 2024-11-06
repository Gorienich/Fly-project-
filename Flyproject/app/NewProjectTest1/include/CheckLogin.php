<?php
session_start();
require_once 'ConnectDB.php';
test_only_include(true);
global $conn;

$current_user = null;
if (isset($_SESSION['pilot_id'])) {
    $pilot_id = $_SESSION['pilot_id'];
    $session = session_id();
    try {
        $query = "SELECT * FROM logins WHERE pilot_id = ? AND session = ? ORDER BY login DESC;";    //  AND login >= NOW() - INTERVAL 1 HOUR
        $stmt = $conn->prepare($query);
        try {
            $stmt->bind_param('ss', $pilot_id, $session);
            $stmt->execute();
            $result = $stmt->get_result();
            $res = $result->fetch_assoc();
            if ($res) {
                if ((int) $res['finished'] == 1) {
                    session_destroy();
                } else {
                    $current_user = load_user($pilot_id);
                }
            }
        } finally {
            $stmt->close();
        }
    } catch (Exception $e) {
        print($e->getMessage());
    }
}
if (is_null($current_user)) {
    $_SESSION = array();
}
?>