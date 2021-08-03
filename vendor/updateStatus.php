<?php
require_once 'connect.php';
$newStatusID = $_POST['statusID'];
$taskID = $_POST['taskID'];

$query_sub = "UPDATE tasks SET statusID = $newStatusID WHERE tasks.ID = $taskID";
$subordinates = mysqli_query($connect, $query_sub);
header('Location:../subordinate.php');