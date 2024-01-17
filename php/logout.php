<?php
session_start();

// Unset all session variables
$_SESSION = array();

// If using cookies for the session, destroy the cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', 1,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session
session_destroy();

// Redirect to the home page or login page
header("Location: user-index.php");
exit;
?>