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
        <h1>註  冊</h1>
    </div>

    <section>
    <div class="article" style="border: 1px solid white;">
        <?php
            if(!empty($_GET['errCode'])){
            $code = $_GET['errCode'];
            $msg = 'Error';
            if($code === '1'){
                    $msg = '資料請輸入完整';
                } else if ($code === '2') {
                    $msg = '帳號已被註冊';
                  }
                echo '<h2 class="error" style="padding-left: 200px">' . $msg . '</h2>';
            }
        ?>
        <form method="POST" action="./handle_register.php" class="login__box">
            <label>暱稱</label>
            <input type="text" name="nickname" placeholder=" Enter your nickname" required>
            <label>帳號</label>
            <input type="text" name="username" placeholder=" 註冊時請勿使用任何真實的帳號" required>
            <label>密碼</label>
            <input type="password" name="password" placeholder=" 註冊時請勿使用任何真實的密碼" required>
            <input class="button" type="submit" />
        </form>
        </div>
    </section>
    
    <footer>
        <p>Copyright © 2021 Lindsay's Blog All Rights Reserved.</p>
    </footer>
</body>
</html>