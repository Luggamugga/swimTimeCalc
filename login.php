<?php include "header.php" ?>
<div class="loginFormDiv">
    <h1 class="loginFormTitle">Login</h1>
<form class="loginForm" method="post">
    <label for="usrname">Username:</label>
    <input type="text" name="usrname">
    <label for="password">Password</label>
    <input type="password" name="password">
    <input type="submit" class="submitButt">
</form>

<?php
    if(isset($_POST["usrname"]))
    {
        if( login($_POST["usrname"],$_POST["password"])){
            login($_POST["usrname"],$_POST["password"]);
            header("Location: logSuccess.php");
            unset($_POST);
        } else {
            echo "</div class='logError' display='block'> Wrong username or password</div>";
            unset($_POST);
        }
    }
?></div>


<?php include "footer.php"?>