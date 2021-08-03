<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $_SESSION['subIDGroup'] = $_POST['subIDGroup'];
    header('Location:../leader.php');
}