<?php
	$chiso=0;
	$numrow=5;
	require "mySQL.php";
	$stmt=$conn->prepare("SELECT * FROM nguoidung ORDER BY id DESC LIMIT $chiso,$numrow");
	$stmt->execute();
	$result = $stmt->fetchAll();
	var_dump($result);
 ?>