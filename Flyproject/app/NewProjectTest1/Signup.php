<?php
require_once 'include/CheckLogin.php';
test_only_include(false);
global $conn;

function check_english($str) {
      return check_pattern($str, "^[a-zA-Z]+$");
}

function check_email($email) {
      return check_pattern($email, "^\w+([\._-]?\w+)*@\w+([\._-]?\w+)*(\.\w{2,3})+$") && check_pattern($email, "^[a-zA-Z\@0-9\.-_]+$");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $return_url = "index.php";
      try {
            if (isset($_POST['return_url'])) {
                  $return_url = $_POST['return_url'];
            }
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_re = $_POST['password_re'];
            $age = $_POST['age'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];

            $password = $conn->real_escape_string($password);
            $password_re = $conn->real_escape_string($password_re);
            if (strcmp($password, $password_re) !== 0) {
                  header("Location: $return_url?error=passwords");
                  exit();
            }
            if (strlen($password) < 6 || strlen($password) > 20) {
                  header("Location: $return_url?error=password");
                  exit();
            }
            $email = $conn->real_escape_string($email);
            if (!(check_email($email))) {
                  header("Location: $return_url?error=email1");
                  exit();
            }
            $firstname = $conn->real_escape_string($firstname);
            if (!(check_english($firstname))) {
                  header("Location: $return_url?error=firstname");
                  exit();
            }
            $lastname = $conn->real_escape_string($lastname);
            if (!(check_english($lastname))) {
                  header("Location: $return_url?error=lastname");
                  exit();
            }
            $age = $conn->real_escape_string($age);
            if (!check_range($age, 18, 70)) {
                  header("Location: $return_url?error=age");
                  exit();
            }

            try {
                $query = "SELECT * FROM pilots WHERE email = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('s', $email);
                $stmt->execute();
                if ($stmt->num_rows > 0) {
                    header("Location: $return_url?error=email_taken");
                } else {
                    $stmt->close();
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $query = "INSERT INTO pilots (email, password, first_name, last_name, age) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('ssssi', $email, $hashed_password, $firstname, $lastname, $age);
                    $stmt->execute();
                    if ($stmt->affected_rows > 0) {
                        header("Location: $return_url?register=success");
                    } else {
                        header("Location: $return_url?register=failed&error=query");
                    }
                }
            } finally {
                $stmt->close();
            }
      } catch (Exception $e) {
            header("Location: $return_url?register=failed&error=exception");
      }
} else {
      header("Location: index.php");
}
$conn->close();
?>