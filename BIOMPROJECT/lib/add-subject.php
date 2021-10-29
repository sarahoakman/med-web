<?php

	session_start();

	$conn = new PDO('sqlite:./db/project.sqlite');
                                
    if (!$conn) {
        exit("Connection Failed: " . $conn); 
    }

	// get inputs for adding to database
	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$dob = $_POST["dob"];
	$gender = $_POST["gender"];
	$contact =  $_POST["contact"];
	if (strlen($contact) == 8) {
		$contact = '  '.$contact;
	}
	// calculate the new subject id
	$sql = "SELECT * FROM Subject";
	$rs = $conn->query($sql);
	// find max existing id
	$max = 0;
	while($row = $rs->fetch()) {
		$id = $row['Subject_ID'];
		$int = preg_replace("/[^0-9]/", "", $id);
		if (intval($int) > $max) {
			$max = $int;
		}
	}
	// make the new id
	$new_id = "AA";
	$max++;
	if ($max < 10) {
		$new_id .= '0'.strval($max);
	} else {
		$new_id .= strval($max);
	}

	// insert new subject to database
	$new_dob = str_replace('/', '-', $dob);
	$new_dob = date('Y-m-d', strtotime($new_dob));
	$sql = "INSERT INTO Subject (Subject_ID,FirstName,LastName,DOB,Gender,Contact) VALUES (?,?,?,?,?,?)";
	$rs = $conn->prepare($sql);
	$rs->execute([$new_id,$firstname,$lastname,$new_dob,$gender,$contact]);

	// assign the subject to the researcher automatically
	$username = $_SESSION["username"];
	$sql = "INSERT INTO Researcher (Subject_ID,Researcher) VALUES (?,?)";
	$rs = $conn->prepare($sql);
	$rs->execute([$new_id,$username]);

	// used to check whether it was successfully added and triggers an alert
	$_SESSION["add-subject"] = 0;

	// redirect back to page
	header("Location: researcher.php");
?>