<?php
    session_start();
    require_once('conn.php');
    require_once('utils.php');

    if(empty($_POST['title']) || empty($_POST['content'])){
        header('Location: edit_article.php?errCode=1&id='.$_POST['id']);
        die('修改不得為空');
    }

    $username = $_SESSION['username'];
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "update lindsay_articles set title=? and content=? where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $title, $content, $id);
    $result = $stmt->execute();
    if(!$result){
        die($conn->error);
    }

    header("Location: success.php");
?>
