<?php
    session_start();

    $errors = $_SESSION['errors'] ?? [];
    $form_data = $_SESSION['form_data'] ?? [];

    function show_error($errors, $field) {
        return isset($errors[$field]) ? "<small style='color:red;'>{$errors[$field]}</small>" : '';
    }

    function old($form_data, $field) {
        return isset($form_data[$field]) ? htmlspecialchars($form_data[$field]) : '';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper">
        <?php include('subfolder/header.php'); ?>
        <main>
            <div class="container">
                <a href="index.php" class="back">Назад</a>
                <form action="php/registr.php" method="post">
                    <p>Придумайте логин</p>
                    <input type="text" name="login">
                    <?= show_error($errors, 'login') ?>
                    <p>Имя</p>
                    <input type="text" name="name">
                    <?= show_error($errors, 'name') ?>
                    <p>Телефон</p>
                    <input type="tel" name="phone">
                    <?= show_error($errors, 'phone') ?>
                    <p>Почта</p>
                    <input type="email" name="email">
                    <?= show_error($errors, 'email') ?>
                    <p>Придумайте пароль</p>
                    <input type="password" name="password">
                    <?= show_error($errors, 'password') ?>
                    <p>Повторите пароль</p>
                    <input type="password" name="confirm">
                    <?= show_error($errors, 'confirm') ?>
                    <button type="submit">Регистрация</button>
                        <?php
                            if (isset($_SESSION['error'])) {
                                foreach ($_SESSION['error'] as $error) {
                                    echo "<p style='color:red;'>$error</p>";
                                }
                                unset($_SESSION['error']);
                            }
                        ?>
                </form>
            </div>
        </main>
        <?php include('subfolder/footer.php'); ?>
    </div>
</body>
</html>