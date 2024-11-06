<?php
require_once 'include/CheckLogin.php';
test_only_include(false);
global $conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $return_url = "index.php";
    try {
        if (isset($_POST['return_url'])) {
              $return_url = $_POST['return_url'];
        }
        $email = $_POST['email'];
        $email = $conn->real_escape_string($email);
        $password = $_POST['password'];
        $password = $conn->real_escape_string($password);
        $query = "SELECT * FROM pilots WHERE email = ?";
        $stmt = $conn->prepare($query);
        try {
              $stmt->bind_param('s', $email);
              $stmt->execute();
              $result = $stmt->get_result();
              $res = $result->fetch_assoc();
              $success = False;
              if ($res) {
                    $pilot_id = $res['id'];
                    if (password_verify($password, $res['password'])) {
                          $_SESSION['pilot_id'] = $pilot_id;
                          $query = "INSERT INTO logins (pilot_id, finished, session) VALUES (?, ?, ?)";
                          $stmt = $conn->prepare($query);
                          try {
                              $a = 0;
                              $session_id = session_id();
                              $stmt->bind_param('sss', $pilot_id, $a, $session_id);
                              if ($stmt->execute()) {
                                  $success = True;
                                  header("Location: $return_url?login=success");
                              }
                          } finally {
                              $stmt->close();
                          }
                    }
              }
              if ($success) {
                    header("Location: $return_url?login=success");
              } else {
                    header("Location: $return_url?login=failed&error=query");
              }
        } finally {
            $stmt->close();
        }
    } catch (Exception $e) {
        header("Location: $return_url?login=failed&error=exception");
    }
} else {
    header("Location: index.php");
}
?>