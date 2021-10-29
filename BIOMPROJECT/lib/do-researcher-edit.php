<?php 
    session_start();

    $conn = new PDO('sqlite:./db/project.sqlite');
                                
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
    $sql = "SELECT * FROM User WHERE Username='".$username."'";
    $rs = $conn->query($sql);
    while($row = $rs->fetch()) {
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
            $sql = "UPDATE User SET Password='$password' WHERE Username='".$id."'";
            $rs = $conn->exec($sql);
        }
        if (!empty($_POST['firstname'])) {
            $firstname = $_POST['firstname'];
            $sql = "UPDATE User SET FirstName='$firstname' WHERE Username='".$id."'";
            $rs = $conn->exec($sql);
        }
        if (!empty($_POST['lastname'])) {
            $lastname = $_POST['lastname'];
            $sql = "UPDATE User SET Lastname='$lastname' WHERE Username='".$id."'";
            $rs = $conn->exec($sql);
        }
        if (!empty($_POST['dob'])) {
            $dob = "#".$_POST["dob"]."#";
            $sql = "UPDATE User SET DOB=$dob WHERE Username='".$id."'";
            $rs = $conn->exec($sql);
        }
        if (!empty($_POST['gender'])) {
            $gender = $_POST['gender'];
            $sql = "UPDATE User SET Gender='$gender' WHERE Username='".$id."'";
            $rs = $conn->exec($sql);
        }
        if (!empty($_POST['contact'])) {
            $contact = $_POST['contact'];
            if (strlen($contact) == 8) {
                $contact = '  '.$contact;
            }
            $sql = "UPDATE User SET Contact='$contact' WHERE Username='".$id."'";
            $rs = $conn->exec($sql);
        }
        if (!empty($_POST['username'])) {
            $username = $_POST['username'];
            $sql = "UPDATE User SET Username='$username' WHERE Username='$id'";
            $rs = $conn->exec($sql);
        }
    }
    unset($_SESSION["researcher-username"]);
    $_SESSION["edit-error"] = 0;
    header("Location: admin-researchers.php");

?>