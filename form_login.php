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
    $err['user_name'] = 'ユーザー名が未入力です';
  }
  if ($password === '') {
    $err['password'] = 'パスワードが未入力です';
  }

  // エラーがないとき
  if (count($err) === 0) {

    $rows = login($user_name);

    // パスワード検証
    foreach ($rows as $row) {
      // テーブルにあるハッシュ化されたパスワードを取得
      $password_hash = $row['password'];

      // パスワード一致した場合
      if (password_verify($password, $password_hash)) {
        // 新しくセッションIDを生成
        session_regenerate_id(true);
        // セッション変数のキー変数で何の値なのかを分かりやすくしておく
        $_SESSION['login_user'] = $row;
        // リストページにリダイレクト
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
