<?php 
    // ensures security, checks logged in (both users access this page)
    session_start();
    if (isset($_SESSION["username"])) {
		$username = $_SESSION["username"];
    } else {
        header("Location: login.php");
    }
    // checks if the required data is found, redirects if not
    if (!isset($_POST["subject-id"]) &&  $_SESSION["type"] == "researcher") {
        header("Location: researcher.php");
    }
    if (!isset($_POST["subject-id"]) &&  $_SESSION["type"] == "admin") {
        header("Location: admin.php");
    }
    // store the subject id
    $id = $_POST["subject-id"];
?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../static/css/data-subjects.css">
    <script src = "../js/data-subjects.js"></script>
</head>
<body>
	<div class="pure-menu pure-menu-horizontal">
		<ul class="pure-menu-list">
        <?php
            // gets the correct nav bar for the type of user
            if ( $_SESSION["type"] == "researcher") {
                echo "<li class='pure-menu-item pure-menu-selected'><a href='researcher.php' class='pure-menu-link'>Subjects</a></li>";
                echo "<li class='pure-menu-item'><a href='logout.php' class='pure-menu-link'>Logout</a></li>";
            } else {
                echo "<li class='pure-menu-item pure-menu-selected'><a href='admin.php' class='pure-menu-link'>Subjects</a></li>";
                echo "<li class='pure-menu-item'><a href='admin-researchers.php' class='pure-menu-link'>Researchers</a></li>";
                echo "<li class='pure-menu-item'><a href='summary.php' class='pure-menu-link'>Activity Summary</a></li>";
                echo "<li class='pure-menu-item'><a href='logout.php' class='pure-menu-link'>Logout</a></li>";
            }
        ?>
        </ul>
    </div>
    <div class=banner>
        <p class=banner-title>Browse Data</p>
    </div>
    
    <div class = subject-details>
        <table class='pure-table'>
			<thead>
			    <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Contact</th>
			    </tr>
			</thead>
			<tbody>
                <tr>
                <?php
                    // print the user details into a table, single row
                    $conn = new PDO('sqlite:./db/project.sqlite');
                                
                    if (!$conn) {
                        exit("Connection Failed: " . $conn); 
                    }
                    $sql = "SELECT * FROM Subject WHERE Subject.Subject_ID='".$id."'";
                    $rs = $conn->query($sql);
                    while($row = $rs->fetch()) {
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
                        echo "<td>$firstName</td>";
                        echo "<td>$lastName</td>";
                        echo "<td>$dob</td>";
                        echo "<td>$gender</td>";
                        echo "<td>$contact</td>";
                    }
                ?>
                </tr>
            </tbody>
		</table>
    </div>
    <div id = instructions class = instructions>
        <h3>Select an activity to generate a report</h3>
    </div>
    <div class = 'top-bar center-bar'>
        <button class = "pure-button" onclick = "showBaseline()" type = button>
            Basline Supine Rest
        </button>
        <button class = "pure-button" onclick = "showHeadTest()" type = button>
            Head-up Tilt Test
        </button>
        <button class = "pure-button" onclick = "showSuction1()" type = button>
            Suction Test Lvl 1
        </button>
        <button class = "pure-button" onclick = "showSuction2()" type = button>
            Suction Test Lvl 2
        </button>
    </div>

    <div id = baseline class = tests>
        <?php
            // gets ecg, ppg, hr, bp info for baseline
            $conn = new PDO('sqlite:./db/project.sqlite');
                                
            if (!$conn) {
                exit("Connection Failed: " . $conn); 
            }
            $sql = "SELECT Activity.Activity_ID, Activity.TestDate FROM (Subject JOIN Activity ON Subject.Subject_ID = Activity.Subject_ID) 
            WHERE ((Subject.Subject_ID)='$id') AND ((Activity.Description)='Baseline Supine Rest')";
            $rs = $conn->query($sql);

            $count_a = 0;
            while($row = $rs->fetch()) {
                $aid = $row['Activity_ID'];
                $_SESSION["aid"] = $aid;
                $date = $row['TestDate'];
				$split = explode(' ', $date);
				$temp = explode('-', $split[0]);
				$year = $temp[0];
				$month = $temp[1];
				$day =  $temp[2];
				$date = $day.'/'.$month.'/'.$year;
                $count_a++;
            }
			// get the correct date

            if ($count_a != 0) {
                echo "<h3>Baseline Supine Test</h3>";

                $sql_e = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='ECG')";

                $count_e = 0;
                $rs = $conn->query($sql_e);
                while($row = $rs->fetch()) {
                    $ecg_data = $row['Data'];
                    $count_e++;
                }

                if ($count_e != 0) {
                    include("ecg.php");
                }

                $sql_p = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='PPG')";

                $rs = $conn->query($sql_p);
                $count_p = 0;
                while($row = $rs->fetch()) {
                    $ppg_data = $row['Data'];
                    $count_p++;
                }

                if ($count_p != 0) {
                    include("ppg.php");
                }

                $sql_h = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='Heart Rate')";

                $rs = $conn->query($sql_h);
                $count_h = 0;
                while($row = $rs->fetch()) {
                    $h_data = $row['Data'];
                    $count_h++;
                }

                if ($count_h == 0) {
                    $h_data = "N/P";
                }

                $sql_b = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='Blood Pressure')";

                $rs = $conn->query($sql_b);
                $count_b = 0;
                while($row = $rs->fetch()) {
                    $b_data = $row['Data'];
                    $count_b++;
                }

                $b_data = explode(' ', $b_data);

                if ($count_b == 0) {
                    $b_data[0] = "N/P";
                    $b_data[1] = "N/P";
                    $b_data[2] = "N/P";
                }
                include("hr_bp.php");
            } else {
                echo "<span>No baseline supine rest data found to generate a report</span>";
            }
        ?>
    </div>

    <div id=headtilt class = tests>
        <?php
            // gets ecg, ppg, hr, bp info for head tilt
            $conn = new PDO('sqlite:./db/project.sqlite');
                                
            if (!$conn) {
                exit("Connection Failed: " . $conn); 
            }
            $sql = "SELECT Activity.Activity_ID, Activity.TestDate FROM (Subject JOIN Activity ON Subject.Subject_ID = Activity.Subject_ID) 
            WHERE ((Subject.Subject_ID)='$id') AND ((Activity.Description)='Head-up Tilt Test')";

            $rs = $conn->query($sql);
            $count_a = 0;
            while($row = $rs->fetch()) {
                $aid = $row['Activity_ID'];
                $_SESSION["aid"] = $aid;
                $date = $row['TestDate'];
				$split = explode(' ', $date);
				$temp = explode('-', $split[0]);
				$year = $temp[0];
				$month = $temp[1];
				$day =  $temp[2];
				$date = $day.'/'.$month.'/'.$year;
                $count_a++;
            }

            if ($count_a != 0) {
                echo "<h3>Head-up Tilt Test</h3>";
                $sql_e = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='ECG')";

                $count_e = 0;
                $rs = $conn->query($sql_e);
                while($row = $rs->fetch()) {
                    $ecg_data = $row['Data'];
                    $count_e++;
                }

                if ($count_e != 0) {
                    include("ecg.php");
                }

                $sql_p = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='PPG')";

                $rs = $conn->query($sql_p);
                $count_p = 0;
                while($row = $rs->fetch()) {
                    $ppg_data = $row['Data'];
                    $count_p++;
                }

                if ($count_p != 0) {
                    include("ppg.php");
                }

                $sql_h = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='Heart Rate')";

                $rs = $conn->query($sql_h);
                $count_h = 0;
                while($row = $rs->fetch()) {
                    $h_data = $row['Data'];
                    $count_h++;
                }

                if ($count_h == 0) {
                    $h_data = "N/P";
                }

                $sql_b = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='Blood Pressure')";

                $rs = $conn->query($sql_b);
                $count_b = 0;
                while($row = $rs->fetch()) {
                    $b_data = $row['Data'];
                    $count_b++;
                }

                $b_data = explode(' ', $b_data);

                if ($count_b == 0) {
                    $b_data[0] = "N/P";
                    $b_data[1] = "N/P";
                    $b_data[2] = "N/P";
                }

                include("hr_bp.php");
            } else {
                echo "<span>No head-up tilt test data found to generate a report</span>";
            }
        ?>
    </div>

    <div id = suction1 class = tests>
        <?php
            // gets ecg, ppg, hr, bp info for suction test 1
            $conn = new PDO('sqlite:./db/project.sqlite');
                                
            if (!$conn) {
                exit("Connection Failed: " . $conn); 
            }
            $sql = "SELECT Activity.Activity_ID, Activity.TestDate FROM (Subject JOIN Activity ON Subject.Subject_ID = Activity.Subject_ID) 
            WHERE ((Subject.Subject_ID)='$id') AND ((Activity.Description)='Suction Test: Level 1')";

            $rs = $conn->query($sql);
            $count_a = 0;
            while($row = $rs->fetch()) {
                $aid = $row['Activity_ID'];
                $_SESSION["aid"] = $aid;
                $date = $row['TestDate'];
				$split = explode(' ', $date);
				$temp = explode('-', $split[0]);
				$year = $temp[0];
				$month = $temp[1];
				$day =  $temp[2];
				$date = $day.'/'.$month.'/'.$year;
                $count_a++;
            }
		

            if ($count_a != 0) {
                echo "<h3>Suction Test Level 1</h3>";
                $sql_e = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='ECG')";

                $count_e = 0;
                $rs = $conn->query($sql_e);
                while($row = $rs->fetch()) {
                    $ecg_data = $row['Data'];
                    $count_e++;
                }

                if ($count_e != 0) {
                    include("ecg.php");
                }

                $sql_p = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='PPG')";

                $rs = $conn->query($sql_p);
                $count_p = 0;
                while($row = $rs->fetch()) {
                    $ppg_data = $row['Data'];
                    $count_p++;
                }

                if ($count_p != 0) {
                    include("ppg.php");
                }

                $sql_h = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='Heart Rate')";

                $rs = $conn->query($sql_h);
                $count_h = 0;
                while($row = $rs->fetch()) {
                    $h_data = $row['Data'];
                    $count_h++;
                }

                if ($count_h == 0) {
                    $h_data = "N/P";
                }

                $sql_b = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='Blood Pressure')";

                $rs = $conn->query($sql_b);
                $count_b = 0;
                while($row = $rs->fetch()) {
                    $b_data = $row['Data'];
                    $count_b++;
                } 
				if ($count_b == 0) {
                    $b_data[0] = "N/P";
                    $b_data[1] = "N/P";
                    $b_data[2] = "N/P";
                } else {
					$b_data = explode(' ', $b_data);
				}

                

                include("hr_bp.php");
            } else {
                echo "<span>No suction test level 1 data found to generate a report</span>";
            }
        ?>
    </div>

    <div id = suction2 class = tests>
        <?php
            // gets ecg, ppg, hr, bp info for baseline
            $conn = new PDO('sqlite:./db/project.sqlite');
                                
            if (!$conn) {
                exit("Connection Failed: " . $conn); 
            }
            $sql = "SELECT Activity.Activity_ID, Activity.TestDate FROM (Subject JOIN Activity ON Subject.Subject_ID = Activity.Subject_ID) 
            WHERE ((Subject.Subject_ID)='$id') AND ((Activity.Description)='Suction Test: Level 2')";
        
            $rs = $conn->query($sql);
            $count_a = 0;
            while($row = $rs->fetch()) {
                $aid = $row['Activity_ID'];
                $_SESSION["aid"] = $aid;
                $date = $row['TestDate'];
				$split = explode(' ', $date);
				$temp = explode('-', $split[0]);
				$year = $temp[0];
				$month = $temp[1];
				$day =  $temp[2];
				$date = $day.'/'.$month.'/'.$year;
                $count_a++;
            }

            if ($count_a != 0) {
                echo "<h3>Suction Test Level 2</h3>";
                $sql_e = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='ECG')";

                $count_e = 0;
                $rs = $conn->query($sql_e);
                while($row = $rs->fetch()) {
                    $ecg_data = $row['Data'];
                    $count_e++;
                }

                if ($count_e != 0) {
                    include("ecg.php");
                }

                $sql_p = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='PPG')";

                $rs = $conn->query($sql_p);
                $count_p = 0;
                while($row = $rs->fetch()) {
                    $ppg_data = $row['Data'];
                    $count_p++;
                }

                if ($count_p != 0) {
                    include("ppg.php");
                }

                $sql_h = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='Heart Rate')";

                $rs = $conn->query($sql_h);
                $count_h = 0;
                while($row = $rs->fetch()) {
                    $h_data = $row['Data'];
                    $count_h++;
                }

                if ($count_h == 0) {
                    $h_data = "N/P";
                }

                $sql_b = "SELECT * FROM Physiological_data
                WHERE ((Physiological_data.Activity_ID)='$aid') AND ((Physiological_data.VitalSignType)='Blood Pressure')";
				
                $rs = $conn->query($sql_b);
                $count_b = 0;
                while($row = $rs->fetch()) {
                    $b_data = $row['Data'];
                    $count_b++;
                }
				if ($count_b == 0) {
                    $b_data[0] = "N/P";
                    $b_data[1] = "N/P";
                    $b_data[2] = "N/P";
                } else {
					
                	$b_data = explode(' ', $b_data);
					
				}
                include("hr_bp.php");
            } else {
                echo "<span>No suction test level 2 data found to generate a report</span>";
            }
        ?>
    </div>

    </body>
    </html>