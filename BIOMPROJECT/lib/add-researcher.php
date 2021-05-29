<?php

    session_start();

    $conn = odbc_connect('z5206178', '', '',SQL_CUR_USE_ODBC);
                
    if (!$conn) {
        exit("Connection Failed: " . $conn); 
    }

    // gets info to add to database
    $username = $_POST["username"];
    $password = $_POST["password"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $dob = "#".$_POST["dob"]."#";
    $gender = $_POST["gender"];
    $contact =  $_POST["contact"];
    if (strlen($contact) == 8) {
        $contact = '  '.$contact;
    }

    // checks if it already exists, triggers alert
    $sql = "SELECT * FROM User WHERE User.Username='".$username."'";
    $rs = odbc_exec($conn,$sql);
    while(odbc_fetch_row($rs)) {
        $_SESSION["add-error"] = 1;
        header("Location: admin-researchers.php");
        exit();
    }

    // insert valid data into database
    $sql = "INSERT INTO User (Username,[Password],FirstName,LastName,DOB,Gender,Contact,[Admin]) VALUES ('$username','$password','$firstname','$lastname',$dob,'$gender','$contact', False)";
    $rs = odbc_exec($conn,$sql);

    // use this to check what alert to trigger
    $_SESSION["add-error"] = 0;

    // redirect back to page
    header("Location: admin-researchers.php");
?>