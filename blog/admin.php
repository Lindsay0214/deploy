<?php
    session_start();
    require_once("conn.php");
    require_once("utils.php");

    $username = NULL;
    $user = NULL;
    if(!empty($_SESSION['username'])) {
      $username = $_SESSION['username'];
      $user = getUserFromUsername($username);
    }
    
    $sql = sprintf("SELECT * FROM lindsay_articles ORDER BY lindsay_articles.id desc");
    $result = $conn->query($sql);
    if(!$result){
        die($conn->error);
    }

    // $stmt = $conn->prepare(
    //     'select '.
    //       'C.id as id, C.content as content, '.
    //       'C.title as title, '.
    //       'C.created_at as created_at, U.nickname as nickname, U.username as username '.
    //     'from lindsay_articles as C ' .
    //     'left join lindsay_articles_users as U on C.username = U.username '.
    //     'order by C.id desc'
    //   );
    // $result = $stmt->execute();
    // if (!$result) {
    //   die('Error:' . $conn->error);
    // }
    // $result = $stmt->get_result();
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
        <span><a href="./index.php" class="back"> < 返回首頁</a></span>
        <h1>後台管理</h1>
    </div>

    <section>
            <div class="article" style="border: white;">
                <h2>Hi, <?php echo $user['nickname']; ?></h2>
                <br>
                <a href="./add_article.php" class="btn">新增文章</a>
            </div>

        <?php while($row = $result->fetch_assoc()){ ?>
        <div class="articles">
            <div class="article">
                <h2><?php echo $row['title']; ?></h2>
                <div class="time"><?php echo $row['created_at']; ?></div>
                <p><?php echo $row['content']; ?></p>
                <?php if ($row['username'] === $username) { ?>
                <a href="./handle_edit_article.php?id=<?php echo $row['id'] ?>" class="btn">編輯文章</a>
                <a href="./delete.php?id=<?php echo $row['id'] ?>" class="btn">刪除文章</a>
                <? } ?>
            </div>
        </div>
        <?php }?>
    </section>
    
    <footer>
        <p>Copyright © 2021 Lindsay's Blog All Rights Reserved.</p>
    </footer>
</body>
</html>