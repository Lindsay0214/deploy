<?php
  session_start();
  require_once('conn.php');

  if ( empty($_POST['nickname']) || empty($_POST['username']) || empty($_POST['password']) ) {
    header('Location: index.php?errCode=1');
    die('資料不齊全');
  }

  $nickname = $_POST['nickname'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $sql = "insert into lindsay_comments_users(nickname, username, password) values(?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sss', $nickname, $username, $password);
  $result = $stmt->execute();
  if (!$result) {
    header('Location: register.php?errCode=2');
    die($conn->error);
  }

  $_SESSION['username'] = $username;
  // 這樣註冊完直接登入
  header("Location: index.php");
?>