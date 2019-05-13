<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();

require "functions/functions.php";

if(isset($_GET['parentId'])) {
  $parent_id = h($_GET['parentId']);
}

$id_arr = $_POST['id_arr'];
for($i = 0; $i < count($id_arr); $i++) {
  $id_arr[$i] = h($id_arr[$i]);
}

if(isset($_GET['achieve'])) {
  $achieve = h($_GET['achieve']);
}

if(isset($_POST['transfer'])) {
  if(count($id_arr)) {
    transferTasks($id_arr, $achieve);
  }
} else if(isset($_POST['delete'])) {
  if(count($id_arr)) {
    deleteTasks($id_arr);
  }
} else if(isset($_POST['change-color'])) {
  if(count($id_arr)) {
    conversionIndividualTasks($id_arr);
  }
}

if($achieve === "still") {
  header('Location:list.php');
} else if($achieve === "already") {
  header('Location:achieve.php');
} else {
  header('Location:single.php?parentId='.h($parent_id));
}