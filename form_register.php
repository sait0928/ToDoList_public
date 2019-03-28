<?php
// ディスプレイに全てのPHPエラーを表示
ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();

require "functions/functions.php";

// エラーを連想配列形式で格納する
$err = [];

// アクセスの時に使われたリクエストのメソッド名を取得し、
// それがPOSTだった場合
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
  $user_name = filter_input(INPUT_POST, 'name');
  $password = filter_input(INPUT_POST, 'password');

  if ($user_name === '') {
    $err['user_name'] = 'ユーザー名は入力必須です。';
  }
  if ($password === '') {
    $err['password'] = 'パスワードは入力必須です。';
  }

  $password = password_hash($password, PASSWORD_DEFAULT);

  // エラーがないとき
  if (count($err) === 0) {

    $count = checkDuplication($user_name);

    // var_dump($count);

    if(!($count[0]["COUNT(*)"])) {

      register($user_name, $password);

      session_regenerate_id(true);
      $_SESSION['login_user']['name'] = $user_name;
      // var_dump($_SESSION);
      header('Location:list.php');
      // return;

    } else {
      $err['name_dup'] = 'そのユーザー名は既に使われています。';
    }
  }
}

include("header.php");
?>

<div id="form">
  <p><a href="index.php">←</a></p>
  <h1>新規登録</h1>
  <form action="" method="post">
    <?php if (isset($err['login'])) : ?>
      <p class="error"><?php echo h($err['login']); ?></p>
    <?php endif; ?>
    <p>
      <label for="user_name">ユーザー名</label><br/>
      <input id="user_id" name="name" type="text"/>
      <?php if (isset($err['user_name'])) : ?>
        <p class="error"><?php echo h($err['user_name']); ?></p>
      <?php endif; ?>
      <?php if (isset($err['name_dup'])) : ?>
        <p class="error"><?php echo h($err['name_dup']); ?></p>
      <?php endif; ?>
    </p>
    <p>
      <label for="">パスワード</label><br/>
      <input id="password" name="password" type="password"/>
      <?php if (isset($err['password'])) : ?>
        <p class="error"><?php echo h($err['password']); ?></p>
      <?php endif; ?>
    </p>
    <p>
      <button type="submit">登録</button>
    </p>
  </form>
</div>

<?php
include("footer.php");
?>
