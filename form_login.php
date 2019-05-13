<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();

require "functions/functions.php";

$err = [];

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
  $user_name = h(filter_input(INPUT_POST, 'name'));
  $password = h(filter_input(INPUT_POST, 'password'));

  if ($user_name === '') {
    $err['user_name'] = 'ユーザー名が未入力です';
  }
  if ($password === '') {
    $err['password'] = 'パスワードが未入力です';
  }

  if (count($err) === 0) {

    $rows = login($user_name);

    foreach ($rows as $row) {
      $password_hash = $row['password'];

      if (password_verify($password, $password_hash)) {
        session_regenerate_id(true);
        $_SESSION['login_user'] = $row;
        header('Location:list.php');
        return;
      }
    }
    $err['login'] = 'ログインに失敗しました。';
  }
}

include("header.php");
?>

  <div id="form">
    <p><a href="index.php">←</a></p>
    <h1>ログイン</h1>
    <form action="" method="post">
      <?php if (isset($err['login'])) : ?>
        <p class="error"><?php echo h($err['login']); ?></p>
      <?php endif; ?>
      <p>
        <label for="user_name">ユーザー名</label>
        <input id="user_id" name="name" type="text"/>
        <?php if (isset($err['user_name'])) : ?>
      <p class="error"><?php echo h($err['user_name']); ?></p>
    <?php endif; ?>
      </p>
      <p>
        <label for="">パスワード</label>
        <input id="password" name="password" type="password"/>
        <?php if (isset($err['password'])) : ?>
      <p class="error"><?php echo h($err['password']); ?></p>
    <?php endif; ?>
      </p>
      <p>
        <button type="submit">ログイン</button>
      </p>
    </form>
  </div>

<?php
include("footer.php");
?>
