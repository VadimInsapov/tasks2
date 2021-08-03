<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $_SESSION['dateGroup'] = $_POST['dateGroup'];
    header('Location:../leader.php');
}
