<?php include "header.php"; ?>
<div class="regisFormDiv">
    <h1 class="regFormTitle">Register A New Account</h1>
    <form id="registerForm" method="post">
        <label for="fName">First Name:</label>
        <input type="text" name="fName" required>
        <label for="lName">Last Name:</label>
        <input type="text" name="lName" required>
        <label for="pDesc">Personal Description:</label>
        <textarea name="pDesc" class="textArea"></textarea>
        <label for="Location">Location:</label>
        <input type="text" name="Location">
        <label for="swimSince">Swimming Since(year):</label>
        <input type="text" name="swimSince" id="swimDate">
        <div id="dateErr">Please choose a valid year</div>
        <label for="email">Email:</label>
        <input type="text" name="email" id="regEmail" required>
        <p id="emailErr">Email not valid!</p>
        <label for="usrname">Username:</label>
        <input type="text" name="usrname" id="usrName" required>
        <?php
        echo "<div id='usrErr' style='display:";
        if (isset($_POST["usrname"]) && checkUsrExists($_POST["usrname"])) {
            echo "block'>";
        } else {
            echo "none'>";
        }
        echo "Username exists</div>";

        ?>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <input type="submit" class="submitButt">
    </form>
</div>
<script src="regFormCheck.js"></script>
<?php




if (isset($_POST["password"])) {
    if (!checkUsrExists($_POST["usrname"])) {
            register($_POST["fName"], $_POST["lName"], $_POST["pDesc"], $_POST["Location"], $_POST["swimSince"],$_POST["email"], $_POST["usrname"], $_POST["password"]);
        header("Location: regSuccess.php");
    } else {
        unset($_POST["usrname"]);
    }
}
?>

<?php include "footer.php" ?>
