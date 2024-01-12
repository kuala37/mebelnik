<?php
    require_once '../../../include/db.php';
    try {  
    $store = $_POST['store'];
    $address = $_POST['address'];

    $stmt = $pdo->prepare('INSERT INTO Storage (id_store, address ) VALUES (?, ?)');
    $stmt->execute([$store, $address]);

    echo 'success';
    } catch (PDOException $e) {
        echo 'Ошибка добавления склада: ' . $e->getMessage();
    }
?>
