<?php
session_start();
require_once 'connect.php';
$title = $_POST['title'];
$description = $_POST['description'];
$finished_at = date('c', strtotime($_POST['finished_at']."-2 hour"));
$priorityID = $_POST['priorityID'];
$subordinateID = $_POST['subordinateID'];
$createdID=$_SESSION['user']['ID'];
$query="
INSERT INTO `tasks` (`title`, `description`, `finished_at`, `created_at`, `updated_at`, `priorityID`, `statusID`, `createdID`, `subordinateID`) 
VALUES ('$title', '$description', '$finished_at', NOW(), NOW(),'$priorityID',1,'$createdID','$subordinateID')";

mysqli_query($connect, $query);
header('Location:../leader.php');
//echo date('c', strtotime("now"."+2 hour"))."<br>";
//echo date('c', strtotime($_POST["finished_at"])) . "<br>";
//echo $title . "<br>";
//echo $description . "<br>";
//echo $finished_at . "<br>";
//echo $priorityID . "<br>";
//echo $subordinateID . "<br>";