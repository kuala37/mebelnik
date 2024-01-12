<?php
    require_once '../../../include/db.php';
    try {  
    $id_store = $_POST['id'];
    $stmt = $pdo->prepare('DELETE FROM Store WHERE id_store = ?');
    $stmt->execute([$id_store]);
        echo "success";
    } catch (PDOException $e) {
        echo 'Ошибка удаления магазина: ' . $e->getMessage();    }

?>
