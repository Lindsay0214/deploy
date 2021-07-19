<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  if (
    empty($_GET['id'])
  ) {
    header('Location: index.php?errCode=1');
    die('資料不齊全');
  }

  $id = $_GET['id'];
  $username = $_SESSION['username'];  // 要得到 session 下面 SQL 指令才會成立，避免無權限仍可以做有權限事情

  $sql = "update lindsay_comments set is_delete=1 where id=? and username=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('is', $id, $username);

  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  header("Location: index.php");
?>