<?php 
	// ensures security, checks someone is logged in and an admin
	session_start();
	unset($_SESSION["subject-id"]);
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
	<script src = "../js/admin-researchers.js"></script>
	<link rel="stylesheet" type="text/css" href="../static/css/admin-researchers.css">
</head>

<body>
	<div class="pure-menu pure-menu-horizontal">
		<ul class="pure-menu-list">
			<li class="pure-menu-item"><a href="admin.php" class="pure-menu-link">Subjects</a></li>
			<li class="pure-menu-item pure-menu-selected"><a href="admin-researchers.php" class="pure-menu-link">Researchers</a></li>
			<li class="pure-menu-item"><a href="summary.php" class="pure-menu-link">Activity Summary</a></li>
			<li class="pure-menu-item"><a href="logout.php" class="pure-menu-link">Logout</a></li>
		</ul>
	</div>
	<div class = "add-popup" id = "AddForm"> 
	    <form action = "add-researcher.php" method = "POST" class = "pure-form pure-form-aligned form-add" onSubmit="return verify()">
	        <fieldset>
	        	<button type="button" class="pure-button exit" onclick="closeAddForm()"><i class="fas fa-times"></i></button>
				<h2 class="form-title">Add Researcher</h2>
				<div class="pure-control-group">
					<input id = username name="username" placeholder="Username" type="text" onChange = verifyUsername()>
					<p class = "tick" id = "username_y">&#10004;</p>
					<p id = "username_n">1-15 characters</p>
				</div>
				<div class="pure-control-group">
					<input id = password name="password" placeholder="Password" type="password" onChange = verifyPassword()>
					<p class = "tick" id = "password_y">&#10004;</p>
					<p id = "password_n">8-25 characters'</p>
	            </div>
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
					<input id = dob name="dob" placeholder="Birth Date (dd/mm/yyyy" type="text" onChange = verifyDOB()>
					<p class = "tick" id = "dob_y">&#10004;</p>
					<p id = "dob_n">invalid dd/mm/yy</p>
	            </div>
	            <div class="pure-control-group">
                    <select id = gender class = select name = gender onChange = verifyGender()>
						<option selected disabled value = "">Gender</option>
                        <option value = "Male" >Male</option>
                        <option value = "Female" >Female</option>
					</select>
					<p class = "tick" id = "gender_y">&#10004;</p>
					<p id = "gender_n">Select a gender</p>
                </div>
				<div class="pure-control-group">
					<input id = contact name="contact" placeholder="Phone Number" type="text" onChange = verifyContact()>
					<p class = "tick" id = "contact_y">&#10004;</p>
					<p id = "contact_n">8-10 digits</p>
	            </div>
	            <div class = edit>
	                <button type="submit" class="pure-button add-button" name = add-researcher>Add Researcher</button>
	            </div>
	        </fieldset>
	    </form>
    </div>

	<div class = "add-popup" id = "UpdateForm"> 
	    <form action = "update-researcher.php" method = "POST" class = "pure-form pure-form-aligned form-add">
	        <fieldset>
	        	<button type="button" class="pure-button exit" onclick="closeUpdateForm()"><i class="fas fa-times"></i></button>
	            <h2 class="form-title">Edit Researcher</h2>
	            <div class="pure-control-group">
	                <input id = firstname name="firstname" placeholder="First Name" type="text">
	            </div>
				<div class="pure-control-group">
	                <input id = lastname name="lastname" placeholder="Last Name" type="text">
	            </div>
	            <div class="pure-control-group">
	                <input id = dob name="dob" placeholder="Birth Date" type="text">
	            </div>
	            <div class="pure-control-group">
                    <select id = gender class = select name = gender>
                        <option value = "Male" >Male</option>
                        <option value = "Female" >Female</option>
                    </select>
                </div>
				<div class="pure-control-group">
	                <input id = contact name="contact" placeholder="Phone Number" type="text">
	            </div>
	            <div class = edit>
	                <button id = edit-researcher type="submit" class="pure-button add-button" name = edit-researcher>Edit Researcher</button>
	            </div>
	        </fieldset>
	    </form>
    </div>




		<div class=banner>
			<p class=banner-title>All Researchers</p>
		</div>
        <div class = top-bar-researcher>
        <button class = "pure-button" onclick = "openAddForm()" type = button>
            Add Researcher
        </button>
    </div>
		
	</body>
	<?php 
		// Use preconfigured Data Source Name to connect to database
		$conn = new PDO('sqlite:./db/project.sqlite');
                                
	    if (!$conn) {
	        exit("Connection Failed: " . $conn); 
	    }
			
		// Get all entries from the Subject table
		$sql = "SELECT * FROM User WHERE Admin='False' ORDER BY User.FirstName";
		
		$rs = $conn->query($sql);
		echo "<div id=subjects>";
		echo "<table class='pure-table'>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>First Name</th>";
		echo "<th>Last Name</th>";
		echo "<th>DOB</th>";
		echo "<th>Gender</th>";
		echo "<th>Contact</th>";
        echo "<th class = edit></th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while($row = $rs->fetch()) {
            $username = $row['Username'];
            $firstName = $row['FirstName'];
	        $lastName = $row['LastName'];
            $dob = $row['DOB'];
            $split = explode(' ', $dob);
            $temp = explode('-', $split[0]);
            $year = $temp[0];
            $month = $temp[1];
            $day =  $temp[2];
            $dob = $day.'/'.$month.'/'.$year;
	        $gender = $row['Gender'];
            $contact = $row['Contact'];
            if (empty($contact)) {
                $contact = "N/P";
            }
            echo "<tr>";
            echo "<td>$firstName</td>";
            echo "<td>$lastName</td>";
            echo "<td>$dob</td>";
            echo "<td>$gender</td>";
            echo "<td>$contact</td>";
            echo "<td class=edit>";
            echo "<form id='form_id' method='post' name='myform' action='edit-researcher.php'>";
			echo "<input hidden name='researcher-id' type='text' value='$username'>";
			echo "<input id='submit' class=pure-button name='edit-button' type='submit' value='Edit Researcher'>";
			echo "</form>";
            echo "</button>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
	?>
	<?php 
		if (isset($_SESSION["add-error"]) && $_SESSION["add-error"] == 1) {
			echo "<script>alert('Researcher could not be added as the username already exists')</script>";
			unset($_SESSION["add-error"]);
		} else if (isset($_SESSION["add-error"])) {
			echo "<script>alert('Researcher successfully added')</script>";
			unset($_SESSION["add-error"]);
		}
		if (isset($_SESSION["edit-error"]) && $_SESSION["edit-error"] == 1) {
			echo "<script>alert('Researcher could not be edited as the new username already exists')</script>";
			unset($_SESSION["edit-error"]);
		} else if (isset($_SESSION["edit-error"])) {
			echo "<script>alert('Researcher successfully edited')</script>";
			unset($_SESSION["edit-error"]);
		}
	?>
</html> 