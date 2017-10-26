<!--
<--------------------------------------------\
< Author: Tyler Stoney                       \
< Date of Creation: April 24, 2017           \
< Purpose: Front page of the website.        \
<          <FRONTEND>                        \
<--------------------------------------------\
-->


<?php
//This header should be included on every page;
//  it grabs user data from either the database or
//  their session variable
include_once 'dbconfig.php';
$user_id = $_SESSION['user_session'];
$stmt = $DB_con->prepare("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>

<html>
<head>
    <title>AITP Test</title>
    <link rel="stylesheet" type="text/css" href="stylin.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Slabo+27px" rel="stylesheet">
</head>

<body>
<a href="index.php" title="AITP test - Home"><img style="width:180px;height:45px;" src="/files/logo.png" alt="AITP test - Home"> </a>
<ul>
    <li><a class="current" style="position:relative;top:15px;" href="index.php" title="AITP test - Home"><img src="/files/home.png" alt="AITP test - Home" style="width:30px;height:30px;top:15px;"> </a></li>
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
}else{echo "<br><br>";}
?>

<table>
<tr>
    <th><h2>What We Do</h2></th>
    <th><h2>Who We Are</h2></th>
</tr>
<tr>
    <td><div><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p></td></div>
    <td><div><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p></td></div>

</tr>
</table>
<br>
<h2 align="center">How it works</h2>
<div><p align="center">Section 1.10.33 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC

    "At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat."</p>
</div>
<!--For testing purposes, add Event to database-->
<br><br>
<hr size="2" width="75%" align="center">
<p align="center">Copyright AITPTest.xyz, Tyler Stoney, Lorem Ipsem, 2017-2017. All rights reserved</p>
</body>

</html>
