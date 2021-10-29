<?php

    session_start();

   $conn = new PDO('sqlite:./db/project.sqlite');
                                
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
    $sql = "SELECT * FROM User WHERE Username='".$username."'";
    $rs = $conn->query($sql);
    while($row = $rs->fetch()) {
        $_SESSION["add-error"] = 1;
        header("Location: admin-researchers.php");
        exit();
    }

    // insert valid data into database
    $new_dob = str_replace('/', '-', $dob);
    $new_dob = date('Y-m-d', strtotime($new_dob));
    $sql = "INSERT INTO User (Username,[Password],FirstName,LastName,DOB,Gender,Contact,[Admin]) VALUES (?,?,?,?,?,?,?,'False')";
    $rs = $conn->prepare($sql);
    $rs->execute([$username,$password,$firstname,$lastname,$new_dob,$gender,$contact]);

    // use this to check what alert to trigger
    $_SESSION["add-error"] = 0;

    // redirect back to page
    header("Location: admin-researchers.php");
?>