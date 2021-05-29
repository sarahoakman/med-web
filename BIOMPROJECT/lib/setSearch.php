<?php
    // store search term 
    session_start(); 
    $_SESSION["search"] = $_POST["search"];
    if ($_SESSION["type"] == "researcher") {
        header("Location: researcher.php");
    } else {
        header("Location: admin.php");
    }
    exit();
?>