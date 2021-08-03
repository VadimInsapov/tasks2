<?php
session_start();
if ($_COOKIE['user'] == '')
    header('Location:index.php');
elseif ($_COOKIE['user'] == 2) {
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
    <link rel="stylesheet" href="css/select.css">
    <link rel="stylesheet" href="css/popup.css">
</head>
<body>
<? require_once 'vendor/queries.php'; ?>
<div class="info-person">
    <p>
        <? echo $_SESSION['user']['firstName'] . ' ' . $_SESSION['user']['secondName'] . ': ' . $_SESSION['user']['role'] ?>
        <a href="vendor/logout.php" class="myButton buttonOut">выйти</a>
    </p>
</div>

<div class="mainParts">
    <div class="mainPart">
        <div class="create-task open-popup">создать задачу</div>
        <div class="popup-bg">
            <div class="popup">
                <img class="close-popup" src="images/close.png" alt="">
                <form class="addTask" action="vendor/addTask.php" method="post">
                    <div class="form-error">
                        <label>Заголовок задачи</label>
                        <span></span>
                    </div>
                    <input name="title" type="text" placeholder="введите заголовок задачи">
                    <div class="form-error">
                        <label>Описание задачи</label>
                        <span></span>
                    </div>
                    <textarea name="description"></textarea>
                    <div class="form-error">
                        <label>Отвественный</label>
                        <span></span>
                    </div>
                    <select class="select subordinateID">
                        <option disabled>выбрать</option>
                        <option value="<? echo $_SESSION['user']['ID'] ?>"><? echo $_SESSION['user']['firstName'] . ' ' . $_SESSION['user']['secondName'] ?></option>
                        <?
                        foreach ($subordinates as $row):
                            ?>
                            <option value="<? echo $row['ID'] ?>"><? echo $row['firstName'] . ' ' . $row['secondName'] ?></option>
                        <?
                        endforeach;
                        ?>
                    </select>
                    <div class="form-error">
                        <label>Приоритет</label>
                        <span></span>
                    </div>
                    <select class="select priorityID">
                        <option disabled>выбрать</option>
                        <?
                        foreach ($priorities as $row):
                            ?>
                            <option value="<? echo $row['ID'] ?>"><? echo $row['name_priority'] ?></option>
                        <?
                        endforeach;
                        ?>
                    </select>
                    <div class="form-error">
                        <label>Дата окончания</label>
                        <span></span>
                    </div>
                    <input name="finished_at" type="datetime-local" class="min-date-today" min="2017-06-01T08:30">
                    <input value="создать" type="submit">
                </form>
            </div>
        </div>
    </div>

    <div class="mainPart tasks-width">
        <div class="selects">
            <form method="post" action="/vendor/filterDate.php">
                <select class="select dateGroup" name="language">
                    <option disabled><? echo $_SESSION['dateGroup']  ?></option>
                    <option value="День">День</option>
                    <option value="Неделя">Неделя</option>
                    <option value="На будущее">На будущее</option>
                    <option value="выбрать дату">Без группировки</option>
                </select>
            </form>
            <form method="post" action="/vendor/filterSub.php">
                <select class="select subIDGroup" name="language">
                    <option disabled><? echo $_SESSION['subNameGroup']  ?></option>
                    <option value="<? echo $_SESSION['user']['ID'] ?>"><? echo $_SESSION['user']['firstName'] . ' ' . $_SESSION['user']['secondName'] ?></option>
                    <?
                    foreach ($subordinates as $row):
                        ?>
                        <option value="<? echo $row['ID'] ?>"><? echo $row['firstName'] . ' ' . $row['secondName'] ?></option>
                    <?
                    endforeach;
                    ?>
                    <option value="">Без группировки</option>
                </select>
            </form>
        </div>
        <div class="box-tasks">
            <?
            foreach ($tasks as $row):
                ?>
                <div class="open-popup task">
                    <h3><? echo $row['title'] ?></h3>
                    <?if ($row['subordinateID'] === $_SESSION['user']['ID']) {?>
                    <form class="task-parameters" action="/vendor/updateStatus.php" method="post">
                        <input type="hidden" name="taskID" value="<? echo $row['ID'] ?>">
                        <?
                        require 'vendor/queries.php';
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
                        <div class="task-parameter"><p><? echo $row['sFN'] . ' ' . $row['sSN'] ?></p></div>
                        <div class="task-parameter"><p><? echo $row['name_priority'] ?></p></div>
                        <div class="task-parameter"><p class="date-finish"><? echo $row['dateFinish'] ?></p></div>
                    </div>
                    <? }
                    else {?>
                    <div class="task-parameters">
                        <div class="task-parameter"><p><? echo $row['sFN'] . ' ' . $row['sSN'] ?></p></div>
                        <div class="task-parameter choose-status"><p><? echo $row['name_status'] ?></p></div>
                        <div class="task-parameter"><p><? echo $row['name_priority'] ?></p></div>
                        <div class="task-parameter date-finish"><p><? echo $row['dateFinish'] ?></p></div>
                    </div>
                    <? }?>
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
                        <p><? echo $row['name_priority'] ?></p>
                        <h2>Статус</h2>
                        <p><? echo $row['name_status'] ?></p>
                        <h2>Дата окончания</h2>
                        <p class="date-finish"><? echo $row['dateFinish'] ?></p>
                        <h2>Дата создания</h2>
                        <p><? echo $row['created_at'] ?></p>
                        <h2>Дата обновления</h2>
                        <p><? echo $row['updated_at'] ?></p>
                        <div class="edit-task-button">
                            редактировать задание
                        </div>
                    </div>
                </div>
                <div class="popup-bg">
                    <div class="popup">
                        <img class="close-popup" src="images/close.png" alt="close_icon">
                        <form class="updateTask" action="vendor/updateTask.php" method="post">
                            <input type="hidden" value="<? echo $row['ID'] ?>" name="taskID">
                            <div class="form-error">
                                <label>Заголовок задачи</label><span></span>
                            </div>
                            <input name="title" type="text" placeholder="введите заголовок задачи"
                                   value='<? echo $row['title'] ?>'>
                            <div class="form-error">
                                <label>Описание задачи</label><span></span>
                            </div>
                            <textarea name="description"><? echo $row['description'] ?></textarea>
                            <div class="form-error">
                                <label>Отвественный</label><span></span>
                            </div>
                            <select class="select subordinateID">
                                <option disabled>Выбрать</option>
                                <option value="<? echo $_SESSION['user']['ID'] ?>"><? echo $_SESSION['user']['firstName'] . ' ' . $_SESSION['user']['secondName'] ?></option>
                                <?
                                foreach ($subordinates as $rowS):
                                    ?>
                                    <option value="<?php echo $rowS['ID']; ?>"><? echo $rowS['firstName'] . ' ' . $rowS['secondName'] ?></option>
                                <?
                                endforeach;
                                ?>
                            </select>
                            <div class="form-error">
                                <label>Приоритет</label><span></span>
                            </div>
                            <select class="select priorityID">
                                <option disabled>выбрать</option>
                                <?
                                foreach ($priorities as $rowP):
                                    ?>
                                    <option value="<?php echo $rowP['ID']; ?>"><? echo $rowP['name_priority'] ?></option>
                                <?
                                endforeach;
                                ?>
                            </select>
                            <div class="form-error">
                                <label>Дата окончания</label><span></span>
                            </div>
                            <input class="fill-update-date" name="finished_at" id="datefield" type="datetime-local"
                                   min="2017-06-01T08:30">
                            <input class="button-update-task" value="обновить" type="submit">
                        </form>
                    </div>
                </div>
            <?
            endforeach;
            ?>
        </div>
    </div>
    <div class="mainPart"></div>
    <div class="mainPart"></div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="js/main.js"></script>
<script src="js/choice-list.js"></script>
<script src="js/popup.js"></script>
<script src="js/validateForm.js"></script>
</body>
</html>