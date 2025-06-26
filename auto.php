<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper">
        <?php include('subfolder/header.php'); ?>
        <main>
            <div class="container">
                <a href="index.php" class="back">Назад</a>
                <form action="php/auto.php" method="post">
                    <p>Введите логин</p>
                    <input type="text" name="login">
                    <p>Введите пароль</p>
                    <input type="password" name="password">
                    <?php
                        if (isset($_SESSION['error'])) {
                            foreach ($_SESSION['error'] as $error) {
                                echo "<small style='color:red;text-align: center'>$error</small>";
                            }
                            unset($_SESSION['error']);
                        }
                    ?>
                    <button type="submit">Войти</button>
                </form>
            </div>
        </main>
        <?php include('subfolder/footer.php'); ?>
    </div>
    
</body>
</html>