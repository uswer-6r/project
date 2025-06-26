<?php
    session_start();
    require_once 'php/connect.php';

    if(!isset($_SESSION['user_id'])){
        header('Location: index.php');
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $courses = mysqli_query($connect, "SELECT * FROM `courses`");
    $payment = mysqli_query($connect, "SELECT * FROM `payment`");
    $request = mysqli_query($connect, "
        SELECT request.*, courses.name AS c_name, status.name AS s_name, payment.name AS p_name
        FROM request
        JOIN status ON request.id_status = status.id
        JOIN courses ON request.id_courses = courses.id
        JOIN payment ON request.id_payment = payment.id
        WHERE request.id_user = $user_id
    ");
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $courses_id = $_POST['courses_id'];
        $payment_id = $_POST['payment_id'];
        $date = $_POST['date'];
        mysqli_query($connect, "INSERT INTO `request` (`id`, `id_user`, `id_status`, `id_courses`, `id_payment`, `booking_date`)
        VALUES (NULL, '$user_id', '1', '$courses_id', '$payment_id', '$date')");
        header('Location: user_main.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявки</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <nav class="container">
                <p>Языковая<br><span>школа</span></p>
                <ul>
                    <li><a href="php/exit.php">Выйти</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class="container">
                <h1 class="title">Подать заявку на курс можно здесь</h1>
                <form method="post">
                    <p>Выберите подходящий курс</p>
                    <select name="courses_id">
                        <?php while($c = mysqli_fetch_assoc($courses)){?>
                            <option value="<?= $c['id']?>"><?= $c['name']?></option>
                        <?php }?>
                    </select>
                    <p>Выберите удобную для вас дату</p>
                    <input type="date" name="date" required>
                    <p>Выберите способ оплаты</p>
                    <select name="payment_id">
                        <?php while($p = mysqli_fetch_assoc($payment)){?>
                            <option value="<?= $p['id']?>"><?= $p['name']?></option>
                        <?php }?>
                    </select>
                    <button type="submit">Отправить заявку</button>
                </form>
                <h1 class="title">Отслеживайте статус ваших заявок</h1>
                <div class="app_block">
                    <?php while($req = mysqli_fetch_assoc($request)){?>
                        <div class="application">
                            <p>№ <?= $req['id']?></p>
                            <p>Выбранный курс — <?= $req['c_name']?></p>
                            <p>Выбранная дата — <?= $req['booking_date']?></p>
                            <p>Выбранный способ оплаты — <?= $req['p_name']?></p>
                            <div class="line"></div>
                            <p><?= $req['s_name']?></p>
                        </div>
                    <?php }?>
                </div>
            </div>
        </main>
        <?php include('subfolder/footer.php'); ?>   
    </div>
</body>
</html>