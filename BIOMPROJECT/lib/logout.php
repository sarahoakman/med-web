<?php
    // unsets variables and redirect to login
    session_start(); 
    unset($_SESSION["username"]);
    unset($_SESSION["subject-id"]);
    unset($_SESSION["subject-edit"]);
    header("Location: login.php");
?>