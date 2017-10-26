<!--
<--------------------------------------------\
< Author: Tyler Stoney                       \
< Date of Creation: April 26, 2017           \
< Purpose: Let registered user log in.       \
<          <FRONTEND>                \
<--------------------------------------------\
-->
<?php

require_once 'dbconfig.php';

$blocked = False;//Not IP banned... yet

$result = $DB_con->prepare("DELETE FROM `locked` WHERE `timestamp` < (now()- interval 10 minute)");
$result->execute();

$ip = $_SERVER["REMOTE_ADDR"];
$result = $DB_con->prepare("SELECT COUNT(*) FROM `locked` WHERE `address` LIKE :ip AND `timestamp` > (now() - interval 10 minute)");
$result->execute(array(":ip"=>$ip));
$count=$result->fetch(PDO::FETCH_NUM);

//Count amount of attempts performed by user, block them if they
//  try too many times
if($count[0] > 3){
    $error = "You are allowed 3 attempts in 10 minutes";
    $blocked = True;
}

//Check for 10 minutes to have passed

if($user->is_loggedin()!="")
{
    $user->redirect('index.php'); //Hey look
}

//Once the login button has been pressed
if(isset($_POST['btn-login']))
{

    //Grab the user's inputted data
    $uname = $_POST['txt_uname_email']; //One size fits all
    $upass = $_POST['txt_password'];

    //aaand log 'em in
    if($user->login($uname,$upass))
    {
        //if successful log in, delete all records of shifty activity from the IP address
        //  so you don't get immediately blocked next time you forget your password.
        $result = $DB_con->prepare("DELETE FROM `locked` WHERE `address` LIKE :ip");
        $result->execute(array(":ip"=>$ip));

        //Ok I promised an explanation so here it is:
        //  When you sign up for the site, the min password length
        //  (enforced by the site) is 6 characters.  By forcing the
        //  temp password in the forgot password section to be an
        //  impossible length of 5 characters, I can perform a simple
        //  check to see whether the password is the temporarily-
        //  assigned one or not.  Hacky code at its best and brightest;
        //  Nyce job, Brendon!
        if(strlen($upass) == 5){
            //Once it is detected that you logged in with a temp password,
            //  immediately send user to the change password station.
            $user->redirect('change_password.php');
        }
        else{$user->redirect('index.php');}
    }
    else
    {
        $error = "Invalid credentials, try again.";
        if($count[0]>=1)//If user forgets password too frequently in a row,
            $error .= "<br><a href=\"forgot_password.php\"><i>(Forgot Password?)</i></a>"; //  offer a nice egg in this trying time.
        //Regardless of reason, store person's IP into database to be able to block them in case they're a master hacker who hang glides
        $stmt = $DB_con->prepare("INSERT INTO `locked` (`address` ,`timestamp`)VALUES (:ip,CURRENT_TIMESTAMP)");
        $stmt->execute(array(":ip"=>$ip));

    }
}
?>

<!--<!DOCTYPE html>-->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Lato|Slabo+27px" rel="stylesheet">
    <link rel="stylesheet" href="stylin.css" type="text/css"  />
</head>
<body>
<a href="index.php" title="AITP test - Home"><img style="width:180px;height:45px;" src="/files/logo.png" alt="AITP test - Home"> </a>
<ul>
    <li><a style="position:relative;top:15px;" href="index.php" title="AITP test - Home"><img src="/files/home.png" alt="AITP test - Home" style="width:30px;height:30px;top:15px;"> </a></li>
    <li><a href="/sign_up.php"><h3>Sign Up</h3></a></li>
    <li><a class="current" href="/login.php"><h3>Log In</h3></a></li>
    <li><a href="/register_event.php"><h3>Register for Event</h3></a></li>
    <li><a href="/View_Event_Archives.php"><h3>View Events</h3></a></li>
    <?php
    if($userRow['officer']==3) {
        echo("<li><a href=\"/create_event.php\"><h3>Add Event</h3></a></li>");
        echo "<li><a href='/search_members.php'><h3>Edit Users' Status</h3></a></li>";
    }
    ?>

</ul>
<br><br>
<div class="container">
    <div class="form-container">
        <form method="post">
            <h2>Sign in.</h2><hr />
            <?php if(isset($error)) {echo $error;} ?>
            <div class="form-group">
                <input type="text"  name="txt_uname_email" placeholder="Username or E mail ID" required />
            </div>
            <div class="form-group">
                <input type="password" name="txt_password" placeholder="Your Password" required />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
            <?php
                if($blocked){//If user is blocked from overextending their ability to fail to log in, disable the
                             // log-in button totally.  Not the solution, just makes things look nice.
                    echo "<button type=\"submit\" disabled name=\"btn-login\" class=\"btn btn-block btn-primary\">";
                }
                //else just print out the regular damn button
                else
                    echo "<button type=\"submit\" name=\"btn-login\" class=\"btn btn-block btn-primary\">";
            ?>
                    <i class="glyphicon glyphicon-log-in"></i> SIGN IN
                </button>
            </div>
            <br />
            <label><a href="forgot_password.php">Forgot Password?</a></label><!--For the amnesiacs-->
            <br>
            <label>Don't have account yet ! <a href="sign_up.php">Sign Up</a></label><!--For the uninitiated-->
        </form>
    </div>
</div>

</body>
</html>
