<?php 
$conn=new PDO('mysql:host=localhost;dbname=quanlysanpham','root','');
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$conn->exec("set names utf8");
?>