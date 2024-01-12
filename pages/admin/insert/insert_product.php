<?php
    require_once '../../../include/db.php';
    try {  
    $store = (int)$_POST['store'];
    $category = (int)$_POST['category'];
    $firm = (int)$_POST['firm'];
    $name = $_POST['name'];
    $guarantee = (int)$_POST['guarantee'];
    $price = (float)$_POST['price'];
    $credit = (int)$_POST['credit'];
    $in_payment = (float)$_POST['in_payment'] ?? null;
    $payment_for_month = (float)$_POST['payment_for_month'] ?? null;
    $description = $_POST['description'];

    $stmt = $pdo->prepare('INSERT INTO Product (id_store, id_category, id_firm, name, guarantee, price, credit, in_payment, payment_for_month,descr) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$store, $category, $firm, $name, $guarantee, $price, $credit, $in_payment, $payment_for_month,  $description]);


    $productId = $pdo->lastInsertId();

    $uploadDir = '../../../images/'; 
    $imageFileName = uniqid('product_image_') . '.jpg';
    
    $realDir = 'images/' . $imageFileName;
    $uploadFile = $uploadDir . $imageFileName;

   if (move_uploaded_file($_FILES['productImage']['tmp_name'], $uploadFile)) {

       $stmtImage = $pdo->prepare('UPDATE Product SET image_path = ? WHERE id_product = ?');
       $stmtImage->execute([$realDir, $productId]);
    } else {
       echo 'Ошибка при загрузке изображения.';
   }
        echo 'success';
    } catch (PDOException $e) {
        echo 'Ошибка добавления товара: ' . $e->getMessage();
    }
    header("Location: ../admin_page.php?data=Товары");
    exit();

?>
