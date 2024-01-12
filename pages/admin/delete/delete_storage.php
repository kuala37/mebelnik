<?php
    require_once '../../../include/db.php';
    try {  
    $id_storage = $_POST['id'];
    $stmt = $pdo->prepare('DELETE FROM Storage WHERE id_storage = ?');
    $stmt->execute([$id_storage]);
        echo "success";
    } catch (PDOException $e) {
        echo 'Ошибка удаления склада: ' . $e->getMessage();    
    }

?>
