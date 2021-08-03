<?php
require_once 'connect.php';

$taskID = $_POST['taskID'];
$title = $_POST['title'];
$description = $_POST['description'];
$finished_at = date('c', strtotime($_POST['finished_at']."-2 hour"));
$priorityID = $_POST['priorityID'];
$subordinateID = $_POST['subordinateID'];
//, description = $description, finished_at = $finished_at,
//                 updated_at = NOW(), priorityID = $priorityID, `subordinateID` = $subordinateID
//$query_task="UPDATE tasks SET title = $title WHERE tasks.ID = $taskID";
//$subordinates = mysqli_query($connect, $query_task);
//header('Location:../leader.php');

//, description = '$description', finished_at = '$finished_at',
//    updated_at = NOW(), priorityID = '$priorityID', `subordinateID` = '$subordinateID'


$query_sub = "
UPDATE tasks 
SET title = '$title', description = '$description', finished_at = '$finished_at',updated_at = NOW(), priorityID = '$priorityID', `subordinateID` = '$subordinateID'
WHERE tasks.ID = $taskID";
$subordinates = mysqli_query($connect, $query_sub);
header('Location:../leader.php');