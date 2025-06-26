<?php
    session_start();
    require_once 'connect.php';

    $errors = [];
    $name = $_POST['name'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    
    if (empty($login) || strlen($login) < 6) {
        $errors['login'] = 'Логин должен быть не менее 6 символов';
    }

    if (empty($name)) {
        $errors['name'] = 'Имя обязательно';
    }

    if (empty($phone)) {
        $errors['phone'] = 'Телефон обязателен';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Неверный формат email';
    }

    if (strlen($password) < 8) {
        $errors['password'] = 'Пароль должен быть не менее 8 символов';
    }

    if ($password !== $confirm) {
        $errors['confirm'] = 'Пароли не совпадают';
    }

    if (empty($errors)) {
        $stmt = $connect->prepare("SELECT * FROM users WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors['login'] = 'Такой логин уже существует';
        }
    }

    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $connect->prepare("INSERT INTO users (login, full_name, phone, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $login, $name, $phone, $email, $password_hash);
        $stmt->execute();

        $_SESSION['user_id'] = $connect->insert_id;
        header('Location: ../user_main.php');
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header('Location: ../registr.php');
        exit();
    }