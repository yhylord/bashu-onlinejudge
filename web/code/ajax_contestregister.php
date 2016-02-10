<?php
require_once 'inc/database.php';

//TODO Fix SQL Injection

function test_contest_id($contest_id)
{
  $contest = mysql_fetch_assoc(mysql_query("SELECT * FROM contest WHERE contest_id=$contest_id"));
  return $contest ? 'success' : "This contest ID doesn't exist!";
}

function test_user_id($user_id, $contest_id)
{
  $res = mysql_query("SELECT * FROM users WHERE user_id='$user_id'");
  if (!$res) {
    return "This user ID doesn't exist!";
  }
  $user = mysql_fetch_assoc($res);
  if (!$user) {
    return "This user ID doesn't exist!";
  }
  $data = mysql_fetch_assoc(mysql_query("SELECT contestants FROM contest WHERE contest_id=$contest_id"));
  $contestants = json_decode($data['contestants']);
  if (is_array($contestants) && in_array($user_id, $contestants)) {
    return 'This user has registered!';
  }
  return 'success';
}

$contest_id = intval($_POST['contest_id']);
$user_id = mysql_real_escape_string($_POST['user_id']);
$contest_test_result = test_contest_id($contest_id);
$user_test_result = test_user_id($user_id, $contest_id);
if ($contest_test_result != 'success') {
  echo $contest_test_result;
} elseif ($user_test_result != 'success') {
  echo $user_test_result;
} else {
  $data = mysql_fetch_assoc(mysql_query("SELECT contestants FROM contest WHERE contest_id=$contest_id"));
  $contestants = json_decode($data['contestants']);
  $contestants[] = $user_id;
  $contestants = json_encode($contestants);
  mysql_query("UPDATE contest SET contestants='$contestants' WHERE contest_id=$contest_id");
  echo 'success';
}