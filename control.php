<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();

if(isset($_GET['parentId'])) {
  $parent_id = $_GET['parentId'];
}

$id_arr = $_POST['id_arr'];
// var_dump($id_arr);
$achieve = $_GET['achieve'];

require "functions/functions.php";

if(isset($_POST['transfer'])) {
  if(count($id_arr)) {
    transferTasks($id_arr, $achieve);
  }
} else if(isset($_POST['delete'])) {
  if(count($id_arr)) {
    deleteTasks($id_arr);
  }
}

if($achieve === "still") {
  header('Location:list.php');
} else if($achieve === "already") {
  header('Location:achieve.php');
} else {
  header('Location:single.php?parentId='.h($parent_id));
}