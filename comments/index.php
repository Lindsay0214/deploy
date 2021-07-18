<?php
session_start();
require_once("conn.php");
require_once("utils.php");
/*
  1. 從 cookie 裡面讀取 PHP SESSION ID(token)
  2. 從檔案裡面讀取 session id 的內容
  3. 放到 $_SESSION
*/
$username = NULL;
$user = NULL;
if(!empty($_SESSION['username'])) {
  $username = $_SESSION['username'];
  $user = getUserFromUsername($username);
}

$page = 1;
if (!empty($_GET['page'])) {
  $page = intval($_GET['page']);
}
$items_per_page = 5;
$offset = ($page - 1) * $items_per_page;

$stmt = $conn->prepare(
  'select '.
    'C.id as id, C.content as content, '.
    'C.created_at as created_at, U.nickname as nickname, U.username as username '.
  'from lindsay_comments as C ' .
  'left join lindsay_comments_users as U on C.username = U.username '.
  'where C.is_delete IS NULL '.
  'order by C.id desc '.
  'limit ? offset ? '
);

$stmt->bind_param('ii', $items_per_page, $offset);
$result = $stmt->execute();
if (!$result) {
  die('Error:' . $conn->error);
}
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>留言板</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="warning">
    <strong>注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</strong>
  </header>
  <main class="board">
    <div>
      <?php if(!$username) { ?>
      <a class="boarder__btn" href="./register.php">註冊</a>
      <a class="boarder__btn" href="./login.php">登入</a>
      <?php } else { ?>
        <a class="boarder__btn" href="./logout.php">登出</a>
        <span class="boarder__btn update-nickname" style="width: 100px; margin-bottom: 10px;">編輯暱稱</span>
          <form class="hide board__nickname-form board__new-comment-form" method="POST" action="update_user.php">
            <div class="board__nickname">
              <span>新的暱稱：</span>
              <input type="text" name="nickname" />
            </div>
            <input class="board__submit-btn" type="submit" />
          </form>
          <h3>你好！<?php echo $user['nickname']; ?></h3>
      <?php } ?>
    </div>
    <h1 class="board__title">Comments</h1>
	  <?php
        if (!empty($_GET['errCode'])) {
          $code = $_GET['errCode'];
          $msg = 'Error';
          if ($code === '1') {
            $msg = '資料不齊全';
          }
          echo '<h2 class="error">錯誤：' . $msg . '</h2>';
        }
      ?>
      <?php if($username) { ?>
      <form class="board__new-comment-form" method="POST" action="handle_add_comment.php">
        <textarea name="content" rows="5"></textarea>
        <input class="board__submit-btn" type="submit" />
      </form>
      <?php } else { ?>
        <h3>請先登入</h3>
      <?php } ?>
      <div class="board__hr"></div>
      <section>
	  <?php
          while($row = $result->fetch_assoc()) {
        ?>
          <div class="card">
            <div class="card__avatar"></div>
            <div class="card__body">
                <div class="card__info">
                  <span class="card__author">
                    <?php echo escape($row['nickname']); ?>
                    (@<?php echo escape($row['username']); ?>)
                  </span>
                  <span class="card__time">
                    <?php echo escape($row['created_at']); ?>
                  </span>
                  <?php if ($row['username'] === $username) { ?>
                    <a class="boarder__btn" href="update_comment.php?id=<?php echo $row['id'] ?>">編輯</a>
                    <a class="boarder__btn" href="delete_comment.php?id=<?php echo $row['id'] ?>">刪除</a>
                  <? } ?>
                </div>
                <p class="card__content"><?php echo escape($row['content']); ?></p>
            </div>
          </div>
		  <?php } ?>
      </section>
      <div class="board__hr"></div>
      <?php // 分頁＿＿總共幾筆資料處理
        $stmt = $conn->prepare('
          select count(id) as count from lindsay_comments where is_delete IS NULL
          ');
          $result = $stmt->execute();
          $result = $stmt->get_result();
          $row = $result->fetch_assoc();
          $count =  $row['count'];
          $total_page = ceil($count / $items_per_page);
      ?>
      <div class="page-info">
        <span>共有 <?php echo $count ?> 則留言，頁數：</span>
        <span><?php echo $page ?> / <?php echo $total_page ?></span>
      </div>
      <div class="paginator">
        <!-- 用 get 帶頁數 (?page=1)-->
        <?php if ($page!=1) { ?>
        <a href="./index.php?page=1">首頁</a>
        <a href="./index.php?page=<?php echo $page - 1 ?>">上一頁</a>
        <?php } ?>
        <?php if ($page!= $total_page) { ?>
        <a href="./index.php?page=<?php echo $page + 1 ?>">下一頁</a>
        <a href="./index.php?page=<?php echo $total_page ?>">最後一頁</a>
        <?php } ?>
      </div>
  </main>

  <script>
    var btn = document.querySelector('.update-nickname')
    btn.addEventListener('click', function() {
      var form = document.querySelector('.board__nickname-form')
      form.classList.toggle('hide')
    }, false)
  </script>
  
</body>
</html>