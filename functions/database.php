<?php
function connect()
{
  $dsn = 'mysql:host=localhost;dbname=sample;charset=utf8;';
  $username = 'root';
  $password = 'root';
  $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ];
  $pdo = new PDO($dsn, $username, $password, $options);
  return $pdo;
}
