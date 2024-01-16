<?php
session_start();

// Destroy the session
session_destroy();

header("Location: ../html/user-index.html");
exit();
?>