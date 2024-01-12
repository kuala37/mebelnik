<?php
require_once '../../../include/db.php';

    try {
        $id_store = (int)$_POST['id_store_update'];
        $name = $_POST['name-store'];
        $address = $_POST['address-store'];
        $hours_work = $_POST['hours_work-store'];
        $phone = $_POST['phone-store'];
        $last_name_admin = $_POST['last_name_admin-store'];


        $stmt = $pdo->prepare('UPDATE Store SET name = ?, address = ?, hours_work = ?, phone = ?, last_name_admin = ? WHERE id_store = ?');
        $stmt->execute([$name, $address, $hours_work, $phone, $last_name_admin, $id_store]);

        echo 'success';
    } catch (\PDOException $e) {
        echo 'Ошибка обновления магазина: ' . $e->getMessage();    }

?>
