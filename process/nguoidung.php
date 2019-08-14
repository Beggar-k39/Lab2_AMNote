<?php 
if(isset($_GET['type'])){
	$type=$_GET['type'];
}
require "../mySQL.php";
$numrow=5;
$page=isset($_GET['page'])?$_GET['page']:1;
settype($page,"integer");
$chiso=($page-1)*$numrow;
settype($chiso,"integer");
switch ($type) {
	case "load":
	$stmt=$conn->prepare("SELECT * FROM nguoidung ORDER BY id DESC LIMIT $chiso,$numrow");
	$stmt->execute();
	$result = $stmt->fetchAll();
	render($result,$chiso);
	break;

	case "getcv":
	$stmt=$conn->prepare("SELECT DISTINCT nd.role,cv.TenCV  FROM nguoidung nd JOIN chucvu cv ON cv.id=nd.role");
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach ($result as $obj) {
		echo "<option value=".$obj['role'].">".$obj['TenCV']."</option>";
	}
	break;

	case "verify":
	$un=isset($_GET['un'])?$_GET['un']:"";
	$stmt=$conn->prepare("SELECT * FROM nguoidung WHERE username=:username");
	$stmt->execute(["username"=>$un]);
	$count = $stmt->rowCount();
	echo $count>0?"1":"0";
	break;

	case "them":
	$un=isset($_GET['un'])?$_GET['un']:"";
	$pw=isset($_GET['pw'])?$_GET['pw']:"";
	$role=isset($_GET['role'])?$_GET['role']:"";
	$stmt=$conn->prepare("INSERT INTO nguoidung (username, password, role) VALUES (:un, :pw, :role)");
	$stmt->execute(["un"=>$un,"pw"=>$pw,"role"=>$role]);
	reload($chiso,$numrow);
	break;

	case "sua":
	$id=isset($_GET['id'])?$_GET['id']:"";
	$un=isset($_GET['un'])?$_GET['un']:"";
	$pw=isset($_GET['pw'])?$_GET['pw']:"";
	$role=isset($_GET['role'])?$_GET['role']:"";
	settype($id,"integer");
	$stmt=$conn->prepare("UPDATE nguoidung SET username=:username, password=:password, role=:role WHERE id=:id");
	$stmt->execute(["username"=>$un,"password"=>$pw,"role"=>$role,"id"=>$id]);
	reload($chiso,$numrow);
	break;

	case "xoa":
	$id=isset($_GET['id'])?$_GET['id']:"";
	settype($id,"integer");
	// echo $id;
	$stmt=$conn->prepare("DELETE FROM nguoidung WHERE nguoidung.id=:id");
	$stmt->execute(["id"=>$id]);
	reload($chiso,$numrow);
	break;

	case "getid":
	$id=isset($_GET['id'])?$_GET['id']:"";
	settype($id,"integer");
	renderid($id,"nguoidung");
	break;

	case "count":
	$count=Rowcount();
	echo ceil($count/$numrow);
	break;

	case "search":
	if(isset($_GET['search'])){
		$search=$_GET['search'];
		if($search!=""){
			require "../mySQL.php";
			$stmt=$conn->prepare("SELECT * FROM nguoidung WHERE id LIKE '$search' OR username LIKE '%$search%' OR password LIKE '%$search%' OR role LIKE '%$search%'"  );	
			$stmt->execute();
			$rs=$stmt->fetchAll();
			render($rs,$chiso);
		}
	}
	break;
	default:
	// header('location:login.php');
	break;
}
// echo $chiso.":".$numrow;
// reload($chiso,$numrow);
function reload($chiso,$numrow){
	require "../mySQL.php";
	$stmt=$conn->prepare("SELECT * FROM nguoidung ORDER BY id DESC LIMIT $chiso,$numrow");
	$stmt->execute();
	$result = $st->fetchAll();
	// var_dump($result);
	render($result,$chiso);
}
function render($result,$chiso){
	$chiso=$chiso+1;
	foreach ($result as $obj) {
		echo '<tr>';
		echo '<td>'.($chiso++).'</td>';
		// echo '<td>'.$obj['id'].'</td>';
		echo '<td>'.$obj['username'].'</td>';
		echo '<td>'.$obj['password'].'</td>';
		echo '<td>'.role($obj['role']).'</td>';
		echo '<td class="center aligned">';
		echo '<button class="ui yellow button btnSua" data-id='.$obj['id'].'>Sửa</button>';
		echo '<button class="ui red button btnXoa" data-id='.$obj['id'].'>Xóa</button></td>';
		echo '</tr>';
	}
}
function renderid($id,$table){
	require "../mySQL.php";
	$stmt=$conn->prepare("SELECT * FROM $table WHERE id=:id");
	$stmt->execute(["id"=>$id]);
	$result=$stmt->fetch(PDO::FETCH_ASSOC);
	$count=$stmt->rowCount();
	if($count>0){
		echo json_encode($result);
	}
}
function role($id){
	require "../mySQL.php";
	settype($id,"integer");
	$stmt=$conn->prepare('SELECT * FROM chucvu WHERE id=:id');
	$stmt->execute(["id"=>$id]);
	$result = $stmt->fetchAll();
	return $result[0]['TenCV'];
}
function Rowcount(){
	require "../mySQL.php";
	$stmt=$conn->prepare('SELECT * FROM nguoidung');
	$stmt->execute();
	$count=$stmt->rowCount();
	return $count;
}
// echo json_encode($result);

	// $table=$stmt->fetchAll();
	// echo json_encode($table);
?>