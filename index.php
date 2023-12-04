<?php include "header.php"; ?>
<div class="formDiv">
    <form method="post" class="form" id="indexForm">
        <div class="multChoiceTitle">Choose Gender:</div>
        <select id="genderSelector" name="gender" required>
            <option value="m">Male</option>
            <option value="f">Female</option>
        </select>
        <label for="distance">I want to swim:</label>
        <select id="distSelect" size="5" name="distance" class="selector" onchange="timeLimiter()" required>

        </select>
        <div class="multChoiceTitle">I have the following equipment</div>
        <div class="multChoice" id="equMultChoice" onchange="timeLimiter()">
            <input type="checkbox" name="equ0" value="Pull_Boy" class="equCheck">
            <label for="equ1">Pull Boy</label>
            <input type="checkbox" name="equ1" value="fins" class="equCheck">
            <label for="equ2">Fins</label>
            <input type="checkbox" name="equ2" value="kickboard" class="equCheck">
            <label for="equ3">Kickboard</label>
            <input type="checkbox" name="equ3" value="paddles" class="equCheck">
            <label for="paddles">Paddles</label>
        </div>
        <div class="multChoiceTitle">I want to swim the following strokes:</div>
        <div class="multChoice" onchange="timeLimiterStr()" id="strChoice">
            <input type="checkbox" value="breaststroke" name="str1" class="strCheck">
            <label for="str1">Breaststroke</label>
            <input type="checkbox" value="freestyle" name="str2" class="strCheck">
            <label for="str2">Freestyle</label>
            <input type="checkbox" value="backstroke" name="str3" class="strCheck">
            <label for="str3">Backstroke</label>
            <input type="checkbox" value="butterfly" name="str4" class="strCheck">
            <label for="str4">Butterfly</label>
            <input type="checkbox" value="im" name="str5" class="strCheck">
            <label for="str5">IM</label>
        </div>
        <label for="swimTime">I want to swim for:</label>
        <select size="5" name="swimTime" class="selector" id="swimTime" required>

        </select>
        <div class="buttons">
            <input type="submit" value="Generate">
            <input type="reset">
        </div>
    </form>
    <?php
    if (isset($_POST["gender"])) {
        $equArray = [];
        $strArray = [];
        for ($i = 0; $i < 5; $i++) {
            if (isset($_POST["equ" . $i])) {
                $equArray[$i] = $_POST["equ" . $i];
            }

        }
        for ($i = 0; $i < 6; $i++) {
            if (isset($_POST["str" . $i])) {
                $strArray[$i - 1] = $_POST["str" . $i];
            }
        }
    }
    ?>
</div>
<?php if (isset($_POST["distance"])): ?>
    <div class="resultsDiv">
        <?php generateWorkout($_POST["distance"], $_POST["swimTime"], $equArray, $strArray, $_POST["gender"]); ?>

    </div>
    <button type="button" id="resetButt"><a href="index.php">Reset</a>
    </button>
<?php endif; ?>
    <?php if (isset($_SESSION["userid"]) && isset($_POST["str0"])) {
      //  print_r($_POST);
        $count = 0;
        $finalArray = [];
        while(isset($_POST["str".$count])){
            $finalArray["str"][$count] = $_POST["str".$count];
            $finalArray["dist"][$count] = $_POST["dist".$count];
            $finalArray["time"][$count] = $_POST["time".$count];
            $finalArray["cal"][$count] = $_POST["cal".$count];
            $count++;
        }

        for($i = 0; $i<$count;$i++) {
            if (isset($_POST["equ" . $i]))
                $finalArray["equ"][$i] = $_POST["equ" . $i];
        }
        $jsonArr = json_encode($finalArray);
    saveWorkout($jsonArr, $_SESSION["userid"]);
    header("Location: saveSuccess.php");
    }?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="script.js"></script>


<?php include "footer.php" ?>


