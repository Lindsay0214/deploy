<?php
    require_once('conn.php');

    $sql = sprintf("SELECT * FROM lindsay_articles ORDER BY lindsay_articles.id desc");
    $result = $conn->query($sql);
    if(!$result){
        die($conn->error);
    }
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
        <span><a href="./index.php" class="back"> < 返回</a></span>
        <h1>文章列表</h1>
    </div>

    <section>
        <?php while($row = $result->fetch_assoc()){ ?>
            <div class="articles">
                <div class="article">
                    <h2><?php echo $row['title']; ?></h2>
                    <div class="time"><?php echo $row['created_at']; ?></div>
                    <p><?php echo $row['content']; ?></p>
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