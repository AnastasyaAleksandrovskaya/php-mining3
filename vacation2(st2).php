<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

$host = 'localhost';
$user = 'root';
$db_name = 'test';
$password = 'Stasyaaleks98$';

echo "<link rel='stylesheet' href='main.css'>";

$link = mysqli_connect($host, $user, $password, $db_name);
mysqli_query($link, "SET NAMES 'utf8'");


if(isset($_GET['del'])){
    $vacation_id=$_GET['del'];
    $query = "DELETE FROM vacation2 WHERE vacation_id=$vacation_id";
    mysqli_query($link, $query) or die(mysqli_error($link));
}
if(isset($_POST['otm'])){
    header("Location: vacation2.php");
    exit;
}

$today = strtotime('today');
$query = "SELECT * FROM vacation2";
$result = mysqli_query($link, $query) or die(mysqli_error($link));

for ($data = []; $row = mysqli_fetch_assoc($result); $data[]=$row);
//var_dump($data);



if(isset($_POST['send'])){
        //    добавляем запись в бд
        mysqli_query($link,
            "INSERT INTO vacation2 (start_at, end_at)
 VALUES ('".$_POST['start_at']."', '".$_POST['end_at']."')"
        );
        header("Location:  vacation2.php");
        exit;
}

$query3=mysqli_query($link, "SELECT * FROM vacation2 ORDER BY vacation_id");
$user1= array();
if($query3){
    while($row=mysqli_fetch_assoc($query3)){
        $user1[]=$row;
    }
}

if(isset($_GET['upd'])) {
    $vacation_id = $_GET['upd'];
    if (isset($_POST['start_at']) <> 0) {
        $query2 = "UPDATE vacation2 SET start_at = '" . $_POST['start_at'] . "',
        end_at = '" . $_POST['end_at'] . "'
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
    <p>Дата начала отпуска: <input class="form_input" type="date" name="start_at" value="<?= $data[$vacation_id-1]{'start_at'} ?>"/></p>
    <p>Дата конца отпуска: <input class="form_input" type="date" name="end_at" value="<?= $data[$vacation_id-1]{'end_at'} ?>"/></p>
    <!--        --><?php //} ?>
    <input type="submit" value="Изменить"/>
    <input type="submit"name="otm" value="Отмена"/>
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
<table class="krasivoye-oformleniye-tablits" cellspacing='0' 	>
    <tr class="bold">
        <td>id</td>
        <td>Начало отпуска</td>
        <td>Конец отпуска</td>
    </tr>
    <?php foreach ($data as $user){
//    if($user{'vacation_id'}==2){
        ?>
        <tr>
            <td><a href="?upd=<?= $user{'vacation_id'} ?>"><?= $user{'vacation_id'} ?></a></td>
            <td><?= $user{'start_at'} ?></td>
            <td><?= $user{'end_at'} ?></td>
            <td><a href="?del=<?= $user['vacation_id']?>">delete</a></td>
        </tr>
    <?php }
//    }
    ?>
</table>
<form action="" method="POST" class="add_worker">
    <h3>Добавить отпуск: </h3>
    <p>Начало отпуска: <input class="form_input" type="date" name="start_at"/></p>
    <p>Конец отпуска : <input class="form_input" type="date" name="end_at"/></p>
    <input class="form_button" type="submit" name="send" value="Добавить"/>
</form>
</body>
</html>
