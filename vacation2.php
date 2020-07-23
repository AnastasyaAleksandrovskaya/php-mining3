<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
session_start();
$get1=$_SESSION['s'];
//$get1=$_GET['get1'];
//echo $get1;

$host = 'localhost';
$user = 'root';
$db_name = 'test';
$password = 'Stasyaaleks98$';


echo "<link rel='stylesheet' href='main.css'>";

$link = mysqli_connect($host, $user, $password, $db_name);
mysqli_query($link, "SET NAMES 'utf8'");


if(isset($_GET['del'])){
    $vacation_id=$_GET['del'];
    $query = "DELETE FROM vacation WHERE vacation_id=$vacation_id";
    mysqli_query($link, $query) or die(mysqli_error($link));
}

if(isset($_GET['del2'])){
    $idnotofficial_vacation=$_GET['del2'];
    $query = "DELETE FROM notofficial_vacation WHERE idnotofficial_vacation=$idnotofficial_vacation";
    mysqli_query($link, $query) or die(mysqli_error($link));
}

if(isset($_POST['otm'])){
    header("Location: vacation2.php");
    exit;
}
if(isset($_POST['back'])){
    header("Location: newindex.php");
    exit;
}

$today = strtotime('today');
$query = "SELECT * FROM vacation";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
for ($data = []; $row = mysqli_fetch_assoc($result); $data[]=$row);
//var_dump($data);

$query2 = "SELECT * FROM notofficial_vacation";
$result2 = mysqli_query($link, $query2) or die(mysqli_error($link));

for ($data2 = []; $row2 = mysqli_fetch_assoc($result2); $data2[]=$row2);

$message="";
if(isset($_POST['send'])){
        //    добавляем запись в бд
    if(strlen($_POST['notofficial_quantity'])<>'') {
        mysqli_query($link,
            "INSERT INTO vacation (type_vacation, start_at, end_at, worker_id, notofficial_quantity)
 VALUES ('" . $_POST['type_vacation'] . "', '" . $_POST['start_at'] . "', '" . $_POST['end_at'] . "',$get1,
  '" . $_POST['notofficial_quantity'] . "')"
        );
        //////////
        header("Location:  vacation2.php");
        exit;
    }else{
        $message='Укажите фактичесткое колличество дней';
    }
}

$query3=mysqli_query($link, "SELECT * FROM vacation ORDER BY vacation_id");
$user1= array();
if($query3){
    while($row=mysqli_fetch_assoc($query3)){
        $user1[]=$row;
    }
}


if(isset($_POST['send2'])){
    //    добавляем запись в бд
        mysqli_query($link,
            "INSERT INTO notofficial_vacation (type_vacation2, start_at2, end_at2, worker_id2)
 VALUES ('" . $_POST['type_vacation2'] . "', '" . $_POST['start_at2'] . "', '" . $_POST['end_at2'] . "',$get1)"
        );
        //////////
        header("Location:  vacation2.php");
        exit;
}

$query4=mysqli_query($link, "SELECT * FROM notofficial_vacation ORDER BY idnotofficial_vacation");
$user2= array();
if($query4){
    while($row2=mysqli_fetch_assoc($query4)){
        $user2[]=$row2;
    }
}

if(isset($_GET['upd'])) {
    $vacation_id = $_GET['upd'];
    if (isset($_POST['start_at']) <> 0) {
        $query2 = "UPDATE vacation SET start_at = '" . $_POST['start_at'] . "',
        end_at = '" . $_POST['end_at'] . "',
        type_vacation = '" . $_POST['type_vacation'] . "',
        notofficial_quantity = '". $_POST['notofficial_quantity'] ."'
          WHERE vacation_id=$vacation_id";
        mysqli_query($link, $query2) or die(mysqli_error($link));
        header("Location: vacation2.php");
        exit;
    }
    ?>
    <!--    <form method="post">-->
    <!--        --><?php //foreach ($data as $user){?>
    <form method="post" class="change"/>
    <h3>Внести изменения: </h3>
    <p><select class="form_input" name="type_vacation"">
            <option value="Оплачиваемый отпуск">Оплачиваемый отпуск</option>
            <option value="Неоплачиваемый отпуск">Неоплачиваемый отпуск</option>
            <option value="Больничный">Больничный</option>
        </select></p>
    <p>
    <p>Дата начала отпуска: <input class="form_input" type="date" name="start_at" value="<?= $data[$vacation_id-1]{'start_at'} ?>"/></p>
    <p>Дата конца отпуска: <input class="form_input" type="date" name="end_at" value="<?= $data[$vacation_id-1]{'end_at'} ?>"/></p>
    <p>Фактическое: <input class="form_input" type="text" name="notofficial_quantity" value="<?= $data[$vacation_id-1]{'notofficial_quantity'} ?>"/></p>
    <!--        --><?php //} ?>
    <input class="form_button" type="submit" value="Изменить"/>
    <input class="form_button" type="submit"name="otm" value="Отмена"/>
    </form>
    <?php
}


