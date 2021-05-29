<?php 
    // ensures security, checks logged in and a researcher
    session_start();
    if (isset($_SESSION["username"]) && $_SESSION["type"] == "researcher") {
       $username = $_SESSION["username"];
    } else {
        header("Location: login.php");
    }
    // stores subject id for editing
    if (isset($_POST["subject-id"])) {
        $id = $_POST["subject-id"];
        $_SESSION["subject-id"] = $id;
    } else {
        header("Location: researcher.php");
    }
?>

<!DOCTYPE>
<head>
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../static/css/edit-subject.css">
    <script src = "../js/edit-subject.js"></script>
</head>
<body>
    <div class = "add-form"> 
	    <form action = "do-subject-edit.php" method = "POST" class = "pure-form pure-form-aligned form-add" onSubmit="return verify()">
	        <fieldset>
	        	<h2 class="form-title">Edit Subject</h2>
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