<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  if (
    empty($_POST['content'])
  ) {
    header('Location: index.php?errCode=1');
    die('資料不齊全');
  }

  $username = $_SESSION['username'];

  $content = $_POST['content'];
  $sql = "insert into lindsay_comments(username, content) values(?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $username, $content);

  // 問題：我應該出現的是 nickname 而非 username，所以理當 username 這裡不用加入，但目前 nickname 無論有無加入 username 都沒吃到，還沒找出原因
  // token -> username -> nickname

  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  header("Location: index.php");
?> 