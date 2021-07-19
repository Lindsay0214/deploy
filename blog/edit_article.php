<?php
    session_start();
    require_once("conn.php");
    require_once("utils.php");

    $id = $_GET['id'];

    $username = NULL;
    $user = NULL;
    if(!empty($_SESSION['username'])) {
      $username = $_SESSION['username'];
      $user = getUserFromUsername($username);
    }
  
    $stmt = $conn->prepare('select * from lindsay_articles where id = ?');
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    if (!$result) {
      die('Error:' . $conn->error);
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>部落格</title>
</head>
<body>
    <div class="sub__header">
        <span><a href="./admin.php" class="back"> < 返回後台管理</a></span>
        <h1>編輯文章</h1>
    </div>

    <section>
        <div class="article">
            <?php
                    if(!empty($_GET['errCode'])){
                    $code = $_GET['errCode'];
                    $msg = 'Error';
                    if($code === '1'){
                            $msg = '修改不能為空';
                        }
                        echo '<h2 class="error">' . $msg . '</h2>';
                    }
            ?>
            <h2>編輯文章</h2>
            <br>
            <form method="POST" action="./handle_edit_article.php">
                <div class="edit__title">
                    <h2 style="font-weight: 300; margin-bottom: 10px;">標題</h2>
                    <input name="title" style="width: 500px">
                        <!-- <?php echo $row['title'] ?> -->
                    </input>
                </div>
                <div class="edit__content">
                    <h2 style="font-weight: 300; margin-bottom: 10px;">內容</h2>
                    <textarea name="content" rows="10">
                    </textarea>
                </div>
                <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
                <button class="edit__content__btn" type="submit" style="border: 3px #faedcd solid;">編輯完畢</button>
            </form>
        </div>
    </section>
    
    <footer>
        <p>Copyright © 2021 Lindsay's Blog All Rights Reserved.</p>
    </footer>
</body>
</html>
