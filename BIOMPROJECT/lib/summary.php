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
    <link rel="stylesheet" type="text/css" href="../static/css/summary.css">
</head>

<body>
	<div class="pure-menu pure-menu-horizontal">
		<ul class="pure-menu-list">
			<li class="pure-menu-item"><a href="admin.php" class="pure-menu-link">Subjects</a></li>
            <li class="pure-menu-item"><a href="admin-researchers.php" class="pure-menu-link">Researchers</a></li>
            <li class="pure-menu-item pure-menu-selected"><a href="summary.php" class="pure-menu-link">Activity Summary</a></li>
            <li class="pure-menu-item"><a href="logout.php" class="pure-menu-link">Logout</a></li>
		</ul>
	</div>
	<div class=banner>
		<p class=banner-title>Activity Summary</p>
    </div>
    <div class=graph>
    <?php
        // makes graphs and tables for the reports
        include("summary-calculations.php");
        $b_meanHR = getMeanHR('Baseline Supine Rest');
        $b_xVal = array();
        $b_yVal = array();
        foreach($b_meanHR as $key => $value) {
            array_push($b_xVal, $key);
            array_push($b_yVal, $value);
        }

        $h_meanHR = getMeanHR('Head-up Tilt Test');
        $h_xVal = array();
        $h_yVal = array();
        foreach($h_meanHR as $key => $value) {
            array_push($h_xVal, $key);
            array_push($h_yVal, $value);
        }

        $s1_meanHR = getMeanHR('Suction Test: Level 1');
        $s1_xVal = array();
        $s1_yVal = array();
        foreach($s1_meanHR as $key => $value) {
            array_push($s1_xVal, $key);
            array_push($s1_yVal, $value);
        }
        
        $s2_meanHR = getMeanHR('Suction Test: Level 2');
        $s2_xVal = array();
        $s2_yVal = array();
        foreach($s2_meanHR as $key => $value) {
            array_push($s2_xVal, $key);
            array_push($s2_yVal, $value);
        }

        require("../../TeeChart/sources/libTeeChart.php"); 
        
        $chart = new TChart(600,480);
        $chart->getAspect()->setView3D(false);
        $chart->getHeader()->setText("Mean Heart Rate against Age");
        $chart->getLegend()->setVisible(True);
        $baseline = new Line($chart->getChart()); 
        $j=0;
        foreach($b_yVal as $x){
            $baseline->addXY($b_xVal[$j],$b_yVal[$j]);
            $j++;
        }
        $baseline->Setcolor(Color::BLUE()); 
        $baseline->setTitle("Baseline Supine Rest");

        $headtilt = new Line($chart->getChart()); 
        $j=0;
        foreach($h_yVal as $x){
            $headtilt->addXY($h_xVal[$j],$h_yVal[$j]);
            $j++;
        }
        $headtilt->Setcolor(Color::RED()); 
        $headtilt->setTitle("Head-up Tilt Test");

        $suction1 = new Line($chart->getChart()); 
        $j=0;
        foreach($s1_yVal as $x){
            $suction1->addXY($s1_xVal[$j],$s1_yVal[$j]);
            $j++;
        }
        $suction1->Setcolor(Color::GREEN()); 
        $suction1->setTitle("Suction Test Level 1");

        $suction2 = new Line($chart->getChart()); 
        $j=0;
        foreach($s2_yVal as $x){
            $suction2->addXY($s2_xVal[$j],$s2_yVal[$j]);
            $j++;
        }
        $suction2->Setcolor(Color::ORANGE()); 
        $suction2->setTitle("Suction Test Level 2");

        $chart->getLegend()->setCustomPosition(true);
        $chart->getLegend()->setTop(100);
        $chart->getLegend()->setLeft(350);

        $chart->getAxes()->getBottom()->getTitle()->setText("Age (years)"); 
        $chart->getAxes()->getLeft()->getTitle()->setText("Heart Rate (beats/min)"); 
        $chart->getAxes()->getLeft()->setMinMax(70,90);
        $chart->getAxes()->getLeft()->setIncrement(5);
        $chart->getAxes()->getBottom()->setIncrement(5);
        $chart->render('mean-hr.png');

        $b_sd = getSD('Baseline Supine Rest');
        $b_xVal = array();
        $b_yVal = array();
        foreach($b_sd as $key => $value) {
            array_push($b_xVal, $key);
            array_push($b_yVal, $value);
        }

        $h_sd = getSD('Head-up Tilt Test');
        $h_xVal = array();
        $h_yVal = array();
        foreach($h_sd as $key => $value) {
            array_push($h_xVal, $key);
            array_push($h_yVal, $value);
        }

        $s1_sd = getSD('Suction Test: Level 1');
        $s1_xVal = array();
        $s1_yVal = array();
        foreach($s1_sd as $key => $value) {
            array_push($s1_xVal, $key);
            array_push($s1_yVal, $value);
        }
        
        $s2_sd = getSD('Suction Test: Level 2');
        $s2_xVal = array();
        $s2_yVal = array();
        foreach($s2_sd as $key => $value) {
            array_push($s2_xVal, $key);
            array_push($s2_yVal, $value);
        }

        $chart = new TChart(600,480);
        $chart->getAspect()->setView3D(false);
        $chart->getHeader()->setText("Standard Deviation of Heart Rate against Age");
        $chart->getLegend()->setVisible(True);
        $baseline = new Line($chart->getChart()); 
        $j=0;
        foreach($b_yVal as $x){
            $baseline->addXY($b_xVal[$j],$b_yVal[$j]);
            $j++;
        }
        $baseline->Setcolor(Color::BLUE()); 
        $baseline->setTitle("Baseline Supine Rest");

        $headtilt = new Line($chart->getChart()); 
        $j=0;
        foreach($h_yVal as $x){
            $headtilt->addXY($h_xVal[$j],$h_yVal[$j]);
            $j++;
        }
        $headtilt->Setcolor(Color::RED()); 
        $headtilt->setTitle("Head-up Tilt Test");

        $suction1 = new Line($chart->getChart()); 
        $j=0;
        foreach($s1_yVal as $x){
            $suction1->addXY($s1_xVal[$j],$s1_yVal[$j]);
            $j++;
        }
        $suction1->Setcolor(Color::GREEN()); 
        $suction1->setTitle("Suction Test Level 1");

        $suction2 = new Line($chart->getChart()); 
        $j=0;
        foreach($s2_yVal as $x){
            $suction2->addXY($s2_xVal[$j],$s2_yVal[$j]);
            $j++;
        }
        $suction2->Setcolor(Color::ORANGE()); 
        $suction2->setTitle("Suction Test Level 2");

        $chart->getLegend()->setCustomPosition(true);
        $chart->getLegend()->setTop(100);
        $chart->getLegend()->setLeft(350);

        $chart->getAxes()->getBottom()->getTitle()->setText("Age (years)"); 
        $chart->getAxes()->getLeft()->getTitle()->setText("Standard Deviation"); 
        $chart->getAxes()->getLeft()->setMinMax(0,6);
        $chart->getAxes()->getLeft()->setIncrement(1);
        $chart->getAxes()->getBottom()->setIncrement(5);
        $chart->render('sd-hr.png');
    ?>
        <img src='mean-hr.png' style='border: 1px solid gray;'/>
        <img src='sd-hr.png' style='border: 1px solid gray;'/>
    </div>
    <div class=tables>
        <h2>Baseline Supine Rest Summary Tabulated</h2>
        <?php
            tabulateData($b_meanHR, $b_sd);
        ?>
        <h2>Head-up Tilt Test Summary Tabulated</h2>
        <?php
            tabulateData($h_meanHR, $h_sd);
        ?>
        <h2>Suction Test Level 1 Summary Tabulated</h2>
        <?php
            tabulateData($s1_meanHR, $s1_sd);
        ?>
        <h2>Suction Test Level 2 Summary Tabulated</h2>
        <?php
            tabulateData($s2_meanHR, $s2_sd);
        ?>
    </div>
</body>
</html>
