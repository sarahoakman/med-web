<?php
    require_once("../../TeeChart/sources/libTeeChart.php"); 
        // get the y values
        $yVal = explode(' ', $ecg_data);
        $k = 0;
        foreach($yVal as $v) {
            $yVal[$k] = floatval($v);
            
            $k++;
        }
        $j = 0;
        // get the x values 
        $xVal = array();
        while ($j < $k) {
            array_push($xVal, $j/50);
            $j++;
        }
        // make the graph
        $count = 0;
        $pngTitle = 'ecg'.$_SESSION["aid"].'.png';
        $chart1 = new TChart(600,480);
        $chart1->getAspect()->setView3D(false);
        $chart1->getHeader()->setText("ECG Data collected on $date");
        $chart1->getLegend()->setVisible(FALSE);
        $varname = new Line($chart1->getChart()); 
        
        $j=0;
        foreach($yVal as $x){
            $varname->addXY($xVal[$j],$yVal[$j]);
            $j++;
        }
        
        $varname->Setcolor(Color::BLUE()); 
        $chart1->getAxes()->getBottom()->getTitle()->setText("Time (s)"); 
        $chart1->getAxes()->getLeft()->getTitle()->setText("Voltage (mV)"); 
        $chart1->getAxes()->getLeft()->setIncrement(1);
        $chart1->getAxes()->getBottom()->setIncrement(1);
        $chart1->render($pngTitle);	
    //Set up chart
    echo "<img src='$pngTitle'/>";
?>