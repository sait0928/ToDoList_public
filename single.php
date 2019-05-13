<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();
$user_name = $_SESSION['login_user']['name'];
$parent_id = $_GET['parentId'];

require "functions/functions.php";

$parent_rows = fetchMainTasks($user_name);
$rows = fetchIndividualTasks($user_name, $parent_id);
$title = showTitle($user_name, $parent_id);

include("header.php");
?>
<header>
  <a id="return" href="list.php">←</a>
  <?php foreach ($title as $row) : ?>
    <h1><?php echo h($row['content']); ?></h1>
  <?php endforeach; ?>
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
  <?php foreach($parent_rows as $row) : ?>
  <?php if($row['id'] === $parent_id) : ?>
  <p id="deadline">期日：<?php echo date('Y/m/d', strtotime(h($row['deadline']))); ?></p>
  <?php endif; ?>
  <?php endforeach; ?>
  <form action="control.php?parentId=<?php echo h($parent_id); ?>" method="POST">
    <ul>
      <?php foreach ($rows as $row) : ?>
        <?php if($row['achieve'] === 'still') : ?>
        <li>
        <?php else : ?>
        <li class="already">
        <?php endif; ?>
          <input type="checkbox" name="id_arr[]" value="<?php echo h($row['id']); ?>">
          <?php echo h($row['content']); ?>
        </li>
      <?php endforeach; ?>
    </ul>
    <input class="update btn single-btn" type="submit" name="change-color" value="項目の達成状況を変更">
    <input class="update btn single-btn" type="submit" name="delete" value="選択した項目を削除">
  </form>
</section>
<footer>
  <form id="add" action="singleAddTask.php?parentId=<?php echo h($parent_id); ?>" method="POST">
    <input id="add-text" type="text" name="content" placeholder="小目標を追加">
    <button id="add-btn" type="submit">▶︎</button>
  </form>
</footer>
<?php
include("footer.php");
?>
