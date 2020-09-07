<?php
    session_start();
    // session_destroy();
    error_log("Logout success ".$_SESSION['name']);
    unset($_SESSION['name']);
    unset($_SESSION['user_id']);

    header("Location: index.php");
?>
