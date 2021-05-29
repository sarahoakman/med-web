<?php

	session_start();

	$conn = odbc_connect('z5206178', '', '',SQL_CUR_USE_ODBC);
				
	if (!$conn) {
		exit("Connection Failed: " . $conn); 
	}

	// get inputs for adding to database
	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$dob = "#".$_POST["dob"]."#";
	$gender = $_POST["gender"];
	$contact =  $_POST["contact"];
	if (strlen($contact) == 8) {
		$contact = '  '.$contact;
	}
	// calculate the new subject id
	$sql = "SELECT * FROM Subject";
	$rs = odbc_exec($conn,$sql);
	// find max existing id
	$max = 0;
	while(odbc_fetch_row($rs)) {
		$id = odbc_result($rs, 'Subject_ID');
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
	$sql = "INSERT INTO Subject (Subject_ID,FirstName,LastName,DOB,Gender,Contact) VALUES ('$new_id','$firstname','$lastname',$dob,'$gender','$contact')";
	$rs = odbc_exec($conn,$sql);

	// assign the subject to the researcher automatically
	$username = $_SESSION["username"];
	$sql = "INSERT INTO Researcher (Subject_ID,Researcher) VALUES ('$new_id','$username')";
	$rs = odbc_exec($conn,$sql);

	// used to check whether it was successfully added and triggers an alert
	$_SESSION["add-subject"] = 0;

	// redirect back to page
	header("Location: researcher.php");
?>