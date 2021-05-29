<?php
    // put hr and bp into a table
    echo "<div id=heart-rate>";
    echo "<table class='pure-table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Heart Rate (beats/min)</th>";
    echo "<th>Systolic Blood Pressure (mmHg)</th>";
    echo "<th>Diastolic Blood Pressure (mmHg)</th>";
    echo "<th>Mean Blood Pressure (mmHg)</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    echo "<td>$h_data</td>";
    echo "<td>$b_data[0]</td>";
    echo "<td>$b_data[1]</td>";
    echo "<td>$b_data[2]</td>";
    echo "<tbody>";
    echo "</table>";
    echo "</div>";
?>