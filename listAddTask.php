<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();
// var_dump($_SESSION);
$user_name = $_SESSION['login_user']['name'];

require "functions/functions.php";

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
  $user_task = filter_input(INPUT_POST, 'content');

  if (!($user_task === '')) {
    insertParentTask($user_task, $user_name);
  }

  header("Location:list.php");
}
