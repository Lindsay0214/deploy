<?php
    session_start();
    require_once('conn.php');
    require_once('utils.php');

    $username = NULL;
    $user = NULL;
    if(!empty($_SESSION['username'])) {
      $username = $_SESSION['username'];
      $user = getUserFromUsername($username);
    }
    
    // $stmt = $conn->prepare(
    //     'select'.
    //     'C.id as id, C.content as content, C.title as title,'.
    //     'C.created_at as created_at, '.
    //     'U.nickname as nickname, '.
    //     'U.username as username '.
    //     'from lindsay_articles as C '.
    //     'left join lindsay_articles_users as U on C.username = U.username'.
    //     'where C.is_delete IS NULL' .
    //     'order by C.id desc'
    // );
    $stmt = $conn->prepare(
        'select '.
          'C.id as id, C.content as content, '.
          'C.title as title, '.
          'C.created_at as created_at, U.nickname as nickname, U.username as username '.
        'from lindsay_articles as C ' .
        'left join lindsay_articles_users as U on C.username = U.username '.
        'order by C.id desc'
      );
    $result = $stmt->execute();
    if (!$result) {
      die('Error:' . $conn->error);
    }
    $result = $stmt->get_result();
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
    <div class="header">
        <ul class="navbar__left">
            <li class="article__list"><a href="./article_list.php">文章列表</a></li>
            <li class="category"><a href="./category.php">分類專區</a></li>
            <li class="about__me"><a href="./about__me.php">關於我</a></li>
        </ul>
        <ul class="navbar__right">
            <?php if (!$username) { ?>
                <li class="login"><a href="./login.php">登入</a></li>
            <?php } else { ?>
                <li class="admin"><a href="./admin.php">管理後台</a></li>
                <a class="board__btn" href="logout.php">登出</a>
            <?php } ?>
        </ul>

        <div class="navbar__bottom">
            <img src="./logo_200x200.png" alt="blog-logo" class="logo">
        </div>
    </div>

    <section>
        <?php while($row = $result->fetch_assoc()){ ?>
        <div class="articles">
            <div class="article">
                <h2><?php echo escape($row['title']); ?></h2>
                <div class="time"><?php echo escape($row['created_at']); ?></div>
                <p><?php echo escape($row['content']); ?></p>
                <div class="btn">READ MORE</div>
            </div>
        </div>
        <?php }?>
    </section>
    
    <footer>
        <p>Copyright © 2021 Lindsay's Blog All Rights Reserved.</p>
    </footer>
</body>
</html>