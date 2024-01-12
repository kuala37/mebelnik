<?php
require_once '../../../include/db.php';

    try {
        $id_user = (int)$_POST['id_user_update'];
        $name = $_POST['name-user'];
        $role = (int)$_POST['role'];
 
        $stmt = $pdo->prepare('UPDATE Users SET name = ?, role = ? WHERE id_user = ?');
        $stmt->execute([$name, $role, $id_user]);

        echo 'success';
    } catch (\PDOException $e) {
        echo 'Ошибка обновления пользователя: ' . $e->getMessage();  
      }

?>
