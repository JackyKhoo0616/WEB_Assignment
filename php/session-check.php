<?php
session_start();

function checkSession() {
    // Check if the user is logged in
    if (!isset($_SESSION['role'])) {
        header("Location: user-login.php"); // Redirect to the login page if not logged in
        exit();
    }

    // Check the user role
    $role = $_SESSION['role'];

    return $role;
}

function checkPageAccess($allowedRoles) {
    $role = checkSession();

    // Check if the user has the correct role for the page
    if (!in_array($role, $allowedRoles)) {
        echo "Error: You Have No Access To This Page.";
        exit();
    }
}
?>