if(isset($_GET['upd2'])) {
    $idnotofficial_vacation = $_GET['upd2'];
    if (isset($_POST['start_at2']) <> 0) {
        $query2 = "UPDATE notofficial_vacation SET start_at2 = '" . $_POST['start_at2'] . "',
            end_at2 = '" . $_POST['end_at2'] . "',
            type_vacation2 = '" . $_POST['type_vacation2'] . "'
              WHERE idnotofficial_vacation=$idnotofficial_vacation";
        mysqli_query($link, $query2) or die(mysqli_error($link));
        header("Location: vacation2.php");
        exit;
    }
    ?>
    <!--    <form method="post">-->
    <!--        --><?php //foreach ($data as $user){?>
    <form method="post" class="change"/>
    <h3>Внести изменения: </h3>
    <p><select class="form_input" name="type_vacation2"">
        <option value="Впрок">Впрок</option>
        <option value="Вдолг">Вдолг</option>
        </select></p>
    <p>
    <p>Дата начала отпуска: <input class="form_input" type="date" name="start_at2" value="<?= $data2[$idnotofficial_vacation-1]{'start_at2'} ?>"/></p>
    <p>Дата конца отпуска: <input class="form_input" type="date" name="end_at2" value="<?= $data2[$idnotofficial_vacation-1]{'end_at2'} ?>"/></p>
    <!--        --><?php //} ?>
    <input class="form_button" type="submit" value="Изменить"/>
    <input class="form_button" type="submit"name="otm" value="Отмена"/>
    </form>
    <?php
}

mysqli_close($link);
?>



<html>
<head>
    <title>Учет отпусков</title>
</head>
<body>
<form action="" method="POST">
    <input class="form_button" type="submit" name="back" value="Обратно"/>
</form>

