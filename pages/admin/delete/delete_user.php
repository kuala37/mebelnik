<?php
    require_once '../../../include/db.php';
    try {  
    $id_user = $_POST['id'];
    $stmt = $pdo->prepare('DELETE FROM Users WHERE id_user = ?');
    $stmt->execute([$id_user]);
        echo "success";
    } catch (PDOException $e) {
        echo 'Ошибка удаления пользователя: ' . $e->getMessage();    }

?>
