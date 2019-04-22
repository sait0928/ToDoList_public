<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

session_start();
// var_dump($_SESSION);
$user_name = $_SESSION['login_user']['name'];

require "functions/functions.php";

$rows = selectParentTasks($user_name);
$year = date("Y");//現在の西暦を取得
$date = date("Ymd");//現在の日付を取得

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
        <?php if($row['deadline'] < $date) : ?>
        <li class="danger">
        <?php elseif(dateDiff($date, $row['deadline']) <= 7) : ?>
        <li class="hurry">
        <?php else : ?>
        <li>
        <?php endif; ?>
          <label>
            <input type="checkbox" name="id_arr[]" value="<?php echo h($row['id']); ?>">
            <a href="single.php?parentId=<?php echo h($row['id']); ?>"><?php echo h($row['content']); ?></a>
          </label>
        </li>
      <?php endforeach; ?>
    </ul>
    <input class="update btn list-btn" type="submit" name="transfer" value="選択した項目を達成">
    <input class="update btn list-btn" type="submit" name="delete" value="選択した項目を削除">
  </form>
</section>
<footer>
  <form id="add" action="listAddTask.php" method="POST">
    <label>期日：
      <select name="year" class="js-changeYear">
      <?php
      for($i = 0; $i < 5; $i++) :
      ?>
      <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
      <?php
      $year++;
      endfor;
      ?>
    </select>
    <select name="month" class="js-changeMonth">
      <?php
      $month = 1;
      for($i = 0; $i < 12; $i++) :
      ?>
      <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
      <?php
      $month++;
      endfor;
      ?>
    </select>
    <select name="day" class="js-changeDay">
      <?php
      $day = 1;
      for($i = 0; $i < 31; $i++) :
      ?>
      <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
      <?php
      $day++;
      endfor;
      ?>
    </select>
    </label>
    <input id="add-text" type="text" name="content" placeholder="項目を追加">
    <button id="add-btn" type="submit">▶︎</button>
    <p>▼詳細設定▼</p>
  </form>
</footer>
<?php
include("footer.php");
?>
