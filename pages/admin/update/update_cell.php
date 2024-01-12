<?php
require_once '../../../include/db.php';

    try {
        $id_cell = (int)$_POST['id_cell_update'];
        $count = $_POST['count'];

        $stmt = $pdo->prepare('UPDATE cell_product SET count = ? WHERE id_cell = ?');
        $stmt->execute([$count, $id_cell]);

        echo 'success';
    } catch (\PDOException $e) {
        echo 'Ошибка обновления ячейки: ' . $e->getMessage();    }

?>
