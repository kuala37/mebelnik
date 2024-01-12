<?php
    require_once '../../../include/db.php';
    try {  
    $id_firm = $_POST['id'];
    $stmt = $pdo->prepare('DELETE FROM Firms WHERE id_firm = ?');
    $stmt->execute([$id_firm]);
        echo "success";
    } catch (PDOException $e) {
        echo 'Ошибка удаления фирмы: ' . $e->getMessage();    
    }

?>
