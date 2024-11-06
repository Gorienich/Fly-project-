<?php
session_start();
//
function check_login() {
    if (!isset($_SESSION['Admin_ID'])) { //Change admin ID from DataBase
        header("Location: ../UserDashBord.php");
        exit();
    }
}

function logout() {
    session_destroy();
    header("Location: ../UserConnect.php");
    exit();
}

?>
