<!--
<--------------------------------------------\
< Author: Tyler Stoney                       \
< Date of Creation: October 25, 2017         \
< Purpose: Allow user to request a temporary \
<          password in case they forget      \
<          their current one; temp password  \
<          is sent to the email they specify \
<          <FRONTEND/BACKEND>                \
<--------------------------------------------\
-->

<?php
require_once 'dbconfig.php';
$user_id = $_SESSION['user_session'];
$stmt = $DB_con->prepare("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

if($user->is_loggedin())
{
    $user->redirect('index.php');
}

if(isset($_POST['btn-email']))
{

    //Quick and dirty way to make a random string. Thanks, StackOverflow, IOU1 fam,
    //  you saved me like 5 minutes of typing
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 5; $i++) { //I make the password 5 characters exactly for another hacky and
                                 //  cheap trick, explained in more detail in the login page.
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    //grab email from the user's stat
    $umail = $_POST['umail'];
    try { //Attempt to pull the user associated with that email
        $stmt = $DB_con->prepare("SELECT * FROM `users` WHERE `user_email`=:umail");
        $stmt->execute(array(":umail" => $umail));
        $uRow = $stmt->fetch(PDO::FETCH_ASSOC);

        //hash the temp password to prep it for storage
        $new_pass = password_hash($randomString, PASSWORD_DEFAULT);

        //store the password
        $stmt = $DB_con->prepare("UPDATE users
                                    SET user_pass = :upass
                                    WHERE user_email=:umail");
        $stmt->bindparam(":upass", $new_pass);
        $stmt->bindparam(":umail", $umail);
        $stmt->execute();

        //send an email notifying the user of the change.
        //  Obviously, it won't actually send, nor will it save a password
        //  if the email is wrong, since it won't actually find something there.
        $to = $umail;
        $subject = 'AITPTest - Password Change Request';
        $message = "Your temporary password is: \n"
            . $randomString
            . "\nPlease log in with this password to change your password\n"
            . " as soon as possible.";
        $headers = 'From: do-not-respond@phamspam.com' . "\r\n" .
            'Reply-To: pleasedont@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
        $error="Email Sent to " . $umail; //I hate myself for abusing the $error message system, but it works. :(
    } catch (PDOException $e) {
        echo $e->getMessage();
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
</ul>
<br>
<br>
<div class="container">
    <div class="form-container">
        <form method="post">
            <h2>Change Password</h2><hr />
            <?php
            if(isset($error))
            {
                ?>
                <div class="alert alert-danger">
                    <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                </div>
                <?php
            }
            ?>
            <div class="form-group">
                <input type="text" class="form-control" name="umail" placeholder="Email address" required />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
                <button type="submit" name="btn-email" class="btn btn-block btn-primary">Send Password Link
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