<table class="krasivoye-oformleniye-tablits" cellspacing='0' 	>
<!--    <h2 class="bold">Официальные отпуска</h2>-->
    <tr class="bold">
        <td>id</td>
        <td>Тип отпуска</td>
        <td>Начало отпуска</td>
        <td>Конец отпуска</td>
        <td>Официальное колличество дней</td>
        <td>Фактическое</td>
        <td>Сальдо</td>

    </tr>
    <?php
    $summOpl=0;
    $summNeOpl=0;
    $summBol=0;
    $summOpl2=0;
    $summNeOpl2=0;
    $summBol2=0;
    foreach ($data as $user){
        if($user{'worker_id'}==$get1){
            ?>
            <tr>
                <td><a href="?upd=<?= $user{'vacation_id'} ?>"><?= $user{'vacation_id'} ?></a></td>
                <td><?= $user{'type_vacation'} ?></td>
                <td><?= $user{'start_at'} ?></td>
                <td><?= $user{'end_at'} ?></td>
                <td><?= (idate('Y', strtotime($user{'end_at'})) - idate('Y', strtotime($user{'start_at'}))) * 365 +
                    (idate('m', strtotime($user{'end_at'})) - idate('m', strtotime($user{'start_at'}))) * 30 +
                    idate('d', strtotime($user{'end_at'})) - idate('d', strtotime($user{'start_at'})) + 1 ?></td>
                <td><?= $user{'notofficial_quantity'} ?></td>
                <td><?= (idate('Y', strtotime($user{'end_at'})) - idate('Y', strtotime($user{'start_at'}))) * 365 +
                    (idate('m', strtotime($user{'end_at'})) - idate('m', strtotime($user{'start_at'}))) * 30 +
                    idate('d', strtotime($user{'end_at'})) - idate('d', strtotime($user{'start_at'})) -
                    $user{'notofficial_quantity'} + 1 ?></td>
                <?php
                if($user['type_vacation']=="Оплачиваемый отпуск"){
                    $summOpl = $summOpl + (idate('Y', strtotime($user{'end_at'})) - idate('Y', strtotime($user{'start_at'}))) * 365 +
                        (idate('m', strtotime($user{'end_at'})) - idate('m', strtotime($user{'start_at'}))) * 30 +
                        idate('d', strtotime($user{'end_at'})) - idate('d', strtotime($user{'start_at'})) -
                        $user{'notofficial_quantity'} + 1;
                    $summOpl2 = $summOpl2 + (idate('Y', strtotime($user{'end_at'})) - idate('Y', strtotime($user{'start_at'}))) * 365 +
                        (idate('m', strtotime($user{'end_at'})) - idate('m', strtotime($user{'start_at'}))) * 30 +
                        idate('d', strtotime($user{'end_at'})) - idate('d', strtotime($user{'start_at'})) + 1;
                }else if($user['type_vacation']=="Неоплачиваемый отпуск"){
                    $summNeOpl = $summNeOpl + (idate('Y', strtotime($user{'end_at'})) - idate('Y', strtotime($user{'start_at'}))) * 365 +
                        (idate('m', strtotime($user{'end_at'})) - idate('m', strtotime($user{'start_at'}))) * 30 +
                        idate('d', strtotime($user{'end_at'})) - idate('d', strtotime($user{'start_at'})) -
                        $user{'notofficial_quantity'} + 1;
                    $summNeOpl2 = $summNeOpl2 + (idate('Y', strtotime($user{'end_at'})) - idate('Y', strtotime($user{'start_at'}))) * 365 +
                        (idate('m', strtotime($user{'end_at'})) - idate('m', strtotime($user{'start_at'}))) * 30 +
                        idate('d', strtotime($user{'end_at'})) - idate('d', strtotime($user{'start_at'})) + 1;
                }else if($user['type_vacation']=="Больничный"){
                    $summBol = $summBol + (idate('Y', strtotime($user{'end_at'})) - idate('Y', strtotime($user{'start_at'}))) * 365 +
                        (idate('m', strtotime($user{'end_at'})) - idate('m', strtotime($user{'start_at'}))) * 30 +
                        idate('d', strtotime($user{'end_at'})) - idate('d', strtotime($user{'start_at'})) -
                        $user{'notofficial_quantity'} + 1;
                    $summBol2 = $summBol2 + (idate('Y', strtotime($user{'end_at'})) - idate('Y', strtotime($user{'start_at'}))) * 365 +
                        (idate('m', strtotime($user{'end_at'})) - idate('m', strtotime($user{'start_at'}))) * 30 +
                        idate('d', strtotime($user{'end_at'})) - idate('d', strtotime($user{'start_at'})) + 1;
                }
                ?>
                <td><a href="?del=<?= $user['vacation_id']?>">delete</a></td>
            </tr>
            <?php
        }
    }
    echo "Сальдо:"; echo "<br/>";
    echo "Оплачеваемый: "; echo $summOpl; echo "<br/>";
    echo "Неоплачеваемый: "; echo $summNeOpl; echo "<br/>";
    echo "Больничный: "; echo $summBol; echo "<br/>";echo "<br/>";

    echo "Официальный:"; echo "<br/>";
    echo "Оплачеваемый: "; echo $summOpl2; echo "<br/>";
    echo "Неоплачеваемый: "; echo $summNeOpl2; echo "<br/>";
    echo "Больничный: "; echo $summBol2; echo "<br/>";
    ?>

</table>


