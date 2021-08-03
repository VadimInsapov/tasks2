<?php
session_start();
if ($_COOKIE['user'] != "")
    if ($_COOKIE['user'] = 1) {
        header('Location:leader.php');
    } elseif ($_COOKIE['user'] = 2) {
        header('Location:subordinate.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Списки задач</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="box-form-center">
    <form class="form-login form-width-reg" action="vendor/signin.php" method="post">
        <h1>ВХОД</h1>
        <div class="form-part">
            <div class="form-error">
                <label for="login">Логин</label>
                <span><?php if ($_SESSION['loginErr']) {
                        echo $_SESSION['loginErr'];
                    }
                    unset($_SESSION['loginErr']); ?></span>
            </div>
            <input name="login" id="login" type="text" placeholder="Введите логин">
        </div>
        <div class="form-part">
            <div class="form-error">
                <label for="password">Пароль</label>
                <span><?php if ($_SESSION['passwordErr']) {
                        echo $_SESSION['passwordErr'];
                    }
                    unset($_SESSION['passwordErr']); ?></span>
            </div>
            <input name="password" id="password" type="password" placeholder="Введите пароль">
        </div>
        <div class="form-part">
            <button class="myButton" type="submit">войти</button>
        </div>
        <a href="register.php">зарегистрироваться</a>
    </form>
    <?php
    if ($_SESSION['messageError']) {
        echo '<p class="msg form-width-reg">' . $_SESSION['messageError'] . '</p>';
    }
    unset($_SESSION['messageError']);
    ?>
</div>
</body>
</html>