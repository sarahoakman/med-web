<?php
    // gets a dictionary representation of HR, Mean HR, Standard deviation by ages
    function getHRPerAge($test) {
        $conn = new PDO('sqlite:./db/project.sqlite');
                                
        if (!$conn) {
            exit("Connection Failed: " . $conn); 
        }
        $sql = "SELECT * FROM Activity WHERE ((Description)='$test')";
        $rs = $conn->query($sql);
        $aid = array();
        $temp_sid = array();
        while($row=$rs->fetch()) {
            array_push($aid, $row['Activity_ID']);
            array_push($temp_sid, $row['Subject_ID']);
            
        }
        $sid = array();
        $hr = array();
        $j = 0;
        foreach($aid as $a) {
            $i = intval($a);
            $sql = "SELECT * FROM Physiological_data WHERE (((VitalSignType)='Heart Rate') AND ((Activity_ID) ='$i'))";
            $rs = $conn->query($sql);
            while($row = $rs->fetch()) {
                array_push($sid, $temp_sid[$j]);
                array_push($hr, $row['Data']);
            }
            $j++;
        }
        
        $age_temp = array();
        foreach($sid as $s) {
            $sql = "SELECT * FROM Subject WHERE ((Subject_ID)='$s')";
            $rs = $conn->query($sql);
            while($row = $rs->fetch()) {
                $dob = $row['DOB'];
                $temp = date_diff(date_create($dob), date_create('now'))->y;
                array_push($age_temp, $temp);
            }
        }
        $age = array();
        $i = 0;
        foreach($age_temp as $a) {
            if (!isset($age["$a"])) {
                $age["$a"] = $hr[$i];
            } else {
                $age["$a"] .= ' '.$hr[$i];
            }
            $i++;
        }
        return $age;
    }

    function getMeanHR($test) {
        $age = getHRPerAge($test); 
        $conn = new PDO('sqlite:./db/project.sqlite');
                                
        if (!$conn) {
            exit("Connection Failed: " . $conn); 
        }
        $mean_hr = array();
        foreach($age as $key => $value) {
            $v = $value;
            $split = explode(' ', $v);
            $avg = array_sum($split)/count($split);
            $mean_hr["$key"] = $avg;
        }
        return $mean_hr;
    }

    function getSD($test) {
        $age = getHRPerAge($test); 
        $mean_hr = getMeanHR($test);

        $sd = array();
        foreach($age as $key => $value) {
            $v = $value;
            $split = explode(' ', $v);
            $sd_temp = standard_deviation($split, $mean_hr[$key]);
            $sd["$key"] = $sd_temp;
        }
        return $sd;
    }

    function standard_deviation($array, $avg) {
        $res = array();
        foreach ($array as $a) {
            $temp = ($a - $avg) * ($a - $avg);
            array_push($res, $temp);
        }
        $mean = array_sum($res)/count($res);
        return sqrt($mean);
    }

    function tabulateData($b_meanHR, $b_sd) {
        echo "<div id=heart-rate>";
        echo "<table class='pure-table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Age (years)";
        echo "<th>Mean Heart Rate (beats/min)";
        echo "<th>Standard Deviation</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        foreach($b_meanHR as $key => $value) {
            $v = round($value, 2);
            $s = round($b_sd[$key], 2);
            echo "<tr>";
            echo "<td>$key</td>";
            echo "<td>$v</td>";
            echo "<td>$s</td>";
            echo "</tr>";
        }
        echo "<tbody>";
        echo "</table>";
        echo "</div>";
    }
?>