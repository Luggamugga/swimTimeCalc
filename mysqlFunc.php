<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpasswd = "lucaminer3";
$mysqli = new mysqli($dbhost, $dbuser, $dbpasswd, "mydb") or die("Connect failed: %s\n" . $mysqli->error);

function generateWorkout($dist, $time, $equ, $stroke, $gender)
{
    //TODO: limiter für die options machen bei index.php, wenn man eine bestimmte zeit eingibt limitiert es die range von distance und calories
    //TODO: Calories weglassen und dann limiter einbauen und calories am ende generaten
    //male highest possible for time:
    //100m
    $femAvgSpeed100["freestyle"] = 1.5;//m/s
    $femAvgSpeed100["butterfly"] = 1.4;//m/s
    $femAvgSpeed100["backstroke"] = 1.3;//m/s
    $femAvgSpeed100["breaststroke"] = 1.2;//m/s
    $femAvgSpeed100["im"] = 1.35;
    //200m
    $femAvgSpeed200["freestyle"] = 1.45;//m/s
    $femAvgSpeed200["butterfly"] = 1.3;//m/s
    $femAvgSpeed200["backstroke"] = 1.2;//m/s
    $femAvgSpeed200["breastroke"] = 1.1;//m/s
    $femAvgSpeed200["im"] = 1.31;
    //male
    //100m
    $maleAvgSpeed100["freestyle"] = 1.7;
    $maleAvgSpeed100["butterfly"] = 1.6;
    $maleAvgSpeed100["backstroke"] = 1.5;
    $maleAvgSpeed100["breaststroke"] = 1.4;
    $maleAvgSpeed100["im"] = 1.53;
    //200m
    $maleAvgSpeed200["freestyle"] = 1.55;
    $maleAvgSpeed200["butterfly"] = 1.45;
    $maleAvgSpeed200["backstroke"] = 1.4;
    $maleAvgSpeed200["breaststroke"] = 1.3;
    $maleAvgSpeed200["im"] =1.43;
    //https://www.researchgate.net/figure/Swimming-speed-of-women-a-d-and-men-e-h-in-100-m-and-200-m-of-the-four-strokes-across_fig1_341756490

    //https://caloriesburnedhq.com/calories-burned-swimming/
    $caloriesperMin["breaststroke"] = 200 / 30;
    $caloriesperMin["backstroke"] = 250 / 30;
    $caloriesperMin["freestyle"] = 300 / 30;
    $caloriesperMin["butterfly"] = 450 / 30;
    $caloriesperMin["im"] = (200 + 250 + 300 + 450) / 4;

        $highestPossibleTimePerDistanceM = $maleAvgSpeed100["freestyle"]/$dist;
        $lowestPossibleTimePerDistanceM = $maleAvgSpeed200["breaststroke"]/$dist;
        $highestPossibleTimePerDistanceF = $femAvgSpeed100["freestyle"]/$dist;
        $lowestPossibleTimePerDistanceF = $femAvgSpeed200["breastroke"]/$dist;

    $pullBoyDiff = -(5 / 50); // s/m SUBTRACT from swimm speed
    $pullBoyTimeDiff = $dist/(50/5);
    $kickboardDiff =-( 20 / 50); // subtract
    $finsDiff = 5 / 50; // Add to swim speed
    $paddlDiff = -(5 / 50); // Subtract
    $calCount = 0;
    $distCount = 0;
    $timeCount = 0;
    $equArray = [];
    $distArray = [];
    $calArray = [];
    $timeArray = [];
    $strArray = [];
    $i = 0;
    //while ($calCount <= $cals && $distCount <= $dist && $timeCount <= $time) {
      while($distCount < $dist){
        $speed = $dist / $time;
        $choiceDist = rand(1, 4) * 50;

        if($choiceDist+$distCount > $dist){
            $choiceDist = $dist - $distCount;
        }
        echo "dist:".$choiceDist;
        echo "<br>";
        $distArray[$i] = $choiceDist;
        $distCount += $choiceDist;
        $randIndex = array_rand($stroke, 1);
        $choiceStr = $stroke[$randIndex];
        $strArray[$i] = $choiceStr;
        echo "str:" . $choiceStr;
        echo "<br>";
        if ($choiceDist <= 100) {
            if ($gender = "m") {
                $timeCount += $choiceDist / ($maleAvgSpeed100[$choiceStr]);
               // echo memory_get_usage(true);
                $timeArray[$i] = ($choiceDist / ($maleAvgSpeed100[$choiceStr]))/60;
            } else {
                $timeCount += $choiceDist / ($femAvgSpeed100[$choiceStr]);
                $timeArray[$i] = ($choiceDist / ($femAvgSpeed100[$choiceStr]))/60;
            }
        } else {
            if ($gender = "m") {
                $timeCount += $choiceDist / ($maleAvgSpeed200[$choiceStr]);
                $timeArray[$i] = ($choiceDist / ($maleAvgSpeed200[$choiceStr]))/60;
            } else {
                $timeCount += $choiceDist / ($femAvgSpeed200[$choiceStr]);
                $timeArray[$i] = ($choiceDist / ($femAvgSpeed200[$choiceStr]))/60;
            }
        }
        echo "time:".$timeArray[$i];
        echo "<br>";
        $caloriesPerRow = $caloriesperMin[$choiceStr]*$timeArray[$i];
        $calArray[$i] = intval($caloriesPerRow);
        echo "cals:".$calArray[$i];
        echo "<br>";
        $i++;
    }

    $resultArray = array(
        $distArray,
        $timeArray,
        $calArray,
        $strArray,
    );
    //print_r($resultArray);
    echo "Sum of dist" . array_sum($distArray);
    echo "Sum of time" . array_sum($timeArray);
    echo "Sum of cal" . array_sum($calArray);

}


