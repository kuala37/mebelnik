<?php
    require_once '../../../include/db.php';
    try {  
    $id_product = $_POST['id'];
    $stmt = $pdo->prepare('DELETE FROM product WHERE id_product = ?');
    $stmt->execute([$id_product]);
        echo "success";
    } catch (PDOException $e) {
        echo 'Ошибка удаления товара: ' . $e->getMessage();    
    }

?>

