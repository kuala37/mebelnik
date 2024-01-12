<?php
    require_once '../../../include/db.php';
    try {  
    $categoryName = $_POST['categoryName'];

    $stmt = $pdo->prepare('INSERT INTO Category (name) VALUES (?)');
    $stmt->execute([$categoryName]);
        echo 'success';
    } catch (PDOException $e) {
        echo 'Ошибка добавления категории: ' . $e->getMessage();
    }

?>
