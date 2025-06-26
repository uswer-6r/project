<?php
    $connect = mysqli_connect('localhost', 'root', '', 'courses');
    if(!$connect){
        die('Произошла ошибка подключения к БД');
    }
?>