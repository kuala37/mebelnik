<?php
require_once '../../../include/db.php';

    try {
        $id_firm = (int)$_POST['id_firm_update'];
        $name = $_POST['name-firm'];
        $country = $_POST['country-firm'];
        $phone = $_POST['phone-firm'];

        $stmt = $pdo->prepare('UPDATE Firms SET name = ?, country = ?, phone = ? WHERE id_firm = ?');
        $stmt->execute([$name, $country, $phone, $id_firm]);

        echo 'success';
    } catch (\PDOException $e) {
        echo 'Ошибка обновления фирмы: ' . $e->getMessage();    }

?>
