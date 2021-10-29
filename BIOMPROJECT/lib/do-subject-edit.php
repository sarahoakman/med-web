<?php 
    session_start();
    $conn = new PDO('sqlite:./db/project.sqlite');
                                
    if (!$conn) {
        exit("Connection Failed: " . $conn); 
    }
    
    // updates each input given if not empty 
    if (isset($_SESSION["subject-id"])) {
        $id = $_SESSION["subject-id"];
        if (!empty($_POST['firstname'])) {
            $firstname = $_POST['firstname'];
            $sql = "UPDATE Subject SET FirstName='$firstname' WHERE Subject_ID='".$id."'";
            $rs = $conn->exec($sql);
        }
        if (!empty($_POST['lastname'])) {
            $lastname = $_POST['lastname'];
            $sql = "UPDATE Subject SET Lastname='$lastname' WHERE Subject_ID='".$id."'";
            $rs = $conn->exec($sql);
        }
        if (!empty($_POST['dob'])) {
            $dob = $_POST["dob"];
            $sql = "UPDATE Subject SET DOB=? WHERE Subject_ID='".$id."'";
            $rs = $conn->prepare($sql);
            $rs->execute($dob);
        }
        if (!empty($_POST['gender'])) {
            $gender = $_POST['gender'];
            $sql = "UPDATE Subject SET Gender='$gender' WHERE Subject_ID='".$id."'";
            $rs = $conn->exec($sql);
        }
        if (!empty($_POST['contact'])) {
            $contact = $_POST['contact'];
            if (strlen($contact) == 8) {
                $contact = '  '.$contact;
            }
            $sql = "UPDATE Subject SET Contact='$contact' WHERE Subject_ID='".$id."'";
            $rs = $conn->exec($sql);
        }
        unset($_SESSION["subject-id"]);
        $_SESSION["subject-edit"] = 1;
    }
    header("Location: researcher.php");
?>