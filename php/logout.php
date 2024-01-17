<?php
session_start();

// Destroy the session
session_destroy();

header("Location: ../php/user-index.php");
exit();
?>