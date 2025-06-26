<?php
    session_start();
    require_once 'connect.php';

    $error = [];
    $login = $_POST['login'];
    $password = $_POST['password'];

    if($login == 'admin' && $password == 'admin'){
        $_SESSION['admin_role'] = true;
        header('Location: ../admin.php');
        exit();
    }
    if(empty($login) || empty($password)){
        $error[]= 'Все поля должны быть заполнены';
    }
    if(empty($error)){
        $result= mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");
        $user = mysqli_fetch_assoc($result);
        if($user && password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            header('Location: ../user_main.php');
            exit();
        }else{
            $error[]= 'неверный логин или пароль';
        }
    }
    if(!empty($error)){
       $_SESSION['error'] = $error;
        header('Location: ../auto.php');
        exit();
    }
?>