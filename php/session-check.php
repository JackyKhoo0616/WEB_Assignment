<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function checkSession() {
    if (!isset($_SESSION['role'])) {
        header("Location: user-login.php");
        exit();
    }
    $role = $_SESSION['role'];

    return $role;
}

function checkPageAccess($allowedRoles) {
    $role = checkSession();
    if (!in_array($role, $allowedRoles)) {
        echo "Error: You Have No Access To This Page.";
        exit();
    }
}
?>
