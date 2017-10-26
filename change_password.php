<!--
<--------------------------------------------\
< Author: Tyler Stoney                       \
< Date of Creation: October 25, 2017         \
< Purpose: Allow users to change password    \
<          <FRONTEND/BACKEND>                \
<--------------------------------------------\
-->
<?php
require_once 'dbconfig.php';
$user_id = $_SESSION['user_session'];
$stmt = $DB_con->prepare("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

if(!$user->is_loggedin())
{
    $user->redirect('index.php');
}

$uid = $userRow['user_id']; //Save this for use in Pfromm-proofing my code

//Upon pushing the button...
if(isset($_POST['btn-pass']))
{
    //Grab the data entered in the fields
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password_1'];

    //Simple error checking and consistency
    if(strlen($new_pass) < 6){
        $error[] = "Password must be at least 6 characters";
    }
    //Make sure they match
    else if($new_pass!=$_POST['new_password_2']) {
        $error[] = "Passwords don't match.";
    }
    else {//If everything is good, then go ahead with the rest
        try {
            //Grab the user's info
            $stmt = $DB_con->prepare("SELECT * FROM users WHERE user_id=:uid");
            $stmt->execute(array(':uid' => $uid));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

            //If the user exists, make sure his old password is correct.
            //  Don't want any ne'er-do-wells tryin' to change other people's
            //  passwords all willy-nilly, now, do we?
            if ($stmt->rowCount() > 0) {
                if (password_verify($old_pass, $userRow['user_pass'])) {
                    if($user->change_password($uid, $new_pass)){

                        //I REALLY hate myself for abusing the $error message system
                        //  I am become a meme, may God have mercy on my soul
                        $error[]="Password changed successfully";
                    }
                    else{$error[]="You probably shouldn't ever see this, sending our monkeys to fix it; refresh the page and try again.";}
                } else {
                    $error[] = "Wrong Password";
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
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
<a href="index.php" title="AITP test - Change Password"><img style="width:180px;height:45px;" src="/files/logo.png" alt="AITP test - Home"> </a>
<ul>
    <li><a style="position:relative;top:15px;" href="index.php" title="AITP test - Home"><img src="/files/home.png" alt="AITP test - Home" style="width:30px;height:30px;top:15px;"> </a></li>
    <li><a href="/sign_up.php"><h3>Sign Up</h3></a></li>
    <li><a href="/login.php"><h3>Log In</h3></a></li>
    <li><a href="/register_event.php"><h3>Register for Event</h3></a></li>
    <li><a href="/View_Event_Archives.php"><h3>View Events</h3></a></li>
    <?php
    if($userRow['officer']==3) {
        echo("<li><a href=\"/create_event.php\"><h3>Add Event</h3></a></li>");
        echo "<li><a href='/search_members.php'><h3>Edit Users' Status</h3></a></li>";
    }
    ?>

</ul>
<?php
if($user->is_loggedin())
{
    echo "<h3 align='right'>Welcome, " . $userRow['fName'] . "!<br>";
    echo "<a href='logout.php?logout=true\'>logout</a></h3>";
}
else{echo "<br>";}
?>
<br>
<div class="container">
    <div class="form-container">
        <form method="post">
            <h2>Change Password</h2><hr />
            <?php
            if(isset($error))
            {
                foreach($error as $error)
                {
                    ?>
                    <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="form-group">
                <input type="password" class="form-control" name="old_password" placeholder="Old Password" required />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="new_password_1" placeholder="New Password" required />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="new_password_2" placeholder="New Password (again)" required />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
                <button type="submit" name="btn-pass" class="btn btn-block btn-primary">Change Password
                </button>
            </div>
        </form>
    </div>
</div>
<br><br>
<hr size="2" width="75%" align="center">
<p align="center">Copyright AITPTest.xyz, Tyler Stoney, Lorem Ipsem, 2017-2017. All rights reserved</p>
</body>
</html>

