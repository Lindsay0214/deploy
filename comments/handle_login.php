<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  if (
    empty($_POST['username']) ||
    empty($_POST['password']) 
  ) {
    header('Location: login.php?errCode=1');
    die();
  }
  $username = $_POST['username'];
  $password = $_POST['password'];
  $sql = "select * from lindsay_comments_users where username=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }

  $result = $stmt->get_result();
  if($result->num_rows === 0){
    header("Location: login.php?errCode=2");
    exit();
  }

  // 有查到 user
  $row = $result->fetch_assoc();
  if (password_verify($password, $row['password'])){

    $_SESSION['username'] = $username;
    // 設置 token
      // $token = generateToken();
      // $sql = sprintf(
      //   "insert into lindsay_tokens(token,username) values('%s', '%s')",
      //   $token,
      //   $username
      // );
      // $result = $conn->query($sql);
      // if (!$result) {
      //   die($conn->error);
      // }

      // $expire = time() + 3600 * 24 * 30;
      // setcookie("token", $token, $expire);
      header("Location: index.php"); //cookie return to index
  } else {
    header("Location: login.php?errCode=2" );
  }
?>