<?php
    require_once '../../../include/db.php';
    try {  
    $id_category = $_POST['id'];
    $stmt = $pdo->prepare('DELETE FROM Category WHERE id_category = ?');
    $stmt->execute([$id_category]);
        echo "success";
    } catch (PDOException $e) {
        echo 'Ошибка удаления категории: ' . $e->getMessage();    
    }

?>
