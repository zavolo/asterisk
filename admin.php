<?php
session_start();
$numbers = scandir("/var/lib/asterisk/records");
$adm = 'admin';
if(isset($_GET['download'])){
  $fileName = '/var/lib/asterisk/records/'.$_GET['download'];
  header("Content-Type: audio/wav");
  header("Content-Length: " . filesize($fileName));
  header("Content-Disposition: attachment; filename=record.wav");
  readfile($fileName);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Asterisk | Администрирование</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="/phone.png" type="image/x-icon">
<style>
body {
 font-family: Arial, sans-serif;
 background-color: #f2f2f2;
 margin: 0;
}

.container {
 max-width: 800px;
 margin: 0 auto;
 background-color: #ffffff;
 padding: 20px;
 border: 1px solid #dddddd;
}

h1 {
 text-align: center;
 font-family: "Bell Gothic Std Black", sans-serif;
 color: #333333;
 font-size: 24px;
 margin: 0;
}

p {
 font-family: "Bell Gothic Std Black", sans-serif;
 color: #333333;
 font-size: 16px;
 margin-top: 10px;
}

.text-center {
 text-align: center;
}
.text-left {
 text-align: left;
}

.text-right {
 text-align: right;
}

.img-right {
 float: right;
 margin-left: 20px;
 margin-bottom: 20px;
}

table {
 width: 100%;
 border-collapse: collapse;
 margin-top: 20px;
}

th, td {
 border: 1px solid #dddddd;
 padding: 8px;
 text-align: left;
}

.header {
 background: linear-gradient(to bottom, #04d120, #03a319);
 color: #FF0000;
 padding: 10px;
 text-align: center;
 border-radius: 8em;
}

.header h1 {
 margin: 0;
 font-size: 24px;
 font-weight: bold;
}

.header p {
 margin: 0;
 font-size: 16px;
 font-weight: bold;
}

.text-field__label {
 display: block;
 margin-bottom: 0.25rem;
}

.text-field__input {
 padding: 0.375rem 0.75rem;
 font-family: inherit;
 font-size: 1rem;
 font-weight: 400;
 line-height: 1.5;
 color: #212529;
 background-color: #fff;
 background-clip: padding-box;
 border: 1px solid #bdbdbd;
 border-radius: 0.25rem;
 transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.text-field__input::placeholder {
 color: #212529;
 opacity: 0.4;
}

.text-field__input:focus {
 color: #212529;
 background-color: #fff;
 border-color: #bdbdbd;
 outline: 0;
 box-shadow: 0 0 0 0.2rem rgba(158, 158, 158, 0.25);
}

.text-field__input:disabled,
.text-field__input[readonly] {
 background-color: #f5f5f5;
 opacity: 1;
}

button {
 padding: 10px 20px;
 background-color: #009900;
 color: #FFFFFF;
 border: none;
 cursor: pointer;
}
</style>
</head>
<body>
<div class="header">
<h1><font color="white">Asterisk</font></h1>
<p><font color="yellow">Asterisk, технологии возможностей! Всего звонков:
<?php
$cnt = count($numbers);
echo ($cnt -2);
?></font></p>
</div>
<div class="container">
<?php
if ($_GET['action'] == 'logout') {
   session_start();
   session_destroy();
   header("Location: /");
   exit();
} elseif ($_GET['action'] == 'login') {
if(isset($_POST['submit'])){
 $pass = $_POST['pass'];
 if($pass == $adm){
   $_SESSION['admin'] = 'admin';
   header("Location: /admin.php");
   exit();
 }
}
?>
<h1>Вход</h1>
<p class="text-left">
<form acton="admin.php?action=login" method="POST">
<label class="text-field__label">Введите пароль:</label>
<input class="text-field__input" name="pass" type="text">
<button name="submit" type="submit">Войти</button>
</form>
</p>
<?php
} else {
if (empty($_SESSION['admin'])) {
 header("Location: /admin.php?action=login");
 exit();
}
?>
<h1>Администрирование | <a href="/admin.php?action=logout">Выйти</a></h1>
Список звонивших номеров:
<p class="text-left">
<?php 
foreach($numbers as $phone){
 $phonee = mb_strimwidth($phone, 0, 29, "");
 echo $phonee.' | <a href="admin.php?download='.$phone.'">Скачать</a><br>';
}
?>
</p>
<?php
}
?>
</body>
</html>
