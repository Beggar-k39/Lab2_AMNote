<?php
if(isset($_POST['un'])&&isset($_POST['pw'])){
	$un=$_POST['un'];
	$pw=$_POST['pw'];
	require_once "mySQL.php";
	$stmt=$conn->prepare("SELECT * FROM nguoidung");
	$stmt->execute();
	$table=$stmt->fetchAll();
	$find=0;
	foreach ($table as $col) {
		// echo $col['username']."<br>";
		// echo $col['password'];
		if($un==$col['username']&&$pw==$col['password'])
		{
			$find=1;
			break;
		}
	}
	echo $find==1?"1":"0";
}
?>