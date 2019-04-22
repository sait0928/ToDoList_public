<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();
// var_dump($_SESSION);
$user_name = $_SESSION['login_user']['name'];

require "functions/functions.php";

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
  $user_task = filter_input(INPUT_POST, 'content');
  $year = filter_input(INPUT_POST, 'year');
  //月・日は0埋めする
  $month = filter_input(INPUT_POST, 'month');
  $m_pad = str_pad($month, 2, 0, STR_PAD_LEFT);
  $day = filter_input(INPUT_POST, 'day');
  $d_pad = str_pad($day, 2, 0, STR_PAD_LEFT);
  $date = $year.$m_pad.$d_pad;

  if (!($user_task === '')) {
    insertParentTask($user_task, $user_name, $date);
  }

  header("Location:list.php");
}
