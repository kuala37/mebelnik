<?php
    require_once '../include/db.php';

    $mail = "'" . filter_var(trim($_POST['mail']),FILTER_SANITIZE_STRING) . "'";
    $pass = filter_var(trim($_POST['pass']),FILTER_SANITIZE_STRING);

    $pass = md5($pass."ghjksa78235");
    $pass = "'". $pass . "'";


    $sql = $pdo->query('SELECT * FROM Users WHERE mail = ' . $mail . ' AND password = ' . $pass);
    $user = $sql->fetch();

    if(count($user )==0){
        echo "такой пользоватлеь не найден";
        exit();
    }
    session_start();
    $_SESSION['user'] = $user['id_user'];
    $_SESSION['role'] = $user['role'];
    session_write_close();


    header('Location: ../index.php');
    exit();

?>