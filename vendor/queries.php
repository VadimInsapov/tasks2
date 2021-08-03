<?php
session_start();
require_once 'connect.php';
require_once 'filterSub.php';
require_once 'filterDate.php';
$query0 = "
SELECT t1.ID, t1.title, t1.description,t1.subordinateID, t3.firstName as sFN, t3.secondName sSN,
t5.firstName as cFN, t5.secondName as cSN,t4.name_status,t2.name_priority,DATE_FORMAT(t1.finished_at, '%d.%m.%y %k:%i') as dateFinish,t1.created_at,t1.updated_at
FROM  tasks t1";
$join1 = " JOIN task_priorities t2 ON t1.priorityID=t2.ID";
$join2 = " JOIN users t3 ON t1.subordinateID=t3.ID";
$join3 = " JOIN task_statuses t4 ON t1.statusID=t4.ID";
$join4 = " JOIN users t5 ON t1.createdID=t5.ID";

$orderBy = " ORDER BY t1.updated_at DESC";
$whereSubID = " WHERE t1.subordinateID=" . $_SESSION['subIDGroup'];
$queryTasks = $query0 . $join1 . $join2 . $join3 . $join4;
$queryTasksWithOrderBy = "";
$whereDateGroup="";
if($_SESSION['dateGroup']=="День"){
    $whereDateGroup = " WHERE finished_at>NOW() AND finished_at<DATE_ADD(NOW(), INTERVAL 1 DAY)";
}elseif($_SESSION['dateGroup']=="Неделя"){
    $whereDateGroup = " WHERE finished_at>NOW() AND finished_at<DATE_ADD(NOW(), INTERVAL 7 DAY)";
}elseif($_SESSION['dateGroup']=="На будущее"){
    $whereDateGroup = " WHERE finished_at>NOW() AND finished_at>=DATE_ADD(NOW(), INTERVAL 7 DAY)";
}




$setFilterNameSub = false;
$setFilterDate = false;
//echo $_SESSION['subIDGroup'].'  :  '.$_SESSION['dateGroup'];
if ($_SESSION['subIDGroup'] != '' && $_SESSION['dateGroup'] != 'выбрать дату') {
    $newWhereDateGroup = substr($whereDateGroup, 6);
    $queryTasksWithOrderBy = $queryTasks . $whereSubID . " AND" . $newWhereDateGroup . $orderBy;
    $setFilterNameSub = true;
    $setFilterDate= true;
} elseif ($_SESSION['subIDGroup'] != '' && $_SESSION['dateGroup'] == 'выбрать дату') {
    $queryTasksWithOrderBy = $queryTasks . $whereSubID . $orderBy;
    $setFilterNameSub = true;
} elseif ($_SESSION['subIDGroup'] == '' && $_SESSION['dateGroup'] != 'выбрать дату') {
    $queryTasksWithOrderBy = $queryTasks . $whereDateGroup . $orderBy;
    $setFilterDate= true;
} else {
    $queryTasksWithOrderBy = $queryTasks . $orderBy;
}
$tasks = mysqli_query($connect, $queryTasksWithOrderBy);

if ($setFilterNameSub) {
    $selectSubordinate = mysqli_query($connect, "SELECT * FROM  users WHERE ID=" . $_SESSION['subIDGroup']);
    $rows = mysqli_fetch_all($selectSubordinate, MYSQLI_ASSOC);
    $_SESSION['subNameGroup'] = $rows[0]['firstName']. ' ' . $rows[0]['secondName'] ;
} else {
    $_SESSION['subNameGroup'] = "выбрать ответственного";
}
if(!$setFilterDate){
    $_SESSION['dateGroup']="выбрать дату";
}


$query_sub = "SELECT * FROM  users WHERE roleID=2";
$subordinates = mysqli_query($connect, $query_sub);

$query_pr = "SELECT * FROM  task_priorities";
$priorities = mysqli_query($connect, $query_pr);

$query_st = "SELECT * FROM  task_statuses";
$statuses = mysqli_query($connect, $query_st);

$currentSubID = $_SESSION['user']['ID'];
$query_task_for_sub="";
if($_SESSION['dateGroup']=="выбрать дату")
{
    $query_task_for_sub = $queryTasks . " WHERE t1.subordinateID=$currentSubID" . $orderBy;
}else{
    $newWhereDateGroup = substr($whereDateGroup, 6);
    $query_task_for_sub = $queryTasks . " WHERE t1.subordinateID=$currentSubID AND". $newWhereDateGroup.$orderBy;
}
$curSubTasks = mysqli_query($connect, $query_task_for_sub);

