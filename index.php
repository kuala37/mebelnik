<?php
    require_once 'include/db.php';

    $categoryId = isset($_GET['category']) ? $_GET['category'] : null;
    $selectStore = isset($_GET['selectStore']) ? $_GET['selectStore'] : null;


    $sql = 'SELECT id_product, name, image_path, price, id_category FROM Product';
    
    if ($categoryId) {
        $sql .= ' WHERE id_category = ' . $categoryId;
    }

    if ($selectStore && $categoryId) {
        $sql .=   ' and id_store =' . $selectStore;
    }

    if ($selectStore &&  !$categoryId) {
        $sql .=   ' WHERE id_store =' . $selectStore;
    }

    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll();

    $stores = $pdo->query('SELECT id_store,name FROM Store')->fetchAll(PDO::FETCH_ASSOC);

    $stmtc = $pdo->query('SELECT * FROM category');
    $categorys = $stmtc->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>МЕБЕЛЬНИК - Поиск мебели</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom styles -->
    <link rel="stylesheet" href="css/styles.css">

</head>
<body>

<!-- Навигационная панель -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">
        <img src="images/logo.png" alt="Логотип" class="logo-img">
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
                    <a class="nav-link" href="pages/admin/admin_page.php">Админка</a>
                </li>
                <?php endif;?>

                <li class="nav-item">

                    <a class="nav-link" href="index.php">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">О нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Контакты</a>
                </li>
                <?php if($_SESSION['user'] ==''): ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Войти</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registration.php">Регистрация</a>
                </li>
                <?php else:?>
                <li class="nav-item">
                    <a class="nav-link" href="form_valid/exit.php">Выход</a>
                </li>
                <?php endif;?>
                <?php session_write_close();?>

            </ul>
        </div>
    </div>
</nav>

<!-- панель категорий -->
<div class="category-menu">
<div class="mt-3">
    <h5>Магазины</h5>
    <select class="form-control" id="storageSelect" onchange='window.location.href = "index.php?category=<?=$categoryId?>&selectStore=" + this.value ;'>
        <option value=0>Все магазины</option>
        <?php foreach ($stores as $store): ?>
            <option 
            <?php if($selectStore == $store['id_store']): echo 'selected'?> <?php endif;?>
             value="<?= $store['id_store'] ?>"><?= $store['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    </div>
    <div class="mt-3">
        <h5>Категории</h5>
        
        <p><a href="index.php?category=0&selectStore=<?=$selectStore?>" class="active" >Все категории</a></p>
        <?php foreach ($categorys as $category): ?>
            <p><a href="index.php?category=<?= $category['id_category']?>&selectStore=<?=$selectStore?>"  ><?= $category['name'] ?></a></p>
        <?php endforeach; ?>
    </div>
</div>


<!-- Основное содержимое страницы -->
<div class="main-product-content">
    <h2>Товары</h2>

    <div class="row">
        <!-- Вывод карточек товаров из базы данных -->
        <?php foreach ($products as $product): ?>
        <div class="card md-2 category-card">
            <!-- Верхняя часть -->
            <div class="card__top position-relative overflow-hidden">
                <!-- Изображение-ссылка товара -->
                <a href="pages/product/product_details.php?id=<?php echo $product['id_product']; ?>" class="card__image">
                    <img src="<?php echo $product['image_path']; ?>" class="card-img-top img-fluid" alt="Товар">
                </a>
            </div>
            <!-- Нижняя часть -->
            <div class="card__bottom d-flex flex-column flex-grow-1 p-3">
                <!-- Цены на товар -->
                <div class="card__prices d-flex mb-2">
                    <div class="card__price card__price--discount font-weight-bold font-size-19 text-dark">
                    <?php echo $product['price']; ?>
                    </div>
                </div>
                <!-- Ссылка-название товара -->
                <a href="pages/product/product_details.php?id=<?php echo $product['id_product']; ?>" class="card__title text-dark text-decoration-none mb-2">
                    <?php echo $product['name']; ?>
                </a>
                <a href="pages/product/product_details.php?id=<?php echo $product['id_product']; ?>" class="card__add btn btn-success mt-auto">Подробнее</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted">© 2024 МЕБЕЛЬНИК</span>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>
</html>
