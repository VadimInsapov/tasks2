<?php
session_start();
require_once 'connect.php';
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$haveEmptyInput = false;
$login = $password = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["login"])) {
        $_SESSION['loginErr'] = "Обязательное поле";
        header('Location:../index.php');
        $haveEmptyInput = true;
    } else {
        $login = test_input($_POST["login"]);
    }
    if (empty($_POST["password"])) {
        $_SESSION['passwordErr'] = "Обязательное поле";
        header('Location:../index.php');
        $haveEmptyInput = true;
    } else {
        $password = md5(test_input($_POST["password"]));
    }
}

if (!$haveEmptyInput) {
    $loginQuery = "SELECT * FROM users WHERE login='$login'";
    $checkLogin = mysqli_query($connect, $loginQuery);

    if (mysqli_num_rows($checkLogin) > 0) {
        $userQuery = "SELECT * FROM users WHERE login='$login' AND password ='$password'";
        $checkUser = mysqli_query($connect, $userQuery);

        if (mysqli_num_rows($checkUser) > 0) {
            $user = mysqli_fetch_assoc($checkUser);
            $_SESSION['user'] = [
                "ID" => $user['ID'],
                "roleID" => $user['roleID'],
                "role" => $user['roleID'] == 1 ? "руководитель" : "подченённый",
                "firstName" => $user['firstName'],
                "secondName" => $user['secondName']
            ];
            setcookie("user", $user['roleID'], time() + 3600 * 24, "/");
            if ($user['roleID'] == 1) {
                header('Location:../leader.php');
            } elseif ($user['roleID'] == 2) {
                header('Location:../subordinate.php');
            }
        } else {
            $_SESSION['messageError'] = "Неверный пароль!";
            header('Location:../index.php');
        }

    } else {
        $_SESSION['messageError'] = "Такой пользователь не найден!";
        header('Location:../index.php');
    }
}



