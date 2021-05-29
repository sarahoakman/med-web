<?php

session_start();

$conn = odbc_connect('z5206178', '', '',SQL_CUR_USE_ODBC);
			
if (!$conn) {
	exit("Connection Failed: " . $conn); 
}

// sets the error for non empty inputs
if (!empty($_POST["username"]) && !empty($_POST["password"])) {
    // gets the row for the username and password given and if found log them in
    $username = $_POST["username"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM User WHERE username= '".$username."' AND password='".$password."'";
    $rs = odbc_exec($conn,$sql);
    // only enters loop if sql has a result
    while(odbc_fetch_row($rs)) {
        // check with case sensitivity 
        $username_sql = odbc_result($rs,"Username");
		$password_sql = odbc_result($rs,"Password");
        if ($username_sql == $username && $password_sql == $password) {
            $admin = odbc_result($rs, "Admin");
            unset( $_SESSION["error"] );
            $_SESSION["username"] = $username;
            if ($admin == 1) {
            $_SESSION["type"] = "admin";
            header("Location: admin.php");
            } else {
            $_SESSION["type"] = "researcher";
            header("Location: researcher.php");
            }
            exit();
        }
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