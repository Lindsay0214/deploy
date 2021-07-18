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
        <h1>登  入</h1>
    </div>

    <section>
        <?php
            if (!empty($_GET['errCode'])) {
            $code = $_GET['errCode'];
            $msg = 'Error';
            if ($code === '1') {
                $msg = '資料不齊全';
            } else if($code === '2'){
                $msg = '帳號或密碼有誤' ;
            }
            echo '<h2 class="error">錯誤：' . $msg . '</h2>';
            }
        ?>
        <form method="POST" action="./handle_login.php" class="login__box">
            <label for="uname">帳號</label>
            <input type="text" name="username" placeholder=" 請輸入您的帳號" />
            <label for="psw">密碼</label>
            <input type="password" name="password" placeholder=" 請輸入您的的密碼" />
            <button type="submit">登入</button><button><a href="./register.php">註冊</a></button>
        </form>
    </section>
    
    <footer>
        <p>Copyright © 2021 Lindsay's Blog All Rights Reserved.</p>
    </footer>
</body>
</html>