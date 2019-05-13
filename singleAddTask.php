<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();

require "functions/functions.php";

$user_name = h($_SESSION['login_user']['name']);
$parent_id = h($_GET['parentId']);

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
  $user_task = h(filter_input(INPUT_POST, 'content'));

  if (!($user_task === '')) {
    insertIndividualTask($user_task, $user_name, $parent_id);
  }

  header("Location:single.php?parentId=${parent_id}");
}
