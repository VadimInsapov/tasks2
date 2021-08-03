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
    <form class="form-login form-width-reg" action="/vendor/signup.php" method="post">
        <h1>РЕГИСТРАЦИЯ</h1>
        <div class="form-part">
            <div class="form-error">
                <label for="firstName">Имя</label>
                <span><?php if ($_SESSION['firstNameErr']) {
                        echo $_SESSION['firstNameErr'];
                    }
                    unset($_SESSION['firstNameErr']); ?></span>
            </div>
            <input id="name" type="text" placeholder="Введите имя" name="firstName">
        </div>
        <div class="form-part">
            <div class="form-error">
                <label for="secondName">Фамилия</label>
                <span><?php if ($_SESSION['secondNameErr']) {
                        echo $_SESSION['secondNameErr'];
                    }
                    unset($_SESSION['secondNameErr']); ?></span>
            </div>
            <input id="secondName" type="text" placeholder="Введите фамилию" name="secondName">
        </div>
        <div class="form-part">
            <div class="form-error">
                <label for="login">Логин</label>
                <span><?php if ($_SESSION['loginErr']) {
                        echo $_SESSION['loginErr'];
                    }
                    unset($_SESSION['loginErr']); ?></span>
            </div>
            <input id="login" type="text" placeholder="Введите логин" name="login">
        </div>
        <div class="form-part">
            <div class="form-error">
                <label for="password">Пароль</label>
                <span><?php if ($_SESSION['passwordErr']) {
                        echo $_SESSION['passwordErr'];
                    }
                    unset($_SESSION['passwordErr']); ?></span>
            </div>
            <input id="password" type="password" placeholder="Введите пароль" name="password">
        </div>
        <div class="checkbox0">
            <input id="leader" type="checkbox" class="custom-checkbox" name="leader"> <label for="leader">Я
                руководитель</label>
        </div>
        <div class="form-part">
            <button class="myButton" type="submit">зарегистрироваться</button>
        </div>
        <a href="index.php">авторизоваться</a>
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