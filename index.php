<?php include "header.php";
?>
<div class="formDiv">
    <form method="post" class="form">
        <div class="multChoiceTitle">Choose Gender:</div>
        <select id="genderSelector" required>
            <option value="m">Male</option>
            <option value="f">Female</option>
        </select>
        <label for="distance">I want to swim:</label>

        <select id="distSelect" size="5" name="distance" class="selector" onchange="timeLimiter()" required>

        </select>
        <label for="swimTime">I want to swim for:</label>
        <select size="5" name="swimTime" class="selector" id="swimTime" required>

        </select>
        <div class="multChoiceTitle">I have the following equipment</div>
        <div class="multChoice" id="equMultChoice" onchange="timeLimiter()">
            <input type="checkbox" value="Pull_Boy" name="equ1" class="equCheck">
            <label for="equ1">Pull Boy</label>
            <input type="checkbox" value="fins" name="equ2" class="equCheck">
            <label for="equ2">Fins</label>
            <input type="checkbox" name="euq3" value="kickboard" class="equCheck">
            <label for="equ3">Kickboard</label>
            <input type="checkbox" name="equ4" value="paddles" class="equCheck">
            <label for="paddles">Paddles</label>
        </div>
        <div class="multChoiceTitle">I want to swim the following strokes:</div>
        <div class="multChoice">
            <input type="checkbox" value="breaststroke" name="str1">
            <label for="str1">Breaststroke</label>
            <input type="checkbox" value="freestyle" name="str2">
            <label for="str2">Freestyle</label>
            <input type="checkbox" value="backstroke" name="str3">
            <label for="str3">Backstroke</label>
            <input type="checkbox" value="butterfly" name="str4">
            <label for="str4">Butterfly</label>
            <input type="checkbox" value="im" name="str5">
            <label for="str5">IM</label>
        </div>
        <div class="buttons">
            <input type="submit" value="Generate">
            <input type="reset">
        </div>
    </form>
    <?php
    if (isset($_POST)) {
        $equArray = [];
        $strArray = [];
        for ($i = 1; $i < 4; $i++) {
            if (isset($_POST["equ" . $i])) {
                $equArray[$i] = $_POST["equ" . $i];
            }
        }
        if (isset($_POST["str5"])) {
            $strArray[0] = $_POST["str5"];
        } else {
            for ($i = 1; $i < 6; $i++) {
                if (isset($_POST["str" . $i])) {

                    $strArray[$i] = $_POST["str" . $i];
                }
            }
        }
        //print_r($strArray);
        $arr = array_rand($strArray, 1);
        echo $strArray[$arr];

        generateWorkout($_POST["distance"], $_POST["calories"], $_POST["swimTime"], $equArray, $strArray, $_POST["gender"]);
    }
    ?>
</div>


<?php include "footer.php" ?>


