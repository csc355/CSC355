<!--
<--------------------------------------------\
< Author: Tyler Stoney                       \
< Date of Creation: October 25, 2017         \
< Purpose: Allow officer to search for users \
<          to change their status within the \
<          context of the AITP chapter       \
<          (Non-member, student, etc.)       \
<          <FRONTEND/BACKEND>                \
<--------------------------------------------\
-->

<?php
include_once 'dbconfig.php';
$user_id = $_SESSION['user_session'];
$stmt = $DB_con->prepare("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
$my_id = $userRow['user_id'];

if(!$user->is_loggedin()||$userRow['officer']!=3)
{
    $user->redirect('index.php');
}

?>
<html>
<head>
    <title>Search Users</title>
    <link rel="stylesheet" type="text/css" href="stylin.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Slabo+27px" rel="stylesheet">
    <!--
    Put this stylesheet here rather than the css file since the index page also uses tables
      for stylistic paragraph formatting, so I don't want overlap between the two.
    -->
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 70%;
            margin: auto;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #ddffdd;
        }
        tr:nth-child(odd) {
            background-color: #ffffff;
        }
        table.sortable th:not(.sorttable_sorted):not(.sorttable_sorted_reverse):not(.sorttable_nosort):after {
            content: " \25B4\25BE"
        }
    </style>
</head>
<body>
<!--
The navigation bar.
-->
<a href="index.php" title="AITP test - Home"><img style="width:180px;height:45px;" src="/files/logo.png" alt="AITP test - Home"> </a>
<ul>
    <li><a style="position:relative;top:15px;" href="index.php" title="AITP test - Home"><img src="/files/home.png" alt="AITP test - Home" style="width:30px;height:30px;top:15px;"> </a></li>
    <li><a href="/sign_up.php"><h3>Sign Up</h3></a></li>
    <li><a href="/login.php"><h3>Log In</h3></a></li>
    <li><a href="/register_event.php"><h3>Register for Event</h3></a></li>
    <li><a href="/View_Event_Archives.php"><h3>View Events</h3></a></li>
    <li><a href="/create_event.php"><h3>Add Event</h3></a></li>
    <li><a class="current" href='/search_members.php'><h3>Edit Users' Status</h3></a></li>
</ul>

<?php
    echo "<h3 align='right'>Welcome, " . $userRow['fName'] . "!<br>";
    echo "<a href='logout.php?logout=true\'>logout</a></h3>";
?>

<div class="container">
    <div class="form-container">
        <form method="post">
            <h1>Search User</h1><hr /><br>
            <?php if(isset($error)){echo $error;} ?>
            <div class="form-group">
                <input type="text" class="form-control" name="cred" placeholder="Email address or last name" required />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
                <button type="submit" name="btn-email" class="btn btn-block btn-primary">Search Users
                </button>
            </div>
        </form>

<?php
//A quick and dirty way to make changes appear without the need to create a separate page.
if(isset($_POST['btn-email'])||isset($_POST['btn-change']))
{
    //After the changes are made and the officer hits "submit" or "change" or whatever I named it.
    if(isset($_POST['btn-change']))
    {
        //Grab each result from the user_status[] array created by the dropdown boxes
        foreach ($_POST['user_status'] as $t_value) {

            //Needed a way to pass 2 distinct (and not necessarily sequential)
            // values via one array.  Multiply by 10, add the smaller.
            // E.g. If ID is 47 and selected result (value) is 3, final 'encoded'
            //   value is 473.  Then work backwards to extract them individually.
            $t_id = ($t_value-($t_value%10))/10;
            $t_value = $t_value%10;

            //Update the respective users, provided they are not the stats of the admin currently performing the action.
            $stmt = $DB_con->prepare("UPDATE users SET officer = :val WHERE user_id=:uid AND user_id<>:my_id");
            $stmt->bindParam(":val", $t_value);
            $stmt->bindParam(":uid", $t_id);
            $stmt->bindParam(":my_id", $my_id);
            $stmt->execute();
        }
        echo "<p>User(s) changed successfully!</p>";
    }
    echo "<form method='post'><table>";
    $page = $DB_con->prepare("SELECT user_id, fName, lName, user_email, officer FROM users WHERE lName=:uname OR user_email=:uname");
    $page->bindParam(":uname", $_POST['cred']);
    $page->execute();

    //Grab everything that readily identifies a user. Repeat for as long as the result has unique results.
    while ($row = $page->fetch(PDO::FETCH_ASSOC)){
        $id = $row['user_id'];
        $fName = $row['fName'];
        $lName = $row['lName'];
        $email = $row['user_email'];
        $officer = $row['officer'];
        $value = $id*10; //Prep the value for making that 'encoded' value to schlep through the array post

        //Here's where some crafty php comes into play; each line adds another value to populate a dropdown box,
        //  of which the encoded value (id concatenated with desired value) will be added to an arbitrary place in
        //  the user_status[] array.  This repeats for every user found by the SQL statement.  Then, as a default,
        //  whatever position the user holds will be selected and greyed out.
        echo "<tr>
                <td>" . $lName . ", " . $fName . "</td>
                <td>" . $email . "</td>
                <td>
                    <select name='user_status[]'>
                    <option value=" . ($value+0); if($officer==0)echo " selected disabled"; echo " id=" . $id . ">Non-Member</option>";
        echo       "<option value=" . ($value+1); if($officer==1)echo " selected disabled"; echo " id=" . $id . ">Student</option>";
        echo       "<option value=" . ($value+2); if($officer==2)echo " selected disabled"; echo " id=" . $id . ">Member</option>";
        echo       "<option value=" . ($value+3); if($officer==3)echo " selected disabled"; echo " id=" . $id . ">Officer</option>";

        echo        "</select> </td>
              </tr>";

    }
    echo "</table>";

    //Only display the button to change users' statuses if the button hasn't been pressed yet.
    if(!isset($_POST['btn-change'])) {
        echo "<div class=\"form-group\">
                <button type=\"submit\" name=\"btn-change\">Change Users
                </button>
            </div></form>";
    }
}
?>
    </div>
</div>
<!--
Footer, of sorts.
-->
<br><br>
<hr size="2" width="75%" align="center">
<p align="center">Copyright AITPTest.xyz, Tyler Stoney, Lorem Ipsem, 2017-2017. All rights reserved</p>
</body>
</html>