<?php include "header.php"?>
<div class="successDiv">
    <div class="successHead">You've succesfully logged in as: <?= $_SESSION["usrname"]?></div>
    <div class="successNav">
        <a href="index.php">Home</a>
    </div>
</div>

<?php include "footer.php"?>
