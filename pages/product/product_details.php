<?php
    require_once '../../include/db.php';

    $stmtc = $pdo->query('SELECT * FROM category');
    $categorys = $stmtc->fetchAll();
?>

<!-- product_details.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детали товара</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom styles -->
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="../../index.php">
        <img src="../../images/logo.png" alt="Логотип" class="logo-img">
            МЕБЕЛЬНИК
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php
                session_start();
                 if ($_SESSION['role'] > 0) :?>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/admin_page.php">Админка</a>
                </li>
                <?php endif;?>

                <li class="nav-item">

                    <a class="nav-link" href="../../index.php">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">О нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Контакты</a>
                </li>
                <?php if($_SESSION['user'] ==''): ?>
                <li class="nav-item">
                    <a class="nav-link" href="../../login.php">Войти</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../registration.php">Регистрация</a>
                </li>
                <?php else:?>
                <li class="nav-item">
                    <a class="nav-link" href="../../form_valid/exit.php">Выход</a>
                </li>
                <?php endif;?>
                <?php session_write_close();?>

            </ul>
        </div>
    </div>
</nav>

<!-- панель категорий -->
<div class="category-menu">
    <h5>Категории</h5>
    <p><a href="../../index.php" class="active" data-category-id="">Все категории</a></p>
    <?php foreach ($categorys as $category): ?>
        <p><a href="../../index.php?category=<?= $category['id_category'] ?>" data-category-id="<?= $category['id_category'] ?>" ><?= $category['name'] ?></a></p>
    <?php endforeach; ?>
</div>

<!-- Основное содержимое страницы -->
<div class="container  main-content">
    <?php
    $productId = $_GET['id']; 

    $stmt = $pdo->prepare('SELECT * FROM product_page_view WHERE id_product = ?');
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    $stmt = $pdo->prepare('SELECT price*count as total FROM product_page_view WHERE id_product = ?');
    $stmt->execute([$productId]);
    $total_price =   $stmt->fetch();

    if ($product) {
        ?>
        <div class="row">
            <div class="col-md-5  ">
                <img src="<?php echo '../../'. $product['image_path']; ?>" class="img-fluid product-img" alt="Товар">
            </div>
            <div class="col-md-7">
                <h2><?php echo $product['product_name']; ?></h2>
                <div class="row">
                    <div class="col-4">
                        <p><span class="sec-title mb-3 mb-sm-4">Категория</span>
                    </div>
                    <div class="col-8">
                        <?php echo $product['category_name']; ?> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <p><span class="sec-title mb-3 mb-sm-4">Магазин</span>
                    </div>
                    <div class="col-8 sec-name">
                        <a href="#"  onclick="showStoreMod();"><?php echo $product['store_name']; ?> </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <p><span class="sec-title mb-3 mb-sm-4">Фирма</span>
                    </div>
                    <div class="col-8 sec-name">
                        <a href="#"  onclick="showFirmMod();"><?php echo $product['firm_name']; ?> </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <p><span class="sec-title mb-3 mb-sm-4">Страна-изготовитель</span>
                    </div>
                    <div class="col-8 ">
                        <?php echo $product['country']; ?> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <p><span class="sec-title mb-3 mb-sm-4">Гарантия(мес.)</span>
                    </div>
                    <div class="col-8 ">
                        <?php echo $product['guarantee']; ?> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <p><span class="sec-title mb-3 mb-sm-4">Наличие кредита</span>
                    </div>
                    <div class="col-8 ">
                        <?php if($product['credit']) {echo 'Да';} else{echo 'Нет';} ?> 
                    </div>
                </div>

                <?php if($product['credit'] ):  ?>
                <div class="row">
                    <div class="col-4">
                        <p><span class="sec-title mb-3 mb-sm-4">Первоначальный взнос</span>
                    </div>
                    <div class="col-8 ">
                        <?php echo $product['in_payment'] ?>₽
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <p><span class="sec-title mb-3 mb-sm-4">Оплата в месяц</span>
                    </div>
                    <div class="col-8 ">
                        <?php echo $product['payment_for_month']?>₽ 
                    </div>
                </div>
                <?php endif;?>

                <div class="row">
                    <div class="col-4">
                        <p><span class="sec-title mb-3 mb-sm-4">Количество на складе</span>
                    </div>
                    <div class="col-8 ">
                        <?php echo $product['count']; ?>
                    </div>
                </div>



                <div class="row">
                    <div class="col-4">
                        <p><span class="sec-title mb-3 mb-sm-4">Цена</span>
                    </div>
                    <div class="col-8">
                        <?php echo $product['price']; ?>₽ 
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <p><span class="sec-title mb-3 mb-sm-4">Общая цена</span>
                    </div>
                    <div class="col-8">
                        <?php echo $total_price['total']; ?>₽ 
                    </div>
                </div>
            </div>

              <div class="col-lg-12 mb-4 mb-sm-5">
                <div>
                    <span class="section-title text-primary mb-3 mb-sm-4">Описание</span>
                    <p class="lead"><?php echo $product['descr']; ?></p>
                </div>
            </div>

        </div>
    <?php } else { ?>
        <p>Товар не найден.</p>
    <?php } ?>
</div>

<!-- Магазин -->
<div class="modal fade" id="storeModal" tabindex="-1" role="dialog" aria-labelledby="storeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="mod-tit"><h5 class="modal-title sec-title" style="text-align:center;" id="storeModalLabel">Магазин</h5></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mod-body">
                <div class="row">

                    <div class="col-md-12">
                        <h2><?php echo $product['store_name']; ?></h2>
                        <div class="row">
                            <div class="col-4">
                                <p><span class="sec-title mb-3 mb-sm-4">Адрес:</span>
                            </div>
                            <div class="col-8">
                                <?php echo $product['address']; ?> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <p><span class="sec-title mb-3 mb-sm-4">Телефон:</span>
                            </div>
                            <div class="col-8">
                                <?php echo $product['store_phone']; ?> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <p><span class="sec-title mb-3 mb-sm-4">Часы работы:</span>
                            </div>
                            <div class="col-8">
                                <?php echo $product['hours_work']; ?> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <p><span class="sec-title mb-3 mb-sm-4">Фамилия администратора:</span>
                            </div>
                            <div class="col-8">
                                <?php echo $product['last_name_admin']; ?> 
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Фирма -->
<div class="modal fade" id="firmModal" tabindex="-1" role="dialog" aria-labelledby="firmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="mod-tit"><h5 class="modal-title sec-title" style="text-align:center;" id="firmModalLabel">Фирма</h5></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mod-body">
                <div class="row">

                    <div class="col-md-12">
                        <h2><?php echo $product['firm_name']; ?></h2>
                        <div class="row">
                            <div class="col-4">
                                <p><span class="sec-title mb-3 mb-sm-4">Страна:</span>
                            </div>
                            <div class="col-8">
                                <?php echo $product['country']; ?> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <p><span class="sec-title mb-3 mb-sm-4">Телефон:</span>
                            </div>
                            <div class="col-8">
                                <?php echo $product['firm_phone']; ?> 
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted">© 2024 МЕБЕЛЬНИК</span>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function showStoreMod(){
        $('#storeModal').modal('show');
    }
    function showFirmMod(){
        $('#firmModal').modal('show');
    }

</script>
</body>
</html>
