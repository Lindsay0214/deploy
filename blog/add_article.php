<?php
    require_once('conn.php');
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
        <h1>新增文章</h1>
    </div>

    <section>
        
        <div class="article">
            <?php
                if(!empty($_GET['errCode'])){
                $code = $_GET['errCode'];
                $msg = 'Error';
                if($code === '1'){
                        $msg = '請輸入標題';
                    } else if($code === '2'){
                        $msg = '請輸入內容';
                    }
                    echo '<h2 class="error">' . $msg . '</h2>';
                }
            ?>
                <h2>新增文章</h2>
                <br>
                <form method="POST" action="./handle_add_article.php">
                    <div class="add__title">
                        <h2 style="font-weight: 300; margin-bottom: 10px;">標題</h2>
                        <input type="text" name="title" style="width: 500px">
                    </div>
                    <div class="add__content">
                        <h2 style="font-weight: 300; margin-bottom: 10px;">內容</h2>
                        <textarea type="text" name="content" rows="10" .textarea></textarea>
                    </div>
                    <button class="add__content__btn" type="submit" style="border: 3px #faedcd solid;">確定新增</div>
                </form>
        </div>
    </section>
    
    <footer>
        <p>Copyright © 2021 Lindsay's Blog All Rights Reserved.</p>
    </footer>
</body>
</html>