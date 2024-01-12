<?php
require_once '../../../include/db.php';

    try {
        $id_storage = (int)$_POST['id_storage_update'];
        $store = (int)$_POST['store-storage'];
        $address = $_POST['address-storage'];


        $stmt = $pdo->prepare('UPDATE Storage SET id_store = ?, address = ?  WHERE id_storage = ?');
        $stmt->execute([$store,$address, $id_storage]);
    
        echo 'success';
    } catch (\PDOException $e) {
        echo 'Ошибка обновления склада: ' . $e->getMessage();    }

?>
