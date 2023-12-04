<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta name="author" content="Kasper Kripalani">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
   <?php require  "mysqlFunc.php";?>

</head>
<body>
<ul class="TitleBar">
    <li class="titleDiv"><a href="index.php">SWIM WORKOUT GENERATOR</a></li>
    <div class="links">
    <?php if(isset($_SESSION["usrname"])){?>

        <div class="logoutProfileContainer">
        <li class="profile"><a href="profile.php?id=<?=$_SESSION['userid'] ?>">My Profile</a></li>
        <li class="logout"><a href="index.php?logout=true">Log Out</a></li>
    </div>
        <?php }else{?>
            <div class="logRegContainer">
        <li class="login"><a href="login.php">Login</a></li>
        <li class="register"><a href="register.php">Register</a></li>
            </div>
    <?php }?>
            </div>
</ul>


