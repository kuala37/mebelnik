<?php
require_once '../../../include/db.php';

    try {
        $id_category = (int)$_POST['id_category_update'];
        $name = $_POST['name-category'];

        $stmt = $pdo->prepare('UPDATE Category SET name = ? WHERE id_category = ?');
        $stmt->execute([$name, $id_category]);

        echo 'success';
    } catch (\PDOException $e) {
        echo 'Ошибка обновления категории: ' . $e->getMessage();    }

?>
