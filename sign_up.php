<!--
<--------------------------------------------\
< Author: Tyler Stoney                       \
< Date of Creation: October 25, 2017         \
< Purpose: Allow person to register account  \
<          with the site.                    \
<          <FRONTEND/BACKEND>                \
<--------------------------------------------\
-->
<?php

require_once 'dbconfig.php';
$user_id = $_SESSION['user_session'];
$stmt = $DB_con->prepare("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['btn-signup']))
{
    $uname = trim($_POST['txt_uname']);
    $umail = trim($_POST['txt_umail']);
    $upass = trim($_POST['txt_upass']);
    $fName = trim($_POST['txt_fname']);
    $lName = trim($_POST['txt_lname']);

    if($uname=="") {
        $error[] = "Username can't be left blank!";
    }
    else if($umail=="") {
        $error[] = "Email can't be left blank!";
    }
    else if(!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Please enter a valid email address !';
    }
    else if($upass=="") {
        $error[] = "provide password !";
    }
    else if(strlen($upass) < 6){
        $error[] = "Password must be at least 6 characters";
    }
    else if($upass!=$_POST['txt_upassDup']){
        $error[] = "Passwords don't match";
    }
    else if($fName=="") {
        $error[] = "First name field can'd be left blank!";
    }
    else if($lName=="") {
        $error[] = "Last name field can't be left blank!";
    }
    else
    {
        try
        {
            $stmt = $DB_con->prepare("SELECT user_name,user_email FROM users WHERE user_name=:uname OR user_email=:umail");
            $stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);

            if($row['user_name']==$uname) {
                $error[] = "Username already taken!";
            }
            else if($row['user_email']==$umail) {
                $error[] = "Email address already in use";
            }
            else
            {
                if($user->register($fName,$lName,$uname,$umail,$upass))
                {
                    $user->redirect('sign_up.php?joined');
                }
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sign up</title>
    <link href="https://fonts.googleapis.com/css?family=Lato|Slabo+27px" rel="stylesheet">
    <link rel="stylesheet" href="stylin.css" type="text/css"  />
</head>
<body>
<a href="index.php" title="AITP test - Home"><img style="width:180px;height:45px;" src="/files/logo.png" alt="AITP test - Home"> </a>
<ul>
    <li><a style="position:relative;top:15px;" href="index.php" title="AITP test - Home"><img src="/files/home.png" alt="AITP test - Home" style="width:30px;height:30px;top:15px;"> </a></li>
    <li><a class="current" href="/sign_up.php"><h3>Sign Up</h3></a></li>
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
}else{echo "<br><br>";}
?>
<div class="container">
    <div class="form-container">
        <form method="post">
            <h1>Sign up.</h1><hr />
            <?php
            if(isset($error))
            {
                foreach($error as $error) { echo $error; }
            }
            else if(isset($_GET['joined']))
            {
                ?>
                <div class="alert alert-info">
                    <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='login.php'>login</a> here
                </div>
                <?php //Well, at least it wasn't called as an $error. bleh
            }
            ?>
            <div class="form-group">
                <input type="text" class="form-control" name="txt_uname" placeholder="Enter Username" value="<?php if(isset($error)){echo $uname;}?>" />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="txt_umail" placeholder="Enter E-Mail ID" value="<?php if(isset($error)){echo $umail;}?>" />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="txt_upass" placeholder="Enter Password" />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="txt_upassDup" placeholder="Repeat Password" />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="txt_fname" placeholder="First Name" />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="txt_lname" placeholder="Last Name" />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary" name="btn-signup">
                    <i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP
                </button>
            </div>
            <br />
            <label>Already have an account? <a href="login.php">Sign In</a></label>
        </form>
    </div>
</div>

<br><br>
<hr size="2" width="75%" align="center">
<p align="center">Copyright AITPTest.xyz, Tyler Stoney, Lorem Ipsem, 2017-2017. All rights reserved</p>
</body>
</html>