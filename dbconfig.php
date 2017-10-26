<?php
/**
 * Created by PhpStorm.
 * User: Tyler
 * Date: 4/26/2017
 * Time: 8:24 PM
 */
session_start();

//These will be changed to match that of our final
//  server once that is ready to be worked on.
//  Obviously not giving out my current credentials
//  for the whole Internet to see.
$DB_host = "host";
$DB_user = "user";
$DB_pass = "password123";
$DB_name = "database";

try
{
    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo $e->getMessage();
}


include_once 'class.user.php';
$user = new USER($DB_con);

?>