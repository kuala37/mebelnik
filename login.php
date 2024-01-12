

<!doctype html>
<html lang="ru">
  <head>
    <!-- Обязательные метатеги -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/asd.css" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/java.js"></script>
    
    <title>МЕБЕЛЬНИК-Вход</title>

   
  </head>
  <body >
  <section class="vh-100">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Вход</h2>

              <form method="post" action="form_valid/authentication.php">


                <div class="form-outline mb-4">
                  <input type="email" name="mail" id="mail" class="form-control form-control-lg" />
                  <label class="form-label" for="mail">Почта</label>
                </div>

                <div class="form-outline mb-4">
                  <input type="password" name="pass" id="pass" class="form-control form-control-lg" />
                  <label class="form-label" for="pass">Пароль</label>
                </div>

                
                <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-secondary btn-lg">Авторизоваться</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
 </body>

</html>