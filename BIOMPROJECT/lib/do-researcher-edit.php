<?php 
    session_start();

    $conn = odbc_connect('z5206178', '', '',SQL_CUR_USE_ODBC);
        
    if (!$conn) {
        exit("Connection Failed: " . $conn); 
    }

    // gets info to edit researcher
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

    // ensure the username is unique, doesn't already exist
    $sql = "SELECT * FROM User WHERE User.Username='".$username."'";
    $rs = odbc_exec($conn,$sql);
    while(odbc_fetch_row($rs)) {
        $_SESSION["edit-error"] = 1;
        header("Location: admin-researchers.php");
        exit();
    }
    // store the username of the researcher to use in below queries
    $id = $_SESSION["researcher-username"];

    // updates each input if given, put username last so that we can use the same username stored above
    if (isset($_SESSION["researcher-username"])) {
        if (!empty($_POST['password'])) {
            $password = $_POST['password'];
            $sql = "UPDATE User SET User.Password='$password' WHERE User.Username='".$id."'";
            $rs = odbc_exec($conn,$sql);
        }
        if (!empty($_POST['firstname'])) {
            $firstname = $_POST['firstname'];
            $sql = "UPDATE User SET User.FirstName='$firstname' WHERE User.Username='".$id."'";
            $rs = odbc_exec($conn,$sql);
        }
        if (!empty($_POST['lastname'])) {
            $lastname = $_POST['lastname'];
            $sql = "UPDATE User SET User.Lastname='$lastname' WHERE User.Username='".$id."'";
            $rs = odbc_exec($conn,$sql);
        }
        if (!empty($_POST['dob'])) {
            $dob = "#".$_POST["dob"]."#";
            $sql = "UPDATE User SET User.DOB=$dob WHERE User.Username='".$id."'";
            $rs = odbc_exec($conn,$sql);
        }
        if (!empty($_POST['gender'])) {
            $gender = $_POST['gender'];
            $sql = "UPDATE User SET User.Gender='$gender' WHERE User.Username='".$id."'";
            $rs = odbc_exec($conn,$sql);
        }
        if (!empty($_POST['contact'])) {
            $contact = $_POST['contact'];
            if (strlen($contact) == 8) {
                $contact = '  '.$contact;
            }
            $sql = "UPDATE User SET User.Contact='$contact' WHERE User.Username='".$id."'";
            $rs = odbc_exec($conn,$sql);
        }
        if (!empty($_POST['username'])) {
            $username = $_POST['username'];
            $sql = "UPDATE User SET User.Username='$username' WHERE User.Username='".$id."'";
            $rs = odbc_exec($conn,$sql);
        }
    }
    unset($_SESSION["researcher-username"]);
    $_SESSION["edit-error"] = 0;
    header("Location: admin-researchers.php");

?>