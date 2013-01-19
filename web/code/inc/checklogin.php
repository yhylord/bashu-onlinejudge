<?php
define('REQUIRE_AUTH',1);

define('DISALLOW_GOOGLEBOT',0);

session_start();
if(!isset($_SESSION['user']) && (DISALLOW_GOOGLEBOT || FALSE===strstr($_SERVER['HTTP_USER_AGENT'],'Googlebot'))){
  require_once 'inc/cookie.php';
  if(!check_cookie()) {
    if(REQUIRE_AUTH) {
      header("location: auth.php");
      exit;
    }
  }
}
