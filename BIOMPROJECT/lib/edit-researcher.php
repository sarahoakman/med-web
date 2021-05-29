<?php 
	// ensure security, checks logged in and admin
    session_start();
    if (isset($_SESSION["username"]) && $_SESSION["type"] == "admin") {
       $username = $_SESSION["username"];
    } else {
        header("Location: login.php");
	}
	// store the researcher's username
    if (isset($_POST["researcher-id"])) {
        $id = $_POST["researcher-id"];
        $_SESSION["researcher-username"] = $id;
    } else {
        header("Location: admin-researchers.php");
    }
?>

<script>
	// Checks if the given inputs satisfy making a researcher edit
	function verify() {	
		var username = document.getElementById("username").value;
		var check_u = document.getElementById("username_n").style.display;
		var password = document.getElementById("password").value;
		var check_p = document.getElementById("password_n").style.display;
		var firstname = document.getElementById("firstname").value;
		var check_f = document.getElementById("firstname_n").style.display;
		var lastname = document.getElementById("lastname").value;
		var check_l = document.getElementById("lastname_n").style.display;
		var dob = document.getElementById("dob").value;
		var check_d = document.getElementById("dob_n").style.display;
		var gender = document.getElementById("gender").value;
		var check_g = document.getElementById("gender_n").style.display;
		var contact = document.getElementById("contact").value;
		var check_c = document.getElementById("contact_n").style.display;

		if (username == "" && password == "" && firstname == "" && lastname == "" && dob == "" && gender == "" && contact == "") {
			alert("Enter a field to edit");
			return false;
		}

		if (username != "" && check_u == "block") {
			 alert("Invalid form, subject not edited");
			return false;
		} 
		if (password != "" && check_p == "block") {
			 alert("Invalid form, subject not edited");
			return false;
		}
		if (firstname != "" && check_f == "block") {
			 alert("Invalid form, subject not edited");
			return false;
		} 
		if (lastname != "" && check_l == "block") {
			 alert("Invalid form, subject not edited");
			return false;
		} 
		if (dob != "" && check_d == "block") {
			 alert("Invalid form, subject not edited");
			return false;
		} 
		if (gender != "" && check_g == "block") {
			 alert("Invalid form, subject not edited");
			return false;
		} 
		if (contact != "" && check_c == "block") {
			 alert("Invalid form, subject not edited");
			return false;
		} 
		return true;
	}

	function hideVerification() {
		document.getElementById("username").value = "";
		document.getElementById("password").value = "";
		document.getElementById("firstname").value = "";
		document.getElementById("lastname").value = "";
		document.getElementById("dob").value = "";
		document.getElementById("gender").value = "";
		document.getElementById("contact").value = "";
		document.getElementById("username_n").style.display = "none";
		document.getElementById("username_y").style.display = "none";
		document.getElementById("password_n").style.display = "none";
		document.getElementById("password_y").style.display = "none";
		document.getElementById("firstname_n").style.display = "none";
		document.getElementById("firstname_y").style.display = "none";
		document.getElementById("lastname_n").style.display = "none";
		document.getElementById("lastname_y").style.display = "none";
		document.getElementById("dob_n").style.display = "none";
		document.getElementById("dob_y").style.display = "none";
		document.getElementById("gender_n").style.display = "none";
		document.getElementById("gender_y").style.display = "none";
		document.getElementById("contact_n").style.display = "none";
		document.getElementById("contact_y").style.display = "none";
	}

	window.onload = hideVerification;

	function verifyUsername() {
		var check= document.getElementById("username").value;
		var msg1 = document.getElementById("username_n");
		var msg2 = document.getElementById("username_y");
		if (check.length < 1 || check.length  > 15) {
			msg1.style.display = "block";
			msg2.style.display = "none";
			
		} else {
			msg1.style.display = "none";
			msg2.style.display = "block";
		}
	}

	function verifyPassword() {
		var check = document.getElementById("password").value;
		var msg1 = document.getElementById("password_n");
		var msg2 = document.getElementById("password_y");
		if (check.length < 8 || check.length  > 25) {
			msg1.style.display = "block";
			msg2.style.display = "none";
		} else {
			msg1.style.display = "none";
			msg2.style.display = "block";
		}
	}

	function verifyFirstname() {
		var check = document.getElementById("firstname").value;
		var msg1 = document.getElementById("firstname_n");
		var msg2 = document.getElementById("firstname_y");
		var re1 = /^[a-zA-Z'-]+$/;
		if (re1.test(check) == false || check.length < 1 || check.length > 20) {
			msg1.style.display = "block";
			msg2.style.display = "none";
		} 
		if (re1.test(check) == true && check.length >= 1 && check.length <= 20) {
			msg1.style.display = "none";
			msg2.style.display = "block";
		}
	}

	function verifyLastname() {
		var check = document.getElementById("lastname").value;
		var msg1 = document.getElementById("lastname_n");
		var msg2 = document.getElementById("lastname_y");
		var re1 = /^[a-zA-Z'-]+$/;
		if (re1.test(check) == false || check.length < 1 || check.length > 25) {
			msg1.style.display = "block";
			msg2.style.display = "none";
		} else  {
			msg1.style.display = "none";
			msg2.style.display = "block";
		}
	}

	function verifyDOB() {
		var check = document.getElementById("dob").value;
		var msg1 = document.getElementById("dob_n");
		var msg2 = document.getElementById("dob_y");
		// Checks that it's in the correct format
		var re1 = /^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/;
		// Splits it into day, month, year
		var str = check.split("/");
		// Change into an int to compare, making sure it's not centuries ago
		var year = parseInt(str[2]);
		// Rearrange date so that the month appears first for the Date format
		var tempDate = str[1] + "/" + str[0] + "/" + str[2];
		// Get a date object
		var date = Date.parse(tempDate);
		// Get the current date and split into year, month, date
		var currDate = new Date();
		var currYear = currDate.getFullYear();
		var currMonth = currDate.getMonth();
		var currDay = currDate.getDate();
		// make a date 18 years ago to make sure registration is by valid people
		var validDate = new Date(currYear - 18, currMonth, currDay);
		// toggle the error messages and tick icon for invalid and valid dates
		if (re1.test(check) == true && isNaN(date) == false && year >= 1899 
			&& validDate >= date) {
			msg1.style.display = "none";
			msg2.style.display = "block";
		} else  {
			msg1.style.display = "block";
			msg2.style.display = "none";
		}
	}

	function verifyGender() {
		var check = document.getElementById("gender").value;
		var msg1 = document.getElementById("gender_n");
		var msg2 = document.getElementById("gender_y");
		if (check == "") {
			msg1.style.display = "block";
			msg2.style.display = "none";
		} else {
			msg1.style.display = "none";
			msg2.style.display = "block";
		}
	}
	function verifyContact() {
		var check = document.getElementById("contact").value;
		var msg1 = document.getElementById("contact_n");
		var msg2 = document.getElementById("contact_y");
		var re1 = /^[0-9]+$/;
		if (check != "") {
			if (!re1.test(check) || !(check.length == 10 || check.length == 8)) {
				msg1.style.display = "block";
				msg2.style.display = "none";
			} else {
				msg1.style.display = "none";
				msg2.style.display = "block";
			}
		} else {
			msg1.style.display = "none";
			msg2.style.display = "block";
		}
	}
</script>
<!DOCTYPE>
<head>
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../static/css/edit-researcher.css">
</head>
<body>
    <div class = "add-form"> 
	    <form action = "do-researcher-edit.php" method = "POST" class = "pure-form pure-form-aligned form-add" onSubmit="return verify()">
	        <fieldset>
	        	<h2 class="form-title">Edit Researcher</h2>
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
	                <input id = dob name="dob" placeholder="Birth Date" type="text" onChange = verifyDOB()>
                    <p class = "tick" id = "dob_y">&#10004;</p>
					<p id = "dob_n">invalid dd/mm/yy</p>
                </div>
	            <div class="pure-control-group">
                    <select id = gender class = select name = gender onChange = verifyGender()>
                        <option value = "" selected disabled>Gender</option>
                        <option value = "Male" >Male</option>
                        <option value = "Female" >Female</option>
                    </select>
                    <p class = "tick" id = "gender_y">&#10004;</p>
					<p id = "gender_n">Select a gender</p>
                </div>
				<div class="pure-control-group">
	                <input id = contact name="contact" placeholder="Phone Number" type="text" onChange = verifyContact()>
                    <p class = "tick" id = "contact_y">&#10004;</p>
					<p id = "contact_n">8 or 10 digits</p>
                </div>
	            <div class = edit>
                    <input id='edit-subject' class='pure-button' name='edit-button' type='submit' value='Edit'>
	            </div>
	        </fieldset>
	    </form>
    </div>
</body>
</html>