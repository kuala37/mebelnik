<?php
    require_once '../../../include/db.php';
    try {  
    $firmName = $_POST['firmName'];
    $country = $_POST['country'];
    $phone =$_POST['phone'];

        
    $stmt = $pdo->prepare('INSERT INTO Firms (name, country, phone) VALUES (?, ?, ?)');
    $stmt->execute([$firmName, $country, $phone]);
        echo 'success';
    } catch (PDOException $e) {
        echo 'Ошибка добавления фирмы: ' . $e->getMessage();
    }

?>
