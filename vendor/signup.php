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
$haveEmptyInput=false;
$leader = $_POST['leader'];
$login = $password = $firstName = $secondName = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstName"])) {
        $_SESSION['firstNameErr'] = "Обязательное поле";
        header('Location:../register.php');
        $haveEmptyInput=true;
    } else {
        $firstName = test_input($_POST["firstName"]);
    }
    if (empty($_POST["secondName"])) {
        $_SESSION['secondNameErr'] = "Обязательное поле";
        header('Location:../register.php');
        $haveEmptyInput=true;
    } else {
        $secondName = test_input($_POST["secondName"]);
    }
    if (empty($_POST["login"])) {
        $_SESSION['loginErr'] = "Обязательное поле";
        header('Location:../register.php');
        $haveEmptyInput=true;
    } else {
        $login = test_input($_POST["login"]);
    }
    if (empty($_POST["password"])) {
        $_SESSION['passwordErr'] = "Обязательное поле";
        header('Location:../register.php');
        $haveEmptyInput=true;
    } else {
        $password = md5(test_input($_POST["password"]));
    }
}
$roleID;
if ($leader) {
    $roleID = 1;
} else {
    $roleID = 2;
}

if(!$haveEmptyInput) {
    $loginQuery = "SELECT * FROM users WHERE login='$login'";
    $checkLogin = mysqli_query($connect, $loginQuery);

    if (mysqli_num_rows($checkLogin) == 0) {
        mysqli_query($connect, "
INSERT INTO users (ID, roleID, firstName, secondName, login, password)
VALUES (NULL,'$roleID','$firstName', '$secondName', '$login', '$password')");
        header('Location:../index.php');
    } else {
        $_SESSION['messageError'] = "Пользователь с таким логином уже существует!";
        header('Location:../register.php');
    }


}
?>