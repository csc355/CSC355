<?php
/**
 * Created by PhpStorm.
 * User: Tyler
 * Date: 4/26/2017
 * Time: 9:16 PM
 */
 session_start();
 if (!isset($_SESSION['user_session'])) {
     header("Location: index.php");
 } else if(isset($_SESSION['user_session'])!="") {
     header("Location: index.php");
 }

 if (isset($_GET['logout'])) {
     unset($_SESSION['user_session']);
     session_unset();
     session_destroy();
     header("Location: index.php");
     exit;
 }