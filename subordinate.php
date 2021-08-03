<?php
session_start();
if ($_COOKIE['user'] == '')
    header('Location:index.php');
elseif ($_COOKIE['user'] == 1) {
    header('Location:leader.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Списки задач</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/select.css">
    <link rel="stylesheet" href="css/popup.css">
</head>
<body>

<div class="info-person">
    <p>
        <? echo $_SESSION['user']['firstName'] . ' ' . $_SESSION['user']['secondName'] . ': ' . $_SESSION['user']['role'] ?>
        <a href="vendor/logout.php" class="myButton buttonOut">Выйти</a>
    </p>

</div>
<?
require 'vendor/queries.php';
?>
<div class="mainParts">
    <div class="mainPart tasks-width">
        <div class="selects">
            <form method="post" action="/vendor/filterDate.php">
                <select class="select dateGroup" name="language">
                    <option disabled><? echo $_SESSION['dateGroup']; ?></option>
                    <option value="День">День</option>
                    <option value="Неделя">Неделя</option>
                    <option value="На будущее">На будущее</option>
                    <option value="выбрать дату">Без группировки</option>
                </select>
            </form>
        </div>
        <div class="box-tasks">
            <?
            foreach ($curSubTasks as $row):
            ?>
            <div class="open-popup task">
                <h3><? echo $row['title'] ?></h3>
                <form class="task-parameters" action="/vendor/updateStatus.php" method="post">
                    <input type="hidden" name="taskID" value="<? echo $row['ID'] ?>">
                    <?
                    foreach ($statuses as $row_st):
                        if ($row_st['name_status'] == $row['name_status']) {
                            echo "<button name='statusID' value='" . $row_st['ID'] . "' class='status choose-status sub-choose-status'>" . $row_st['name_status'] . "</button>";
                        } else {
                            echo "<button value='" . $row_st['ID'] . "' class='status'>" . $row_st['name_status'] . "</button>";
                        }
                    endforeach;
                    ?>
                </form>
                <div class="task-parameters ">
                    <div class="task-parameter"><p><? echo $row['sFN'] ?></p></div>
                    <div class="task-parameter"><p><? echo $row['name_priority'] ?></p></div>
                    <div class="task-parameter"><p class="date-finish"><? echo $row['dateFinish'] ?></p></div>
                </div>
            </div>
            <div class="popup-bg">
                <div class="popup info-task">
                    <img class="close-popup" src="images/close.png" alt="close_icon">
                    <h2>Задача</h2>
                    <p><? echo $row['title'] ?></p>
                    <h2>Описание</h2>
                    <p><? echo $row['description'] ?></p>
                    <h2>Создатель</h2>
                    <p><? echo $row['cFN'] . ' ' . $row['cSN'] ?></p>
                    <h2>Ответственный</h2>
                    <p><? echo $row['sFN'] . ' ' . $row['sSN'] ?></p>
                    <h2>Приоритет</h2>
                    <p> <? echo $row['name_priority'] ?></p>
                    <h2>Статус</h2>
                    <p> <? echo $row['name_status'] ?></p>
                    <h2>Дата окончания</h2>
                    <p><? echo $row['dateFinish'] ?></p>
                    <h2>Дата создания</h2>
                    <p><? echo $row['created_at'] ?></p>
                    <h2>Дата обновления</h2>
                    <p><? echo $row['updated_at'] ?></p>
                </div>
            </div>
            <?
            endforeach;
            ?>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="js/choice-list.js"></script>
<script src="js/popup.js"></script>
<script src="js/main.js"></script>
</body>
</html>