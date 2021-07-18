<?php
  // require_once('conn.php');

  // // 把 token 從資料庫裡面刪掉
  // $token = $_COOKIE['token'];
  // $sql = sprintf(
  //   "delete from lindsay_tokens where token='%s'",
  //   $token
  // );
  // // 然後清空  
  // $conn->query($sql);
  // setcookie("token", "", time() - 3600);
  session_start();
  session_destroy();
  header("Location: index.php");
?>