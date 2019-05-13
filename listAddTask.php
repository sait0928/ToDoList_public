<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();

require "functions/functions.php";

$user_name = h($_SESSION['login_user']['name']);


if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
  $user_task = h(filter_input(INPUT_POST, 'content'));

  $year = h(filter_input(INPUT_POST, 'year'));
  $month = h(filter_input(INPUT_POST, 'month'));
  $day = h(filter_input(INPUT_POST, 'day'));
  if(checkdate($month, $day, $year)) {
    $m_pad = str_pad($month, 2, 0, STR_PAD_LEFT);
    $d_pad = str_pad($day, 2, 0, STR_PAD_LEFT);
    $date = $year.$m_pad.$d_pad;    
  }

  if (!($user_task === '')) {
    insertMainTask($user_task, $user_name, $date);
  }

  header("Location:list.php");
}