<form action="" method="POST" class="add_worker">
    <h3>Добавить официальный отпуск: </h3>
    <p><select class="form_input" name="type_vacation"">
        <option value="Оплачиваемый отпуск">Оплачиваемый отпуск</option>
        <option value="Неоплачиваемый отпуск">Неоплачиваемый отпуск</option>
        <option value="Больничный">Больничный</option>
        </select></p>
    <p>
    <p>Начало отпуска: <input class="form_input" type="date" name="start_at"/></p>
    <p>Конец отпуска : <input class="form_input" type="date" name="end_at"/></p>
    <p>Фактическое : <input class="form_input" type="text" name="notofficial_quantity"/></p>
    <input class="form_button" type="submit" name="send" value="Добавить"/>
    <p style="color:red;"><?=$message?></p>
    <!--    <input class="form_button" type="submit" name="back" value="Обратно"/>-->
</form>



<table class="krasivoye-oformleniye-tablits" cellspacing='0' 	>
    <h2 class="bold">Неофициальные отпуска</h2>
    <tr class="bold">
        <td>id</td>
        <td>Вид отпуска</td>
        <td>Начало отпуска</td>
        <td>Конец отпуска</td>
        <td>Кол-во календарных дней</td>

    </tr>
    <?php
    $summVprok=0;
    $summVdolg=0;
    $sumOb=0;
    foreach ($data2 as $user){
        if($user{'worker_id2'}==$get1){
            ?>
            <tr>
                <td><a href="?upd2=<?= $user{'idnotofficial_vacation'} ?>"><?= $user{'idnotofficial_vacation'} ?></a></td>
                <td><?= $user{'type_vacation2'} ?></td>
                <td><?= $user{'start_at2'} ?></td>
                <td><?= $user{'end_at2'} ?></td>
                <td><?= (idate('Y', strtotime($user{'end_at2'})) - idate('Y', strtotime($user{'start_at2'}))) * 365 +
                    (idate('m', strtotime($user{'end_at2'})) - idate('m', strtotime($user{'start_at2'}))) * 30 +
                    idate('d', strtotime($user{'end_at2'})) - idate('d', strtotime($user{'start_at2'})) + 1 ?></td>
                <?php
                if($user['type_vacation2']=="Впрок"){
                    $summVprok = $summVprok + (idate('Y', strtotime($user{'end_at2'})) - idate('Y', strtotime($user{'start_at2'}))) * 365 +
                        (idate('m', strtotime($user{'end_at2'})) - idate('m', strtotime($user{'start_at2'}))) * 30 +
                        idate('d', strtotime($user{'end_at2'})) - idate('d', strtotime($user{'start_at2'}))  + 1;
                }else if($user['type_vacation2']=="Вдолг"){
                    $summVdolg = $summVdolg + (idate('Y', strtotime($user{'end_at2'})) - idate('Y', strtotime($user{'start_at2'}))) * 365 +
                        (idate('m', strtotime($user{'end_at2'})) - idate('m', strtotime($user{'start_at2'}))) * 30 +
                        idate('d', strtotime($user{'end_at2'})) - idate('d', strtotime($user{'start_at2'})) + 1;
                }
                ?>
                <td><a href="?del2=<?= $user['idnotofficial_vacation']?>">delete</a></td>
            </tr>
            <?php
        }
    }
    echo "Впрок: "; echo $summVprok; echo "<br/>";
    echo "Вдолг: "; echo $summVdolg; echo "<br/>";
    $summOb = $summVprok - $summVdolg;
    if($summVdolg>$summVprok) {
        echo "Кол-во дней, которые надо отработать:";echo $summOb;echo "<br/>";
    }else if($summVdolg<$summVprok){
        echo "Колличество переработанных дней: ";echo $summOb; echo "<br/>";
    }else{
        echo "Нет дополнительных дней отдыха";
    }
    ?>
</table>


<form action="" method="POST" class="add_worker">
    <h3>Добавить официальный отпуск: </h3>
    <p><select class="form_input" name="type_vacation2"">
        <option value="Впрок">Впрок</option>
        <option value="Вдолг">Вдолг</option>
        </select></p>
    <p>
    <p>Начало отпуска: <input class="form_input" type="date" name="start_at2"/></p>
    <p>Конец отпуска : <input class="form_input" type="date" name="end_at2"/></p>
    <input class="form_button" type="submit" name="send2" value="Добавить"/>
    <p style="color:red;"><?=$message?></p>
    <!--    <input class="form_button" type="submit" name="back" value="Обратно"/>-->
</form>


</body>
</html>
