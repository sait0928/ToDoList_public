<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();
$user_name = $_SESSION['login_user']['name'];

require "functions/functions.php";

$rows = fetchAchievedTasks($user_name);

include("header.php");
?>
<header>
  <a id="return" href="list.php">←</a>
  <h1>達成済リスト</h1>
  <button type="button" class="drawer-toggle drawer-hamburger">
    <span class="sr-only">toggle navigation</span>
    <span class="drawer-hamburger-icon"></span>
  </button>
  <nav class="drawer-nav">
    <ul class="drawer-menu">
      <li><a href="logout.php">ログアウト</a></li>
    </ul>
  </nav>
</header>
<section class="list">
  <form action="control.php?achieve=already" method="POST">
    <ul>
      <?php foreach ($rows as $row) : ?>
        <li>
          <input type="checkbox" name="id_arr[]" value="<?php echo h($row['id']); ?>">
          <?php echo h($row['content']); ?>
        </li>
      <?php endforeach; ?>
    </ul>
    <input class="update btn" type="submit" name="transfer" value="選択した項目を戻す">
    <input class="update btn" type="submit" name="delete" value="選択した項目を削除">
  </form>
  <?php if (isset($err['user_task'])) : ?>
    <p class="error"><?php echo h($err['user_task']); ?></p>
  <?php endif; ?>
</section>
<?php
include("footer.php");
?>
