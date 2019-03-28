<?php
/**
 * Created by IntelliJ IDEA.
 * User: takenakariku
 * Date: 2019-03-16
 * Time: 02:42
 */

ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();
// var_dump($_SESSION);
$user_name = $_SESSION['login_user']['name'];
$parent_id = $_GET['parentId'];
// echo $parent_id;

require "functions/functions.php";

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
  $user_task = filter_input(INPUT_POST, 'content');

  if (!($user_task === '')) {
    insertChildTask($user_task, $user_name, $parent_id);
  }

  header("Location:single.php?parentId=${parent_id}");
}
