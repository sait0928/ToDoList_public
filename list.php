<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();
// var_dump($_SESSION);
$user_name = $_SESSION['login_user']['name'];

require "functions/functions.php";

$rows = selectParentTasks($user_name);

include("header.php");
?>
<header>
  <h1><?php echo h($user_name); ?><span>さんのリスト</span></h1>
  <button type="button" class="drawer-toggle drawer-hamburger">
    <span class="sr-only">toggle navigation</span>
    <span class="drawer-hamburger-icon"></span>
  </button>
  <nav class="drawer-nav">
    <ul class="drawer-menu">
      <li><a href="achieve.php">達成済リスト</a></li>
      <li><a href="logout.php">ログアウト</a></li>
    </ul>
  </nav>
</header>
<section class="list">
  <form action="control.php?achieve=still" method="POST">
    <ul>
      <?php foreach ($rows as $row) : ?>
        <li>
          <label>
            <input type="checkbox" name="id_arr[]" value="<?php echo h($row['id']); ?>">
            <a href="single.php?parentId=<?php echo h($row['id']); ?>"><?php echo h($row['content']); ?></a>
          </label>
        </li>
      <?php endforeach; ?>
    </ul>
    <input class="update btn" type="submit" name="transfer" value="選択した項目を達成">
    <input class="update btn" type="submit" name="delete" value="選択した項目を削除">
  </form>
</section>
<footer>
  <form id="add" action="listAddTask.php" method="POST">
    <input id="add-text" type="text" name="content" placeholder="項目を追加">
    <button id="add-btn" type="submit">▶︎</button>
  </form>
</footer>
<?php
include("footer.php");
?>
