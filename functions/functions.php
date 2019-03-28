<?php
require "functions/database.php";

function h($string)
{
  return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
}

function insertParentTask($user_task, $user_name) {
  $pdo = connect();
  $stmt = $pdo->prepare("INSERT INTO tasks (content, users_name, achieve) VALUES (:content, :users_name, 'still')");

  $stmt->bindParam(':content', $user_task, PDO::PARAM_STR);
  $stmt->bindParam(':users_name', $user_name, PDO::PARAM_STR);

  return $stmt->execute();
}

function selectParentTasks($user_name) {
  $pdo = connect();
  // 条件複数指定はAND,NULLの検索には=NULLではなくISNULLを使う
  $stmt = $pdo->prepare("SELECT * FROM tasks WHERE parent_id IS NULL AND achieve = 'still' AND users_name = :users_name");

  $stmt->bindParam(':users_name', $user_name, PDO::PARAM_STR);

  $stmt->execute();

  return $stmt->fetchAll();
}

function showSingleTitle($user_name, $parent_id) {
  $pdo = connect();
  $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id AND users_name = :users_name");
  $stmt->bindParam(':id', $parent_id, PDO::PARAM_STR);
  $stmt->bindParam(':users_name', $user_name, PDO::PARAM_STR);

  $stmt->execute();

  return $stmt->fetchAll();
}

function selectAchievedTasks($user_name) {
  $pdo = connect();
  $stmt = $pdo->prepare("SELECT * FROM tasks WHERE parent_id IS NULL AND achieve = 'already' AND users_name = :users_name");
  $stmt->bindParam(':users_name', $user_name, PDO::PARAM_STR);
  $stmt->execute();

  return $stmt->fetchAll();
}

function insertChildTask($user_task, $user_name, $parent_id) {
  $pdo = connect();
  $stmt = $pdo->prepare("INSERT INTO tasks (content, users_name, achieve, parent_id) VALUES (:content, :users_name, 'still', :parent_id)");

  $stmt->bindParam(':content', $user_task, PDO::PARAM_STR);
  $stmt->bindParam(':users_name', $user_name, PDO::PARAM_STR);
  $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);

  return $stmt->execute();
}

function selectChildTasks($user_name, $parent_id) {
  $pdo = connect();
  $stmt = $pdo->prepare("SELECT * FROM tasks WHERE users_name = :users_name AND parent_id = :parent_id");

  $stmt->bindParam(':users_name', $user_name, PDO::PARAM_STR);
  $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);

  $stmt->execute();

  return $stmt->fetchAll();
}

function transferTasks($id_arr, $achieve) {
  $pdo = connect();
  $i = 0;
  if($achieve === "still") {
    $sql = "UPDATE tasks SET achieve = 'already' WHERE ";
  } else {
    $sql = "UPDATE tasks SET achieve = 'still' WHERE ";
  }
  foreach($id_arr as $id) {
    if($i>0) {
      $sql = $sql." OR ";
    }
    $sql = $sql."id = ".$id;
    $i++;
  }
  $stmt = $pdo->query($sql);
}

function deleteTasks($id_arr) {
  $pdo = connect();
  $i = 0;
  $sql = "DELETE FROM tasks WHERE ";
  foreach($id_arr as $id) {
    if($i>0) {
      $sql = $sql." OR ";
    }
    $sql = $sql."id = ".$id." OR parent_id = ".$id;
    $i++;
  }
  $stmt = $pdo->query($sql);
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