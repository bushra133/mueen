<?php

$connection = [
  'host'=> 'localhost',
  'user'=> 'root',
  'password' => '',
  'database' => 'mueen'
];
// how to connect to database
$mysqli = new mysqli(
  $connection['host'],
  $connection['user'],
  $connection['password'],
  $connection['database']
);

// للتحقق من الاتصال مع قاعدة البيانات
if($mysqli->connect_error){
  die("error connecting to database". $mysqli->connect_error);
}
 ?>
