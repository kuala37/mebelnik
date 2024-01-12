<?php
    require_once '../../include/db.php';

session_start();
$pass = $pdo->query('SELECT password FROM db_pass')->fetch(PDO::FETCH_ASSOC)['password'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredPassword = $_POST['password']; // Получаем введенный пользователем пароль
    $enteredPassword = md5($enteredPassword."ghjksa78235");

    // Здесь проверьте введенный пароль и установите флаг аутентификации в сессии, если пароль верен.
    // Иначе, отобразите сообщение об ошибке.
    if ($enteredPassword === $pass) {
        $_SESSION['authenticated'] = true;
    } else {
        $error = "Неверный пароль. Попробуйте еще раз.";
    }
}

// Если пользователь не аутентифицирован, отобразите форму ввода пароля
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Вход в админку</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>

    <div class="container mt-5">
        <h2>Вход в админку</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="admin_page.php">
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Войти</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>
    </html>

    <?php
    exit(); 
}
?>




<?php
    try {
    $punctID = isset($_GET['data']) ? $_GET['data'] : null;
    $selectPunct = isset($_GET['pod']) ? $_GET['pod'] : null;

    switch ($punctID) {
        case null:
            break;
        case 'Магазины':
            $data_table =  $pdo->query('SELECT * FROM Store')->fetchAll(PDO::FETCH_ASSOC); 
            break;
        case 'Товары':
            $stores = $pdo->query('SELECT id_store,name FROM Store')->fetchAll(PDO::FETCH_ASSOC);
            $categories = $pdo->query('SELECT id_category, name FROM Category')->fetchAll(PDO::FETCH_ASSOC);
            $firms = $pdo->query('SELECT id_firm, name FROM Firms')->fetchAll(PDO::FETCH_ASSOC);
            $data_table =  $pdo->query('SELECT * FROM product_table_view ')->fetchAll(PDO::FETCH_ASSOC); 
            break;
        case 'Фирмы':
            $data_table =  $pdo->query('SELECT * FROM Firms')->fetchAll(PDO::FETCH_ASSOC); 
            break;
        case 'Категории':
            $data_table =  $pdo->query('SELECT * FROM Category')->fetchAll(PDO::FETCH_ASSOC); 
            break;
        case 'Склады':
            $stores = $pdo->query('SELECT id_store,name FROM Store')->fetchAll(PDO::FETCH_ASSOC);
            $data_table = $pdo->query('SELECT * FROM storage_table_view ')->fetchAll(PDO::FETCH_ASSOC);
            break;       
         case 'Товар_на_складе':
            $storages = $pdo->query('SELECT id_storage, address FROM Storage')->fetchAll(PDO::FETCH_ASSOC);
            $sql = ('SELECT * FROM storage_cell_table_view ');
            if ($selectPunct) {
                $sql .= ' WHERE id_storage = ' . $selectPunct;
            }
            $data_table = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            break;       
         case 'Пользователи':
            $data_table =  $pdo->query('SELECT * FROM Users')->fetchAll(PDO::FETCH_ASSOC); 
            break;  
        case 'Пароль':
                $data_table = $pdo->query('SELECT * FROM db_pass')->fetchAll(PDO::FETCH_ASSOC); 
                break;  

    }

    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
?>


<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление магазинами</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/styles.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="../../js/java.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</head>
<body >

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
                    <a class="nav-link" href="admin_page.php">Админка</a>
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

<?php session_start(); if ($_SESSION['role'] > 0) :?>

<div class="category-menu">
    <h5>Данные</h5>
    <p><a href="admin_page.php?data=Магазины" >Магазины</a></p>
    <p><a href="admin_page.php?data=Товары" >Товар</a></p>
    <p><a href="admin_page.php?data=Фирмы" >Фирмы</a></p>
    <p><a href="admin_page.php?data=Категории" >Категории</a></p>
    <p><a href="admin_page.php?data=Склады" >Склады</a></p>
    <p><a href="admin_page.php?data=Товар_на_складе" >Товар на складе</a></p>
    <?php session_start(); if ($_SESSION['role'] == 2) :?>
    <p><a href="admin_page.php?data=Пользователи" >Пользователи</a></p>
    <p><a href="admin_page.php?data=Пароль" >Пароль админки</a></p>
    <?php session_write_close(); endif;?>
    
</div>



<div class="main-content" style=" overflow-x: scroll; ">
    <h2>Управление данными</h2>


 <!-- Таблица данных выбранного пункта  -->

    <?php if($punctID && $data_table ): ?>

    <?php session_start(); if (!(($punctID == 'Пользователи' || $punctID == 'Пароль') &&  $_SESSION['role'] != 2 )) :?>


    <?php if(!($punctID == 'Товар_на_складе' || $punctID == 'Пароль')) :?>
    <button  class="btn btn-primary" onclick="ShowForm('<?=$punctID?>')">Добавить</button>
    <?php endif;?>

    <!-- Выбор конкретного склада для товара -->
    <?php if($punctID == 'Товар_на_складе'):  ?>
    <div class="container mt-3">
    <label for="storageSelect">Выберите склад с адресом:</label>
    <select class="form-control" id="storageSelect" onchange='window.location.href = "admin_page.php?data=Товар_на_складе&pod=" + this.value ;'>
        <option value=0>Все склады</option>
        <?php foreach ($storages as $storage): ?>
            <option 
            <?php if($selectPunct == $storage['id_storage']): echo 'selected'?> <?php endif;?>
             value="<?= $storage['id_storage'] ?>"><?= $storage['address'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    </div>
    <?php endif;?>

 <!-- Таблица с данными -->
    <div class="container mt-3 data-table" id="DataTable">
        <table class="table table-hover" id="dtBasicExample">
        <h2><?php echo $punctID;?> </h2>
            <thead>
                <tr>
                    <?php foreach (array_keys($data_table[0]) as $column): ?>
                        <th class="th-sm"><?= $column ?></th>
                    <?php endforeach; ?>
                    <th>Действия</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_table as $data): ?>
                    <tr>
                        <?php foreach ($data as $value): ?>
                            <td><?= $value ?></td>
                        <?php endforeach; ?>
                        <td class="btn-td">
                            
                            <?php if($punctID == 'Магазины'):  ?>
                            <button class="btn btn-warning" onclick='editStore(<?=json_encode($data)?>)'>Редактировать</button>
                            <button class="btn btn-danger delete-row-store"  onclick="deleteStore(<?= $data['id_store'] ?>)">Удалить</button>
                            
                            <?php elseif($punctID == 'Товары'):  ?>
                            <button class="btn btn-warning" onclick='editProduct(<?=json_encode($data)?>)'>Редактировать</button>
                            <button class="btn btn-danger delete-row-product" onclick="deleteProduct(<?= $data['id_product'] ?>)">Удалить</button>

                            <?php elseif($punctID == 'Фирмы'):  ?>
                            <button class="btn btn-warning" onclick='editFirm(<?=json_encode($data)?>)'>Редактировать</button>
                            <button class="btn btn-danger delete-row-store" onclick="deleteFirm(<?=$data['id_firm']?>)">Удалить</button>

                            <?php elseif($punctID == 'Категории'):  ?>
                            <button class="btn btn-warning" onclick='editCategory(<?=json_encode($data)?>)'>Редактировать</button>
                            <button class="btn btn-danger delete-row-store"  onclick="deleteCategory(<?=$data['id_category']?>)">Удалить</button>

                            <?php elseif($punctID == 'Склады'):  ?>
                            <button class="btn btn-warning" onclick='editStorage(<?=json_encode($data)?>)'>Редактировать</button>
                            <button class="btn btn-danger delete-row-store"  onclick="deleteStorage(<?=$data['id_storage']?>)">Удалить</button>

                            <?php elseif($punctID == 'Товар_на_складе'):  ?>
                            <button class="btn btn-warning" onclick='editCell(<?=json_encode($data)?>)'>Редактировать</button>


                            <?php elseif($punctID == 'Пользователи'):  ?>
                            <button class="btn btn-warning" onclick='editUser(<?=json_encode($data)?>)'>Редактировать</button>
                            <button class="btn btn-danger delete-row-store"  onclick="deleteUser(<?=$data['id_user']?>)">Удалить</button>

                            <?php elseif($punctID == 'Пароль'):  ?>
                            <button class="btn btn-warning" onclick='editPass(<?=json_encode($data)?>)'>Редактировать</button>
                            <?php endif;?>
                            

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else:?>
    <H2>У ВАС НЕТ ПРАВ ЗДЕСЬ НАХОДИТСЯ</H2>
    <?php session_write_close(); endif;?>

    <?php endif;?>
</div>

<!-- Модальные окна для редактирования -->

<!-- Редактирование магазинов -->
<div class="modal fade" id="editStoreModal" tabindex="-1" role="dialog" aria-labelledby="editStoreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStoreModalLabel">Редактировать данные</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  method="post" id="storeFormUpdate"   >
                    <div class="form-group">
                    <input type="hidden"  id="id_store_update" name="id_store_update">
                    </div>
                    <div class="form-group">
                        <label for="name">Название магазина:</label>
                        <input type="text" class="form-control" id="name-store" name="name-store" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Адрес:</label>
                        <input type="text" class="form-control" id="address-store" name="address-store" required>
                    </div>
                    <div class="form-group">
                        <label for="hours_work">Часы работы:</label>
                        <input type="text" class="form-control" id="hours_work-store" name="hours_work-store">
                    </div>
                    <div class="form-group">
                        <label for="phone">Телефон:</label>
                        <input type="tel" class="form-control" id="phone-store" name="phone-store">
                    </div>
                    <div class="form-group">
                        <label for="last_name_admin">Фамилия администратора:</label>
                        <input type="text" class="form-control" value="" id="last_name_admin-store" name="last_name_admin-store">
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Редактирование товара -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Редактировать данные</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form   method="post" id="productFormUpdate" >
                <div class="form-group">
                    <input type="hidden"  id="id_product_update" name="id_product_update">
                    </div>
                <div class="form-group">
                    <label for="store-product">Выберите магазин:</label>
                    <select class="form-control" id="store-product" name="store-product" required>
                        <?php foreach ($stores as $store): ?>
                            <option value="<?= $store['id_store'] ?>"><?= $store['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category-product">Выберите категорию товара:</label>
                    <select class="form-control" id="category-product" name="category-product" required>
                        <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id_category'] ?>"><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="firm-product">Выберите фирму производителя:</label>
                    <select class="form-control" id="firm-product" name="firm-product" required>
                        <?php foreach ($firms as $firm): ?>
                            <option value="<?= $firm['id_firm'] ?>"><?= $firm['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name-product">Название товара:</label>
                    <input type="text" class="form-control" id="name-product" name="name-product" required>
                </div>
                <div class="form-group">
                    <label for="description-product">Описание товара:</label>
                    <textarea class="form-control" id="description-product" name="description-product" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="guarantee-product">Гарантия (в месяцах):</label>
                    <input type="number" class="form-control" id="guarantee-product" name="guarantee-product" required>
                </div>
                <div class="form-group">
                    <label for="price-product">Цена (руб.):</label>
                    <input type="number" class="form-control" id="price-product" name="price-product" required>
                </div>
                <div class="form-group">
                    <label for="credit">Возможность кредита:</label>
                    <select class="form-control" id="credit" name="credit" required>
                        <option value="1">Да</option>
                        <option value="0">Нет</option>

                    </select>
                </div>
                <div id="creditForms">
                    <div class="form-group">
                        <label for="in_payment">Сумма для оплаты в рассрочку (руб.):</label>
                        <input type="number" class="form-control" id="in_payment" name="in_payment">
                    </div>
                    <div class="form-group">
                        <label for="payment_for_month">Ежемесячный платеж по рассрочке (руб.):</label>
                        <input type="number" class="form-control" id="payment_for_month" name="payment_for_month">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
            </div>
        </div>
    </div>
</div>


<!-- Редактирование фирм -->
<div class="modal fade" id="editFirmModal" tabindex="-1" role="dialog" aria-labelledby="editFirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFirmModalLabel">Редактировать данные</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form  method="post" id="firmFormUpdate" >
                <div class="form-group">
                    <input type="hidden"  id="id_firm_update" name="id_firm_update">
                </div>
                <div class="form-group">
                    <label for="name-firm">Название фирмы:</label>
                    <input type="text" class="form-control" id="name-firm" name="name-firm" required>
                </div>
                <div class="form-group">
                    <label for="country-firm">Страна:</label>
                    <input type="text" class="form-control" id="country-firm" name="country-firm" required>
                </div>
                <div class="form-group">
                    <label for="phone-firm">Телефон:</label>
                    <input type="tel" class="form-control" id="phone-firm" name="phone-firm">
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
             </form>
            </div>
        </div>
    </div>
</div>

<!-- Редактирование категорий -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Редактировать данные</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form  method="post" id="categoryFormUpdate" >
            <div class="form-group">
                <input type="hidden"  id="id_category_update" name="id_category_update">
            </div>
            <div class="form-group">
                <label for="name-category">Название категории:</label>
                <input type="text" class="form-control" id="name-category" name="name-category" required>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
            </div>
        </div>
    </div>
</div>

<!-- Редактирование паролей -->
<div class="modal fade" id="editPassModal" tabindex="-1" role="dialog" aria-labelledby="editPassModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPassModalLabel">Редактировать данные</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form  method="post" id="passFormUpdate" >
            <div class="form-group">
                <input type="hidden"  id="id_pass_update" name="id_pass_update">
            </div>
            <div class="form-group">
                    <label for="pass">Новый пароль:</label>
                    <input type="password" class="form-control" id="pass" name="pass" required>
                </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
            </div>
        </div>
    </div>
</div>

<!-- Редактирование складов -->
<div class="modal fade" id="editStorageModal" tabindex="-1" role="dialog" aria-labelledby="editStorageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStorageModalLabel">Редактировать данные</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form   method="post" id="storageFormUpdate" >
                <div class="form-group">
                    <input type="hidden"  id="id_storage_update" name="id_storage_update">
                </div>
                <div class="form-group">
                    <label for="store-storage">Выберите магазин:</label>
                    <select class="form-control" id="store-storage" name="store-storage" required>
                        <?php foreach ($stores as $store): ?>
                            <option value="<?= $store['id_store'] ?>"><?= $store['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                        <label for="address-storage">Адрес:</label>
                        <input type="text" class="form-control" id="address-storage" name="address-storage" required>
                    </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
            </div>
        </div>
    </div>
</div>

<!-- Редактирование товара на складе -->
<div class="modal fade" id="editCellModal" tabindex="-1" role="dialog" aria-labelledby="editCellModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCellModalLabel">Редактировать данные</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form  method="post" id="cellFormUpdate" >
                <div class="form-group">
                    <input type="hidden"  id="id_cell_update" name="id_cell_update">
                </div>
                <div class="form-group">
                    <label for="count">Количество:</label>
                    <input type="number" class="form-control" id="count" name="count" >
                </div>
                <button type="submit" class="btn btn-primary">Сохранить </button>

            </form>
            </div>
        </div>
    </div>
</div>

<!-- Редактирование пользователей -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Редактировать пользователей</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form   method="post" id="userFormUpdate" >
                <div class="form-group">
                    <input type="hidden"  id="id_user_update" name="id_user_update">
                </div>
                <div class="form-group">
                        <label for="name-user">Имя:</label>
                        <input type="text" class="form-control" id="name-user" name="name-user" required>
                </div>
                <div class="form-group">
                    <label for="role">Права:</label>
                    <input type="number" class="form-control" id="role" name="role" required>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
            </div>
        </div>
    </div>
</div>

<!-- Модальные окна для добавления -->

<!-- Добавление фирм -->
<div class="modal fade" id="addFirmModal" tabindex="-1" role="dialog" aria-labelledby="addFirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFirmModalLabel">Добавить данные</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <form  method="post" id="firmFormAdd" >
                    <h2>Добавление новой фирмы</h2>
                    <div class="form-group">
                        <label for="firmName">Название фирмы:</label>
                        <input type="text" class="form-control" id="firmName" name="firmName" required>
                    </div>
                    <div class="form-group">
                        <label for="country">Страна:</label>
                        <input type="text" class="form-control" id="country" name="country" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Телефон:</label>
                        <input type="tel" class="form-control" id="phone" name="phone">
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить фирму</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Добавление товара -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Добавить данные</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form  action="insert/insert_product.php" method="post" enctype="multipart/form-data" id="productFormAdd"  >
        <h2>Добавление нового товара</h2>
        <div class="form-group">
            <label for="store">Выберите магазин:</label>
            <select class="form-control" id="store" name="store" required>
                <?php foreach ($stores as $store): ?>
                    <option value="<?= $store['id_store'] ?>"><?= $store['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="category">Выберите категорию товара:</label>
            <select class="form-control" id="category" name="category" required>
                <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id_category'] ?>"><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="firm">Выберите фирму производителя:</label>
            <select class="form-control" id="firm" name="firm" required>
                <?php foreach ($firms as $firm): ?>
                    <option value="<?= $firm['id_firm'] ?>"><?= $firm['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="name">Название товара:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Описание товара:</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="productImage">Изображение товара:</label>
            <input type="file" class="form-control-file" id="productImage" name="productImage" accept="image/*" required>
        </div>
        <div class="form-group">
            <label for="guarantee">Гарантия (в месяцах):</label>
            <input type="number" class="form-control" id="guarantee" name="guarantee" required>
        </div>
        <div class="form-group">
            <label for="price">Цена (руб.):</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="credit">Возможность кредита:</label>
            <select class="form-control" id="credit" name="credit" required>
                <option value="1">Да</option>
                <option value="0">Нет</option>

            </select>
        </div>
        <div id="creditForms">
            <div class="form-group">
                <label for="in_payment">Сумма для оплаты в рассрочку (руб.):</label>
                <input type="number" class="form-control" id="in_payment" name="in_payment">
            </div>
            <div class="form-group">
                <label for="payment_for_month">Ежемесячный платеж по рассрочке (руб.):</label>
                <input type="number" class="form-control" id="payment_for_month" name="payment_for_month">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Добавить товар</button>
    </form>
            </div>
        </div>
    </div>
</div>

<!-- Добавление магазина -->
<div class="modal fade" id="addStoreModal" tabindex="-1" role="dialog" aria-labelledby="addStoreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStoreModalLabel">Добавить данные</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form  method="post" id="storeFormAdd"   >
            <h2>Добавление нового магазина</h2>
            <div class="form-group">
                <label for="name">Название магазина:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="address">Адрес:</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="hours_work">Часы работы:</label>
                <input type="text" class="form-control" id="hours_work" name="hours_work">
            </div>
            <div class="form-group">
                <label for="phone">Телефон:</label>
                <input type="tel" class="form-control" id="phone" name="phone">
            </div>
            <div class="form-group">
                <label for="last_name_admin">Фамилия администратора:</label>
                <input type="text" class="form-control" id="last_name_admin" name="last_name_admin">
            </div>
            <button type="submit" class="btn btn-primary">Добавить магазин</button>
        </form>
            </div>
        </div>
    </div>
</div>

<!-- Добавление категории -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Добавить данные</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form  method="post" id="categoryFormAdd"   >
                <h2>Добавление новой категории</h2>
                <div class="form-group">
                    <label for="categoryName">Название категории:</label>
                    <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                </div>
                <button type="submit" class="btn btn-primary">Добавить категорию</button>
        </form>
            </div>
        </div>
    </div>
</div>

<!-- Добавление пользователя -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Добавить данные</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form  method="post" id="userFormAdd"   >
                <h2>Добавление нового пользователя</h2>
                <div class="form-group">
                    <label for="user-name">Имя:</label>
                    <input type="text" class="form-control" id="user-name" name="user-name" required>
                </div>
                <div class="form-group">
                    <label for="mail">Почта:</label>
                    <input type="email" class="form-control" id="mail" name="mail" required>
                </div>
                <div class="form-group">
                    <label for="pass">Пароль:</label>
                    <input type="password" class="form-control" id="pass" name="pass" required>
                </div>
                <button type="submit" class="btn btn-primary">Добавить пользователя</button>
        </form>
            </div>
        </div>
    </div>
</div>

<!-- Добавление склада -->
<div class="modal fade" id="addStorageModal" tabindex="-1" role="dialog" aria-labelledby="addStorageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStorageModalLabel">Добавить данные</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form  method="post" id="storageFormAdd"   >
                    <h2>Добавление нового склада</h2>
                <div class="form-group">
                    <label for="store">Выберите магазин:</label>
                    <select class="form-control" id="store" name="store" required>
                        <?php foreach ($stores as $store): ?>
                            <option value="<?= $store['id_store'] ?>"><?= $store['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                        <label for="address">Адрес:</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                <button type="submit" class="btn btn-primary">Добавить склад</button>
            </form>
            </div>
        </div>
    </div>
</div>

<?php else:?>

<div class="main-content" >
    <H2>У ВАС НЕТ ПРАВ ЗДЕСЬ НАХОДИТСЯ</H2>
</div>
<?php endif;?>
<?php session_write_close();?>

<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted">© 2024 МЕБЕЛЬНИК</span>
    </div>
</footer>



</body>
</html>
