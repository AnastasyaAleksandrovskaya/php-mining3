<style>
    table{
        width : 300px;
    }
    td{
        border : 1px solid black;
        text-align: center;
    }
</style>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

$host = 'localhost';
$user = 'root';
$db_name = 'test';
$password = 'password';

$link = mysqli_connect($host, $user, $password, $db_name);
mysqli_query($link, "SET NAMES 'utf8'");


if(isset($_GET['del'])){
    $id=$_GET['del'];
    $query = "DELETE FROM worker WHERE id=$id";
    mysqli_query($link, $query) or die(mysqli_error($link));
}
if(isset($_POST['otm'])){
    header("Location: http://localhost:63342/%D0%BB%D0%B5%D1%82%D0%BD%D1%8F%D1%8F%20%D0%BF%D1%80%D0%B0%D0%BA%D1%82%D0%B8%D0%BA%D0%B0%203/newindex.php?_ijt=gd2hsi40rarraaafr0ij6ghruj");
    exit;
}


$query = "SELECT * FROM worker";
$result = mysqli_query($link, $query) or die(mysqli_error($link));

for ($data = []; $row = mysqli_fetch_assoc($result); $data[]=$row);
//var_dump($data);



$message='';
if(isset($_POST['send'])){
    if(strlen($_POST['name'])>0) {
        //    добавляем запись в бд
        mysqli_query($link,
            "INSERT INTO worker (name, vacation_days_official, vacation_days_spent, administrative_days,working_leaves)
 VALUES ('".$_POST['name']."', '".$_POST['vacation_days_official']."', '".$_POST['vacation_days_spent']."', '".$_POST['administrative_days']."', '".$_POST['working_leaves']."')"
        );
        header("Location:  http://localhost:63342/%D0%BB%D0%B5%D1%82%D0%BD%D1%8F%D1%8F%20%D0%BF%D1%80%D0%B0%D0%BA%D1%82%D0%B8%D0%BA%D0%B0%203/newindex.php?_ijt=gd2hsi40rarraaafr0ij6ghruj");
        exit;
    }
    else{
        $message='Укажите ФИО';
    }
}

$query3=mysqli_query($link, "SELECT * FROM worker ORDER BY id");
$user1= array();
if($query3){
    while($row=mysqli_fetch_assoc($query3)){
        $user1[]=$row;
    }
}

if(isset($_GET['upd'])) {
    $id = $_GET['upd'];
    if (isset($_POST['name']) <> "") {
//        if(strlen(($_POST['name']))!=0) {
        $query2 = "UPDATE worker SET name = '" . $_POST['name'] . "',
        vacation_days_official = '" . $_POST['vacation_days_official'] . "',
        vacation_days_spent = '" . $_POST['vacation_days_spent'] . "',
        administrative_days = '" . $_POST['administrative_days'] . "',
        working_leaves = '" . $_POST['working_leaves'] . "'
          WHERE id=$id";
        mysqli_query($link, $query2) or die(mysqli_error($link));
        header("Location: http://localhost:63342/%D0%BB%D0%B5%D1%82%D0%BD%D1%8F%D1%8F%20%D0%BF%D1%80%D0%B0%D0%BA%D1%82%D0%B8%D0%BA%D0%B0%203/newindex.php?_ijt=gd2hsi40rarraaafr0ij6ghruj");
        exit;
    }
    ?>
    <form method="post">
<!--        --><?php //foreach ($data as $user){?>

        <p>ФИО: <input type="text" name="name" value= "<?= $data[$id-1]{'name'} ?>" /></p>
        <p>Официальный отпуск: <input type="text" name="vacation_days_official" value="<?= $data[$id-1]{'vacation_days_official'} ?>"/></p>
        <p>Неофициальный отпуск: <input type="text" name="vacation_days_spent" value="<?= $data[$id-1]{'vacation_days_spent'} ?>"/></p>
        <p>Административные дни:<input type="text" name="administrative_days" value="<?= $data[$id-1]{'administrative_days'} ?>"/></p>
        <p>Working leaves: <input type="text" name="working_leaves"  value="<?= $data[$id-1]{'working_leaves'} ?>"/></p>
<!--        --><?php //} ?>
        <input type="submit" value="Изменить"/>
        <input type="submit"name="otm" value="Отмена"/>
    </form>
    <?php
}



mysqli_close($link);
?>

<table>
    <tr>
        <td>id</td>
        <td>ФИО</td>
        <td>Официальный отпуск</td>
        <td>Неофициальный отпуск</td>
        <td>Административные дни</td>
        <td>Working leaves</td>
    </tr>
    <?php foreach ($data as $user){?>
        <tr>
            <td><?= $user{'id'} ?></td>
            <!--            <td>--><?//= $user{'name'} ?><!--</td>-->
            <td><a href="?upd=<?= $user{'id'} ?>"><?= $user{'name'} ?></a></td>
            <td><?= $user{'vacation_days_official'} ?></td>
            <td><?= $user{'vacation_days_spent'} ?></td>
            <td><?= $user{'administrative_days'} ?></td>
            <td><?= $user{'working_leaves'} ?></td>
            <td><a href="?del=<?=$user['id']?>">delete</a></td>
        </tr>
    <?php } ?>
</table>


<html>
<head>
    <title>f</title>
</head>
<body>
<form action="" method="POST">
    <h3>Добавить человека: </h3>
    ФИО: <input type="text" name="name"/>
    <p>Официальный отпуск: <input type="text" name="vacation_days_official"/></p>
    <p>Неофициальный отпуск: <input type="text" name="vacation_days_spent"/></p>
    <p>Административные дни:<input type="text" name="administrative_days"/></p>
    <p>Working leaves: <input type="text" name="working_leaves"  value=""/></p>

    <input type="submit" name="send" value="Добавить"/>
    <p style="color:red;"><?=$message?></p>
</form>
<?php //foreach ($user1 as $post):?>
<!--    <div>-->
<!--        <h3>--><?//=$post['name']?><!--</h3>-->
<!--    </div>-->
<?php //endforeach;?>
</body>
</html>
