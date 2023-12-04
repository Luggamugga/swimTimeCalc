<?php
session_start();

if(isset($_GET["logout"])){
    logout();
    header("Location: index.php");
}
$dbhost = "localhost";
$dbuser = "root";
$dbpasswd = "asdf";
$mysqli = new mysqli($dbhost, $dbuser, $dbpasswd, "swim") or die("Connect failed: %s\n" . $mysqli->error);
if ($mysqli->connect_error) {
    die("Connection failed: " . ($mysqli->connect_error));
}
function register($fName,$lName,$pDesc,$Location,$swimSince,$email,$usrname,$password){
    global $mysqli;
    empty($swimSince) ? $swimSince = "not specified": $swimSince = $swimSince;
    empty($pDesc) ? $pDesc = "not specified": $pDesc = $pDesc;
    empty($Location) ? $Location = "not specified": $Location = $Location;
    $query = sprintf("INSERT INTO user (fName,LName,pDesc,Location,swimSince,email,usrname,password) VALUES('%s','%s','%s','%s','%d','%s','%s','%s')",
    $fName,$lName,$pDesc,$Location,$swimSince,$email,$usrname,$password);
    $mysqli->query($query);
}

function checkUsrExists($usrname){
    global $mysqli;
    $query = sprintf("SELECT * FROM user WHERE usrname='%s'",$usrname);
    $result = $mysqli->query($query);
    $resultRow = mysqli_num_rows($result);
    if($resultRow >= 1){
        return true;
    } else {
       return false;
    }
}
function login($usrname,$password){
    global $mysqli;
    $query = sprintf("SELECT * FROM user WHERE usrname='%s' AND password='%s'",$usrname,$password);
    $result = $mysqli->query($query);
    $numRows = mysqli_num_rows($result);
    $resultrow = mysqli_fetch_assoc($result);
    $userid = $resultrow["id"];
    if($numRows == 1){
        $_SESSION["usrname"] = $usrname;
        $_SESSION["userid"] = $userid;
        return true;
    } else {
        return false;
    }
}
function logout(){
    session_destroy();
}
$resultArray = [];
function getUsrById($userid){
    global $mysqli;
    $query = sprintf("SELECT * FROM USER WHERE id='%d'",$userid);
   $result = $mysqli->query($query);
    return mysqli_fetch_assoc($result);
}
function saveWorkout($arr,$userid)
{
    global $mysqli;
    $query = sprintf("INSERT INTO swimWorkouts (userid,workoutData)
    VALUES('%d','%s')",$userid, $arr);
    $mysqli->query($query);
}

function getWorkoutsByUsrId($userid){
    global $mysqli;
    $query = sprintf("SELECT workoutData FROM swimWorkouts WHERE userid='%s'",$userid);
    $result = $mysqli->query($query);
    return mysqli_fetch_all($result);
}



$strArray = [];
$equArray = [];
$calArray = [];
$timeArray = [];
$distArray = [];
$equArrayFinal  = [];


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
    $maleAvgSpeed200["im"] = 1.43;
    //https://www.researchgate.net/figure/Swimming-speed-of-women-a-d-and-men-e-h-in-100-m-and-200-m-of-the-four-strokes-across_fig1_341756490

    //https://caloriesburnedhq.com/calories-burned-swimming/
    $caloriesperMin["breaststroke"] = 200 / 30;
    $caloriesperMin["backstroke"] = 250 / 30;
    $caloriesperMin["freestyle"] = 300 / 30;
    $caloriesperMin["butterfly"] = 450 / 30;
    $caloriesperMin["im"] = (200 + 250 + 300 + 450) / 4;

    $highestPossibleTimePerDistanceM = $maleAvgSpeed100["freestyle"] / $dist;
    $lowestPossibleTimePerDistanceM = $maleAvgSpeed200["breaststroke"] / $dist;
    $highestPossibleTimePerDistanceF = $femAvgSpeed100["freestyle"] / $dist;
    $lowestPossibleTimePerDistanceF = $femAvgSpeed200["breastroke"] / $dist;

    $pullBoyDiff = -(5 / 50); // s/m SUBTRACT from swimm speed
    $pullBoyTimeDiff = $dist / (50 / 5);
    $kickboardDiff = (50 / 20);
    $finsDiff = -(50 / 5);
    $paddlDiff = (50 / 5);
    $equDiffArray = [];
    $equDiffArray["Pull_Boy"] = $pullBoyDiff;
    $equDiffArray["kickboard"] = $kickboardDiff;
    $equDiffArray["fins"] = $finsDiff;
    $equTimeDIffArray["paddles"] = $paddlDiff;

    $distCount = 0;
    $timeCount = 0;
    $i = 0;
    //while ($calCount <= $cals && $distCount <= $dist && $timeCount <= $time) {

    while ($distCount < $dist) {

        $choiceDist = rand(1, 4) * 50;
        if ($choiceDist + $distCount > $dist) {
            $choiceDist = $dist - $distCount;
        }

        $distArray[$i] = $choiceDist;
        $distCount += $choiceDist;
        $randIndex = array_rand($stroke, 1);
        $choiceStr = $stroke[$randIndex];
        $strArray[$i] = $choiceStr;

        // get rand equipment from equipment list
        if (!empty($equ)) {
            $ind = array_rand($equ, 1);
            $equArray[$i] = $equ[$ind];
            if (rand(0, 2) === 1) {
                $equArrayFinal[$i] = $equArray[$i];
            } else if (count($equArrayFinal) + count($equArray) >= count($distArray) && !in_array($equArray[$i], $equArrayFinal)) {
                $equArrayFinal[$i] = $equArray[$i];
            } else {
                $equArrayFinal[$i] = "";
            }
        }

        if ($choiceDist <= 100) {
            if ($gender == "m") {
                $timeCount += $choiceDist / ($maleAvgSpeed100[$choiceStr]);
                $timeArray[$i] = ($choiceDist / ($maleAvgSpeed100[$choiceStr])) / 60;
            } else {
                $timeCount += $choiceDist / ($femAvgSpeed100[$choiceStr]);
                $timeArray[$i] = ($choiceDist / ($femAvgSpeed100[$choiceStr])) / 60;
            }
        } else {
            if ($gender == "m") {
                $timeCount += $choiceDist / ($maleAvgSpeed200[$choiceStr]);
                $timeArray[$i] = ($choiceDist / ($maleAvgSpeed200[$choiceStr])) / 60;
            } else {
                $timeCount += $choiceDist / ($femAvgSpeed200[$choiceStr]);
                $timeArray[$i] = ($choiceDist / ($femAvgSpeed200[$choiceStr])) / 60;
            }
        }

        // considering equipment and setting equ array:

        //  if($timeCount < $time) {
        /*  if (rand(0, 1) === 1 && $timeArray[$i] + $distArray[$i] / $equDiffArray[$equArray[$i]] / 60 > 0 && !empty($equ)) {
              $timeArray[$i] += $distArray[$i] / $equDiffArray[$equArray[$i]] / 60;
              $timeCount2 += $distArray[$i] / $equDiffArray[$equArray[$i]] / 60;
          } else {
              $equArray[$i] = "/";
          }*/


// calories calculation:
        $caloriesPerRow = $caloriesperMin[$choiceStr] * $timeArray[$i];
        $calArray[$i] = intval($caloriesPerRow);

        $i++;
    }
    //generate result table;
    echo "<form method='post'> <table class='resultTable' id='resultsTab'>";
    echo "<tr><th>Strokes</th><th>Distance(m)</th><th>Time(min)</th><th>Calories(kcal)</th>";
    if (count($equArrayFinal) !== 0) {
        echo "<th>Equipment</th></tr>";
    }
    for ($i = 0; $i < count($strArray); $i++) {
        if (round($timeArray[$i]) < 1) {
            $timeArray[$i] = 0.5;
        } else {
            $timeArray[$i] = round($timeArray[$i]);
        }

        echo "<tr>";
            echo "<th><input type='hidden' name='str".$i."' value='".$strArray[$i]."'>" . $strArray[$i] . "</th>";
        echo "<th><input type='hidden' name='dist".$i."'value='".$distArray[$i]."'>" . $distArray[$i] . "</th>";
        echo "<th><input type='hidden' name='time".$i."'value='".$timeArray[$i]."'>" . $timeArray[$i] . "</th>";
        echo "<th><input type='hidden' name='cal".$i."'value='".$calArray[$i]."'>" . $calArray[$i] . "</th>";
        if (!empty($equArrayFinal[$i])) {
            echo "<th><input type='hidden' name='equ".$i."'value='".$equArrayFinal[$i]."'>" . $equArrayFinal[$i] . "</th>";
        }
        echo "</tr>";
    }
    $timeSum = round(array_sum($timeArray));
    echo "<tr>";
    echo "<th>Sums: </th>";
    echo "<th>" . array_sum($distArray) . "</th>";
    echo "<th>" . $timeSum . "</th>";
    echo "<th>" . array_sum($calArray) . "</th>";
    echo "</tr>";
    echo "</table>";
    if(isset($_SESSION["userid"])){
        echo  "<button type='submit' id='saveButt'>Save</button>";
    }
    echo "</form>";
}
