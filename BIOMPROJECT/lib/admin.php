<?php 
	// ensures security, checks logged in and admin
    session_start();
    if (isset($_SESSION["username"]) && $_SESSION["type"] == "admin") {
       $username = $_SESSION["username"];
    } else {
        header("Location: login.php");
	}
?>
<!DOCTYPE html>
<head>
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../static/css/admin.css">
</head>

<body>
	<div class="pure-menu pure-menu-horizontal">
		<ul class="pure-menu-list">
			<li class="pure-menu-item pure-menu-selected"><a href="admin.php" class="pure-menu-link">Subjects</a></li>
			<li class="pure-menu-item"><a href="admin-researchers.php" class="pure-menu-link">Researchers</a></li>
			<li class="pure-menu-item"><a href="summary.php" class="pure-menu-link">Activity Summary</a></li>
            <li class="pure-menu-item"><a href="logout.php" class="pure-menu-link">Logout</a></li>
		</ul>
	</div>

	
	<div class=banner>
		<p class=banner-title>All Subjects</p>
	</div>
	<div class = top-bar>
		<form class = "pure-form search search-right" method = "POST" action = "setSearch.php">
			<input name = "search" class = search-input type = "text" placeholder = "Search...">
			<i class = "fas fa-search"></i>
		</form>
	</div>
	
</body>
<?php 
	// checks if any researchers have been assigned 
	if (isset($_SESSION["subject-id"]) && isset($_POST['assign-button'])) {
		$conn = odbc_connect('z5206178', '', '',SQL_CUR_USE_ODBC);
		if (!$conn) {
			exit("Connection Failed: " . $conn); 
		}
		$id = $_SESSION["subject-id"];
		if (!isset($_POST['researcher'])) {
			echo '<script>alert("No researchers assigned");</script>';
		} else {
			echo '<script>alert("Sucessfully assigned researchers");</script>';
			$researcher = $_POST['researcher'];
			foreach ($researcher as $r) {
				$sql = "INSERT INTO Researcher (Subject_ID,Researcher) VALUES ('$id','$r')";
				$rs = odbc_exec($conn, $sql);
			}
		}
		unset($_SESSION["subject-id"]);
	}

	$conn = odbc_connect('z5206178', '', '',SQL_CUR_USE_ODBC);
		
	if (!$conn) {
		exit("Connection Failed: " . $conn); 
	}

	// Print all subjects in a table
	$sql = "SELECT * FROM Subject ORDER BY Subject.FirstName";
	
	$rs = odbc_exec($conn,$sql);

	if (isset($_SESSION["search"]) && $_SESSION["search"] !== "") {
		$search = strtolower($_SESSION["search"]);
		$count = 0;
		echo "<div id=subjects>";
		echo "<table class='pure-table'>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>First Name</th>";
		echo "<th>Last Name</th>";
		echo "<th>DOB</th>";
		echo "<th>Gender</th>";
		echo "<th>Contact</th>";
		echo "<th class = data></th>";
		echo "<th class = assign></th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		while(odbc_fetch_row($rs)) {
			$id = odbc_result($rs,'Subject_ID');
			$firstName = odbc_result($rs,'FirstName');
			$lastName = odbc_result($rs,'LastName');
			$dob = odbc_result($rs,'DOB');
			$split = explode(' ', $dob);
			$temp = explode('-', $split[0]);
			$year = $temp[0];
			$month = $temp[1];
			$day =  $temp[2];
			$dob = $day.'/'.$month.'/'.$year;
			$gender = odbc_result($rs,'Gender');
			$contact = odbc_result($rs,'Contact');
			if (strpos(strtolower($firstName), $search) !== false || 
				strpos(strtolower($lastName), $search) !== false ||
				strpos(strtolower($dob), $search) !== false || 
				strpos(strtolower($gender), $search) !== false || 
				strpos(strtolower($contact), $search) !== false) {
				$count = $count + 1;
				if (empty($contact)) {
					$contact = "N/P";
				}
				echo "<tr>";
				echo "<td>$firstName</td>";
				echo "<td>$lastName</td>";
				echo "<td>$dob</td>";
				echo "<td>$gender</td>";
				echo "<td>$contact</td>";
				echo "<td class=data>";
				echo "<form id='form_id' method='post' name='myform' action='data-subjects.php'>";
				echo "<input hidden name='subject-id' type='text' value='$id'>";
				echo "<input id='submit' class='pure-button' name='browse-button' type='submit' value='Browse Data'>";
				echo "</form>";
				echo "</td>";
				echo "<td class=assign>";
				echo "<form id='form_id' method='post' name='myform' action='assign-researcher.php'>";
				echo "<input hidden name='subject-id' type='text' value='$id'>";
				echo "<input id='submit' class='pure-button' name='assign-button' type='submit' value='Assign Researcher'>";
				echo "</form>";
				echo "</td>";
				echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
		echo "</div>";
		unset( $_SESSION["search"] );
	} else {
		echo "<div id=subjects>";
		echo "<table class='pure-table'>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>First Name</th>";
		echo "<th>Last Name</th>";
		echo "<th>DOB</th>";
		echo "<th>Gender</th>";
		echo "<th>Contact</th>";
		echo "<th class = data></th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		while(odbc_fetch_row($rs)) {
			$id = odbc_result($rs,'Subject_ID');
			$firstName = odbc_result($rs,'FirstName');
			$lastName = odbc_result($rs,'LastName');
			$dob = odbc_result($rs,'DOB');
			$split = explode(' ', $dob);
			$temp = explode('-', $split[0]);
			$year = $temp[0];
			$month = $temp[1];
			$day =  $temp[2];
			$dob = $day.'/'.$month.'/'.$year;
			$gender = odbc_result($rs,'Gender');
			$contact = odbc_result($rs,'Contact');
			if (empty($contact)) {
				$contact = "N/P";
			}
			echo "<tr>";
			echo "<td>$firstName</td>";
			echo "<td>$lastName</td>";
			echo "<td>$dob</td>";
			echo "<td>$gender</td>";
			echo "<td>$contact</td>";
			echo "<td class=data>";
			echo "<form id='form_id' method='post' name='myform' action='data-subjects.php'>";
			echo "<input hidden name='subject-id' type='text' value='$id'>";
			echo "<input id='submit' class='pure-button' name='browse-button' type='submit' value='Browse Data'>";
			echo "</form>";
			echo "</td>";
			echo "<td class=assign>";
			echo "<form id='form_id' method='post' name='myform' action='assign-researcher.php'>";
			echo "<input hidden name='subject-id' type='text' value='$id'>";
			echo "<input id='submit' class='pure-button' name='assign-button' type='submit' value='Assign Researcher'>";
			echo "</form>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</div>";
	}
	
?>
</html> 