<?php
    session_start();
    require_once 'php/connect.php';
    if (!isset($_SESSION['admin_role']) || $_SESSION['admin_role'] !== true) {
    header('Location: index.php');
    exit();
    }   
    $courses = mysqli_query($connect, "SELECT * FROM `courses`");
    $payment = mysqli_query($connect, "SELECT * FROM `payment`");
    $request = mysqli_query($connect, "
        SELECT request.*, courses.name AS c_name, status.name AS s_name, payment.name AS p_name, users.full_name, users.email, users.phone
        FROM request
        JOIN status ON request.id_status = status.id
        JOIN courses ON request.id_courses = courses.id
        JOIN payment ON request.id_payment = payment.id
        JOIN users ON request.id_user = users.id
    ");
    $status = mysqli_query($connect, "SELECT * FROM `status`");
    $status_list = [];
    while($s = mysqli_fetch_assoc($status)){
        $status_list[] = $s;
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $request_id = $_POST['request_id'];
        $new_status = $_POST['status_id'];
        mysqli_query($connect, "UPDATE `request` SET `id_status` = '$new_status' WHERE `id` = '$request_id'");
        header('location: admin.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <nav class="container">
                <p>Языковая<br><span>школа</span></p>
                <ul>
                    <p>Вы зашли от имени администратора</p>
                    <li><a href="php/exit.php">Выйти</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class="container">
                <h1 class="title">Список заявок клиентов</h1>
                <div class="app_block two">
                    <?php while($req = mysqli_fetch_assoc($request)){?>
                        <div class="application">
                            <p>№ <?= $req['id']?></p>
                            <p class="title_adm">Данные клиента</parent>
                            <p>Имя — <?= $req['full_name'] ?></p>
                            <p>Почта — <?= $req['email']?> <br> Телефон — <?= $req['phone']?></p>
                            <p class="title_adm">Оформленная заявка</parent>
                            <p>Курс — <?= $req['c_name']?></p>
                            <p>Дата — <?= $req['booking_date']?></p>
                            <p>Способ оплаты — <?= $req['p_name']?></p>
                            <div class="line"></div>
                            <p>Статус заявки — <?= $req['s_name']?></p>
                                <form method="post">
                                    <p>Изменить статус заявки</p>
                                    <input type="hidden" name="request_id" value="<?= $req['id']?>">
                                    <select name="status_id">
                                        <?php foreach($status_list as $s){?>
                                            <option value="<?= $s['id']?>"><?= $s['name']?></option>
                                        <?php }?>
                                    </select>
                                    <button type="submit">Изменить статус</button>
                                </form>
                        </div>
                    <?php }?>
                </div>
            </div>
        </main>
        <?php include('subfolder/footer.php'); ?>   
     </div>
</body>
</html>