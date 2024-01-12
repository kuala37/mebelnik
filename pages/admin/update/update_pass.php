<?php
require_once '../../../include/db.php';

    try {
        $id_pass = (int)$_POST['id_pass_update'];
        $pass = $_POST['pass'];
        $pass = md5($pass."ghjksa78235");


        $stmt = $pdo->prepare('UPDATE db_pass SET password = ? WHERE id_pass = ?');
        $stmt->execute([$pass, $id_pass]);

        echo 'success';
    } catch (\PDOException $e) {
        echo 'Ошибка обновления категории: ' . $e->getMessage();    }

?>
