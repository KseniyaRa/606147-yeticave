<?php
$con = mysqli_connect("localhost", "root", "", "yeticave");
if ($con == false) {
   print("Ошибка подключения: ". mysqli_connect_error());
}
else {
   print("Соединение установлено");
   // выполнение запросов
?>