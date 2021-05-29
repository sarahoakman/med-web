<?php 
    session_start();
    if (isset($_SESSION["username"]) && $_SESSION["type"] == "researcher") {
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
	<link rel="stylesheet" type="text/css" href="../static/css/researcher.css">
    <script src = "../js/researcher.js"></script>
</head>
<body>
	<div class="pure-menu pure-menu-horizontal">
		<ul class="pure-menu-list">
			<li class="pure-menu-item pure-menu-selected"><a href="researcher.php" class="pure-menu-link">Subjects</a></li>
			<li class="pure-menu-item"><a href="logout.php" class="pure-menu-link">Logout</a></li>
		</ul>
	</div>

	<div class = "add-popup" id = "add-subject"> 
        <form  action = "add-subject.php" method = "POST" class = "pure-form pure-form-aligned form-add" onSubmit="return verify()">
            <fieldset>
			<button type="button" class="pure-button exit" onclick="closeAddForm()"><i class="fas fa-times"></i></button>
                <h2 class="form-title">Add Subject</h2>
                <div class="pure-control-group">
					<input id = firstname name="firstname" placeholder="First Name" type="text" onChange = verifyFirstname()>
					<p class = "tick" id = "firstname_y">&#10004;</p>
					<p id = "firstname_n">1-20 characters, letters,-,'</p>
                </div>
                <div class="pure-control-group">
					<input id = lastname name="lastname" placeholder="Last Name" type="text" onChange = verifyLastname()>
					<p class = "tick" id = "lastname_y">&#10004;</p>
					<p id = "lastname_n">1-25 characters, letters,-,'</p>
                </div>
                <div class="pure-control-group">
					<input id = dob name="dob" placeholder="Birth Date" type="text" onChange = verifyDOB()>
					<p class = "tick" id = "dob_y">&#10004;</p>
					<p id = "dob_n">invalid dd/mm/yy</p>
                </div>
                <div class="pure-control-group">
                    <select id = gender class = select name = gender onChange = verifyGender()>
						<option selected disabled value = "" >Gender</option>
						<option value = "Male" >Male</option>
                        <option value = "Female" >Female</option>
					</select>
					<p class = "tick" id = "gender_y">&#10004;</p>
					<p id = "gender_n">Select a gender</p>
                </div>
                <div class="pure-control-group">
					<input id = contact name="contact" placeholder="Phone Number" type="text" onChange = verifyContact()>
					<p class = "tick" id = "contact_y">&#10004;</p>
					<p id = "contact_n">10 digits</p>
                </div>
                <div class = edit>
                    <button type="submit" class="pure-button" name = add-subject>Add Subject</button>
                </div>
            </fieldset>
        </form>
    </div>

	

		<div class=banner>
			<p class=banner-title>Your Subjects</p>
		</div>
		<div class = top-bar>
			<form class = "pure-form search search-right" method = "POST" action = "setSearch.php">
				<input name = "search" class = search-input type = "text" placeholder = "Search...">
				<i class = "fas fa-search"></i>
			</form>
			<button class = "pure-button" onclick = "openAddForm()" type = button>
				Add Subject
			</button>
		</div>
		
	</body>
	<?php
		 $conn = odbc_connect('z5206178', '', '',SQL_CUR_USE_ODBC);
        
		 if (!$conn) {
			 exit("Connection Failed: " . $conn); 
		 }
		 // checks if subject was edited
		if (isset($_SESSION["subject-edit"]) && $_SESSION["subject-edit"] == 1) {
			unset($_SESSION["subject-edit"]);
			echo "<script>alert('Subject successfully edited');</script>";
		}
		
		// gets the subjects linked to researcher logged in
		$sql = "SELECT Subject.Subject_ID, Subject.FirstName, Subject.LastName, Subject.DOB, Subject.Gender, Subject.Contact
		FROM Subject INNER JOIN ([User] INNER JOIN Researcher ON User.Username = Researcher.Researcher) ON Subject.Subject_ID = Researcher.Subject_ID
		WHERE User.Username = '".$username."' ORDER BY Subject.FirstName";
		
		$rs = odbc_exec($conn,$sql);

		// filters according to search
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
			echo "<th class = edit></th>";
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
					echo "<input id='submit' class=pure-button name='browse-button' type='submit' value='Browse Data'>";
					echo "</form>";
					echo "</td>";
					echo "<td class=edit>";
					echo "<form id='form_id' method='post' name='myform' action='edit-subject.php'>";
					echo "<input hidden name='subject-id' type='text' value='$id'>";
					echo "<input id='submit' class = pure-button name='edit-button' type='submit' value='Edit'>";
					echo "</form>";
					echo "</td>";
					echo "</tr>";
				}
			}
			echo "</tbody>";
			echo "</table>";
			echo "</div>";
			unset( $_SESSION["search"] );
		// shows all subjects
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
			echo "<th class = edit></th>";
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
				echo "<input id='submit' class=pure-button name='browse-button' type='submit' value='Browse Data'>";
				echo "</form>";
				echo "</td>";
				echo "<td class=edit>";
				echo "<form id='form_id' method='post' name='myform' action='edit-subject.php'>";
				echo "<input hidden name='subject-id' type='text' value='$id'>";
				echo "<input id='submit' class = pure-button name='edit-button' type='submit' value='Edit Subject'>";
				echo "</form>";
				echo "</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
			echo "</div>";
		}
		
	?>
	<?php
		// alert message when subject added
		if (isset($_SESSION["add-subject"])) {
			echo "<script>alert('Subject added successfully')</script>";
			unset($_SESSION["add-subject"]);
		}
	?>
</html>