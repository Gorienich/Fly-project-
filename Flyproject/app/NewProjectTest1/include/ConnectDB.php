<?php
require_once 'Base.php';
test_only_include(true);

$servername = "localhost"; // Replace with your MySQL server name
$username = "root";   // Replace with your MySQL username
$password = "";       // Replace with your MySQL password
$dbname = "flyproject";   // Replace with your MySQL database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function load_user($id) {
    global $conn;
    $user = null;
    try {
        $query = "SELECT * FROM pilots WHERE id = ?";
        $stmt = $conn->prepare($query);
        try {
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $res = $result->fetch_assoc();
            if ($res) {
                $user = create_user($res);
            }
        } finally {
            $stmt->close();
        }
    } catch (Exception $e) {}
    return $user;
}

function load_users() {
    global $conn;
    $users = array();
    try {
        $query = "SELECT * FROM pilots";
        $result = $conn->query($query);
        while ($res = $result->fetch_assoc()) {
            try {
                $users[] = create_user($res);
            } catch (Exception $e) {}
        }
    } catch (Exception $e) {}
    return $users;
}

function load_plane($id) {
    global $conn;
    $plane = null;
    try {
        $query = "SELECT * FROM planes WHERE id = ?";
        $stmt = $conn->prepare($query);
        try {
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $res = $result->fetch_assoc();
            if ($res) {
                $plane = create_plane($res);
            }
        } finally {
            $stmt->close();
        }
    } catch (Exception $e) {}
    return $plane;
}

function load_planes() {
    global $conn;
    $planes = array();
    try {
        $query = "SELECT * FROM planes";
        $result = $conn->query($query);
        while ($res = $result->fetch_assoc()) {
            try {
                $planes[] = create_plane($res);
            } catch (Exception $e) {}
        }
    } catch (Exception $e) {}
    return $planes;
}
?>