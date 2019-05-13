<?php
require "functions/database.php";

function h($string)
{
  return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
}

function insertMainTask($user_task, $user_name, $date) {
  $pdo = connect();
  $stmt = $pdo->prepare("INSERT INTO tasks (content, users_name, achieve, deadline) VALUES (:content, :users_name, 'still', :deadline)");

  $stmt->bindParam(':content', $user_task, PDO::PARAM_STR);
  $stmt->bindParam(':users_name', $user_name, PDO::PARAM_STR);
  $stmt->bindParam(':deadline', $date, PDO::PARAM_STR);

  return $stmt->execute();
}

function fetchMainTasks($user_name) {
  $pdo = connect();
  $stmt = $pdo->prepare("SELECT * FROM tasks WHERE parent_id IS NULL AND achieve = 'still' AND users_name = :users_name ORDER BY deadline ASC");

  $stmt->bindParam(':users_name', $user_name, PDO::PARAM_STR);

  $stmt->execute();

  return $stmt->fetchAll();
}

function showTitle($user_name, $parent_id) {
  $pdo = connect();
  $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id AND users_name = :users_name");
  $stmt->bindParam(':id', $parent_id, PDO::PARAM_STR);
  $stmt->bindParam(':users_name', $user_name, PDO::PARAM_STR);

  $stmt->execute();

  return $stmt->fetchAll();
}

function fetchAchievedTasks($user_name) {
  $pdo = connect();
  $stmt = $pdo->prepare("SELECT * FROM tasks WHERE parent_id IS NULL AND achieve = 'already' AND users_name = :users_name");
  $stmt->bindParam(':users_name', $user_name, PDO::PARAM_STR);
  $stmt->execute();

  return $stmt->fetchAll();
}

function insertIndividualTask($user_task, $user_name, $parent_id) {
  $pdo = connect();
  $stmt = $pdo->prepare("INSERT INTO tasks (content, users_name, achieve, parent_id) VALUES (:content, :users_name, 'still', :parent_id)");

  $stmt->bindParam(':content', $user_task, PDO::PARAM_STR);
  $stmt->bindParam(':users_name', $user_name, PDO::PARAM_STR);
  $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);

  return $stmt->execute();
}

function fetchIndividualTasks($user_name, $parent_id) {
  $pdo = connect();
  $stmt = $pdo->prepare("SELECT * FROM tasks WHERE users_name = :users_name AND parent_id = :parent_id");

  $stmt->bindParam(':users_name', $user_name, PDO::PARAM_STR);
  $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);

  $stmt->execute();

  return $stmt->fetchAll();
}

function transferTasks($id_arr, $achieve) {
  $pdo = connect();

  $placeholder = implode(",", array_fill(0, count($id_arr), "?"));

  if($achieve === "still") {
    $stmt = $pdo->prepare("UPDATE tasks SET achieve = 'already' WHERE id IN (".$placeholder.")");
  } else {
    $stmt = $pdo->prepare("UPDATE tasks SET achieve = 'still' WHERE id IN (".$placeholder.")");
  }

  foreach($id_arr as $i => $id) {
    $stmt->bindValue(($i+1), $id);
  }

  return $stmt->execute();
}

//この関数をもう少しなんとかしたい
function conversionIndividualTasks($id_arr) {
  foreach($id_arr as $id) {
    $pdo = connect();
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch();
    if($row['achieve'] === 'still') {
      $sql = "UPDATE tasks SET achieve = 'already' WHERE id = :id";
    }else {
      $sql = "UPDATE tasks SET achieve = 'still' WHERE id = :id";
    }

    $pdo = connect();
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }
}

function deleteTasks($id_arr) {
  $placeholder = implode(",", array_fill(0, count($id_arr), "?"));

  $pdo = connect();
  $stmt = $pdo->prepare("DELETE FROM tasks WHERE id IN (".$placeholder.")");
  foreach($id_arr as $i => $id) {
    $stmt->bindValue(($i+1), $id);
  }
  return $stmt->execute();
}

function login($user_name) {
  $pdo = connect();

  $stmt = $pdo->prepare('SELECT * FROM users WHERE name = ?');

  $params = [];
  $params[] = $user_name;

  $stmt->execute($params);

  return $stmt->fetchAll();
}

function checkDuplication($user_name) {
  $pdo = connect();

  $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE name=:name');
  $stmt->bindParam(':name', $user_name, PDO::PARAM_STR);
  $stmt->execute();
  return $stmt->fetchAll();
}

function register($user_name, $password) {
  $pdo = connect();

  $stmt = $pdo->prepare('INSERT INTO users (name, password) VALUES (:name, :password)');

  $stmt->bindParam(':name', $user_name, PDO::PARAM_STR);
  $stmt->bindParam(':password', $password, PDO::PARAM_STR);

  return $stmt->execute();
}

function dateDiff($date, $deadline) {
  $date_ts = strtotime($date);
  $deadline_ts = strtotime($deadline);
  $second_diff = $deadline_ts - $date_ts;
  $date_diff = $second_diff / (60 * 60 * 24);
  return $date_diff;
}