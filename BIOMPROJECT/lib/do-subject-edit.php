<?php 
    session_start();
    $conn = odbc_connect('z5206178', '', '',SQL_CUR_USE_ODBC);
        
    if (!$conn) {
        exit("Connection Failed: " . $conn); 
    }
    
    // updates each input given if not empty 
    if (isset($_SESSION["subject-id"])) {
        $id = $_SESSION["subject-id"];
        if (!empty($_POST['firstname'])) {
            $firstname = $_POST['firstname'];
            $sql = "UPDATE Subject SET Subject.FirstName='$firstname' WHERE Subject.Subject_ID='".$id."'";
            $rs = odbc_exec($conn,$sql);
        }
        if (!empty($_POST['lastname'])) {
            $lastname = $_POST['lastname'];
            $sql = "UPDATE Subject SET Subject.Lastname='$lastname' WHERE Subject.Subject_ID='".$id."'";
            $rs = odbc_exec($conn,$sql);
        }
        if (!empty($_POST['dob'])) {
            $dob = "#".$_POST["dob"]."#";
            $sql = "UPDATE Subject SET Subject.DOB=$dob WHERE Subject.Subject_ID='".$id."'";
            $rs = odbc_exec($conn,$sql);
        }
        if (!empty($_POST['gender'])) {
            $gender = $_POST['gender'];
            $sql = "UPDATE Subject SET Subject.Gender='$gender' WHERE Subject.Subject_ID='".$id."'";
            $rs = odbc_exec($conn,$sql);
        }
        if (!empty($_POST['contact'])) {
            $contact = $_POST['contact'];
            if (strlen($contact) == 8) {
                $contact = '  '.$contact;
            }
            $sql = "UPDATE Subject SET Subject.Contact='$contact' WHERE Subject.Subject_ID='".$id."'";
            $rs = odbc_exec($conn,$sql);
        }
        unset($_SESSION["subject-id"]);
        $_SESSION["subject-edit"] = 1;
    }
    header("Location: researcher.php");
?>