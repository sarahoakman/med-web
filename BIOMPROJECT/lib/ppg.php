<?php
require_once("../../TeeChart/sources/libTeeChart.php"); 
    $yVal = explode(' ', $ppg_data);
    
    $k = 0;
    foreach($yVal as $v) {
        $yVal[$k] = intval($v);
        $k++;
    }
    $j = 0;
    $xVal = array();
    while ($j < $k) {
        array_push($xVal, $j/50);
        $j++;
    }

    $pngTitle = 'ppg'.$_SESSION["aid"].'.png';
    $chart1 = new TChart(600,480);
    $chart1->getAspect()->setView3D(false);
    $chart1->getHeader()->setText("PPG Data collected on $date");
    $chart1->getLegend()->setVisible(FALSE);
    $varname = new Line($chart1->getChart()); 
    
    $j=0;
    foreach($yVal as $x){
        $varname->addXY($xVal[$j],$yVal[$j]);
        $j++;
    }
    
    $varname->Setcolor(Color::GREEN()); 
    $chart1->getAxes()->getBottom()->getTitle()->setText("Time (s)"); 
    $chart1->getAxes()->getLeft()->getTitle()->setText("PPG (10 bit offset binary (0-4095))"); 
    $chart1->getAxes()->getLeft()->setIncrement(100);
    $chart1->getAxes()->getBottom()->setIncrement(1);
    $chart1->render($pngTitle);	
//Set up chart
echo "<img src='$pngTitle'/>";
?>