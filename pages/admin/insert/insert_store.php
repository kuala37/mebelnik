<?php
    require_once '../../../include/db.php';

    try {  
        $name = $_POST['name'];
        $address = $_POST['address'];
        $hours_work = $_POST['hours_work'];
        $phone = $_POST['phone'];
        $last_name_admin = $_POST['last_name_admin'];
    
        // Подготовка запроса для вставки данных
        $query = $pdo->prepare("INSERT INTO Store (name, address, hours_work, phone, last_name_admin) VALUES (?, ?, ?, ?, ?)");
        $query->execute([$name, $address, $hours_work, $phone, $last_name_admin]);
    
        echo 'success';
    } catch (PDOException $e) {
        echo 'Ошибка добавления магазина: ' . $e->getMessage();
    }

?>
