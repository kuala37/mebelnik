<?php
require_once '../../../include/db.php';

    try {
        $id_product = (int)$_POST['id_product_update'];
        $store = $_POST['store-product'];
        $category = $_POST['category-product'];
        $firm = $_POST['firm-product'];
        $name = $_POST['name-product'];
        $guarantee = (int)$_POST['guarantee-product'];
        $price = (float)$_POST['price-product'];
        $credit = $_POST['credit'];
        $in_payment = (float)$_POST['in_payment'] ?? null;
        $payment_for_month = (float)$_POST['payment_for_month'] ?? null;
        $description = $_POST['description-product'];

        $stmt = $pdo->prepare('UPDATE Product SET id_store=?, id_category=?, id_firm =?, name=?, guarantee=?, price=?, credit=?, in_payment=?, payment_for_month=?,descr=? WHERE id_product = ?');
        $stmt->execute([$store, $category, $firm, $name, $guarantee, $price, $credit, $in_payment, $payment_for_month,  $description,$id_product]);
    
        echo 'success';
    } catch (\PDOException $e) {
        echo 'Ошибка обновления товара: ' . $e->getMessage();    }

?>
