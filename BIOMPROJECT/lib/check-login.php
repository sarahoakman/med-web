<?php

session_start();

$conn = new PDO('sqlite:./db/project.sqlite');
                                
    if (!$conn) {
        exit("Connection Failed: " . $conn); 
    }

// sets the error for non empty inputs
if (!empty($_POST["username"]) && !empty($_POST["password"])) {
    // gets the row for the username and password given and if found log them in
    $username = $_POST["username"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM User WHERE username= '".$username."' AND password='".$password."'";
    $rs = $conn->query($sql);
    $check = $rs->fetch();
    // check with case sensitivity 
    $username_sql = $check["Username"];
	$password_sql = $check["Password"];
    if ($username_sql == $username && $password_sql == $password) {
        $admin = $check["Admin"];
        unset( $_SESSION["error"] );
        $_SESSION["username"] = $username;
        if ($admin == 'True') {
        $_SESSION["type"] = "admin";
        header("Location: admin.php");
        } else {
        $_SESSION["type"] = "researcher";
        header("Location: researcher.php");
        }
        exit();
    }
    // sets the error for incorrect inputs 
    $_SESSION["error"] = "Incorrect username and/or password";
    header("Location: login.php");
    exit();
} else {
    // sets the error for no inputs
      $_SESSION["error"] = "Enter a valid username and/or password";
      header("Location: login.php");
      exit();
}

?>
