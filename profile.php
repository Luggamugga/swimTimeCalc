<?php
include "header.php";

if (!isset($_GET["id"])) {
    header("Location: index.php");
}
$userArray = getUsrById($_GET["id"])
?>
<div class="profContainer">
    <div class="titleDiv"><?= $userArray["usrname"] ?>'s Profile</div>
    <div class="profInfo">
        <div class="fNameDiv"><b>First Name:</b> <?= $userArray["fName"] ?></div>
        <div class="lNameDiv"><b>Last Name:</b> <?= $userArray["LName"] ?></div>
        <div class="usrNameDiv"><b>Username:</b> <?= $userArray["usrname"] ?></div>
        <?php if (isset($_SESSION["userid"])): ?>
            <div class="emailDiv"><b>Your Email (not shown on public Profile):</b> <?= $userArray["email"] ?></div>
        <?php endif; ?>
        <div class="pDescDiv"><b>Personal Description:</b></div>
        <textarea class="pDescText" readonly><?= $userArray["pDesc"] ?></textarea>
        <div class="LocationDiv"><b>Location:</b> <?= $userArray["Location"] ?></div>
        <div class="swimSinceDiv">
            <b>Swimming
                Since:</b> <?php echo($userArray["swimSince"] == 0 ? "not specified" : $userArray["swimSince"]); ?>
        </div>
    </div>
</div>

<?php if(empty(getWorkoutsByUsrId($_GET["id"]))){?>
    <div class="note">Nothing here yet...</div>
<?php } else { ?>
    <button class="showWorkouts" id="showButt">Show Workouts</button>

<div class="swimWorkouts" id="tables" >
    <?php
    $workouts = getWorkoutsByUsrId($_GET["id"]);
    for($i = 0; $i < count($workouts);$i++){
        $workoutData = json_decode($workouts[$i][0],true);
        echo "<table class='resultTable' id='resultsTab'>";
        echo "<tr><th>Strokes</th><th>Distance(m)</th><th>Time(min)</th><th>Calories(kcal)</th>";
        for($j =0;$j<count($workoutData["cal"]);$j++){
            if(round($workoutData["time"][$j])<1){
                $workoutData["time"][$j] = 0.5;
            } else {
                $workoutData["time"][$j] = round($workoutData["time"][$j]);
            }

            echo "<tr>";
            echo "<th>".$workoutData["str"][$j]."</th>";
            echo "<th>".$workoutData["dist"][$j]."</th>";
            echo "<th>".$workoutData["time"][$j]."</th>";
            echo "<th>".$workoutData["cal"][$j]."</th>";
            if(!empty($workoutData["equ"][$j])){
                echo "<th>".$workoutData["equ"][$j]."</th>";
            }
            echo "</tr>";
        }
        echo "<tr>";
        echo "<th>Sums: </th>";
        echo "<th>".array_sum($workoutData["dist"])."</th>";
        echo "<th>".array_sum($workoutData["time"])."</th>";
        echo "<th>".array_sum($workoutData["cal"])."</th>";
        echo "</tr>";
        echo "</table>";
    }


    ?>


</div>
<?php }?>
<script src="profFunc.js"></script>
<?php include "footer.php" ?>
