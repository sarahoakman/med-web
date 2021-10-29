<?php 
    // ensures security, checks logged in and admin
    session_start();
    if (isset($_SESSION["username"]) && $_SESSION["type"] == "admin") {
        $username = $_SESSION["username"];
    } else {
        header("Location: login.php");
    }
    if (!isset($_POST["subject-id"])) {
        header("Location: admin.php");
    }
?>
<!DOCTYPE>
<head>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../static/css/assign-researcher.css">
</head>
<body>
    <div class = "assign-form"> 
	    <form action = "admin.php" method = "POST" class = "pure-form pure-form-aligned form-assign">
	        <h2 class="form-title">Select Researchers</h2>
            <div class="pure-control-group">
            <?php
                // creates the list of researchers to assign
                $conn = new PDO('sqlite:./db/project.sqlite');
                                
                if (!$conn) {
                    exit("Connection Failed: " . $conn); 
                }
                
                $sql = "SELECT * FROM User WHERE Admin='False' ORDER BY User.FirstName";

                $allResearchers = $conn->query($sql);
                
                // disables and checks boxes for researchers already assigned
                // other researchers are selectable, stores them in a list
                while($row = $allResearchers->fetch()) {
                    $firstname = $row['FirstName'];
                    $lastname = $row['LastName'];
                    $username = $row['Username'];
                    echo "<div>";
                    if (findResearcher($username) == true) {
                        echo "<input type='checkbox' checked = 'checked' disabled>$firstname $lastname</input>";
                    } else {
                        echo "<input type='checkbox' name='researcher[]' value='$username'>$firstname $lastname</input>";
                    }
                    echo "</div>";
                }
                echo"</div>";
                // set the subject-id for the subject that we are assigned a researcher to 
                $id = $_POST["subject-id"];
                $_SESSION["subject-id"] = $id;
				echo "<input id='submit' class='assign pure-button' name='assign-button' type='submit' value='Assign'>";

                // checks in the researcher is already assigned
                function findResearcher($username) {
                    $conn = new PDO('sqlite:./db/project.sqlite');
                                
                    if (!$conn) {
                        exit("Connection Failed: " . $conn); 
                    }

                    $id = $_POST["subject-id"];
                    $sql = "SELECT User.FirstName, User.LastName, User.Username, Researcher.Subject_ID
                    FROM [User] INNER JOIN Researcher ON User.Username = Researcher.Researcher
                    WHERE (((Researcher.Subject_ID)='".$id."'))";

                    $alreadyRegistered = $conn->query($sql);
                    while($row = $alreadyRegistered->fetch()) {
                        if ($username == $row['Username']) {
                            return true;
                        }
                    }
                    return false;
                }
            ?>
            <input id='submit' class='cancel pure-button' name='cancel-button' type='submit' value='Cancel'>
            </div>
        </form>
    </div>
</body>
</html>