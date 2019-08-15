<?php 
if(isset($_GET["type"])){
	$type=$_GET["type"];
	switch ($type) {
		case "load":
		$numrow=5;
		$page=isset($_GET["page"])?$_GET["page"]:1;
		settype($page,"integer");
		$pos=($page-1)*$numrow;
		settype($pos,"integer");
		if($pos<0){
			$page =1;
			$pos=0;
		}
		require "../mySQL.php";
		if(isset($_GET['status'])&&isset($_GET['def'])){
			$status=$_GET['status'];
			$def=$_GET['def'];
			$sort=$status==1?"ASC":"DESC";
			if($status==0){
				$def="id";
			}
			// echo $status.":".$def;
			$stmt=$conn->prepare("SELECT * FROM sanpham ORDER BY $def $sort limit $pos,$numrow");
		}
		else{
			$stmt=$conn->prepare("SELECT * FROM sanpham ORDER BY id DESC limit $pos,$numrow");
		}
		$stmt->execute();
		$data=$stmt->fetchAll();
		Load($data,$pos);
		Panigation($page);
		break;

		case "trangthai":
		if(isset($_GET["idtt"])&&isset($_GET["tt"])){
			$idtt=$_GET["idtt"];
			$tt=$_GET["tt"];
			// echo $idtt.":".$tt;
			settype($idtt,"integer");
			settype($tt,"integer");
			SetTrangThai($idtt,$tt);
		}
		break;
		case "tinhtrang":
		if(isset($_GET["idlb"])&&isset($_GET['id'])){
			$idlb=$_GET["idlb"];
			$id=$_GET["id"];
			settype($idlb,"integer");
			settype($id,"integer");
			ChuyenNhan($idlb,$id);
		}
		break;
		case "count":
		echo ceil(CountRow()/5);
		break;
		case "tim":
		if(isset($_GET["search"])){
			if($_GET["search"]!=""){
				Search($_GET["search"]);
			}
		}
		break;
		case "loaisanpham":
		LoaiSanPham();
		break;
		case "them":
		ThemSP();
		break;
		case "getid":
		if(isset($_GET["id"]))
			GetID();
		break;
		case "sua":
		SuaSP();
		break;
		case "searchDate":
		if(isset($_GET["startD"])&& isset($_GET["endD"])){
			$startD=$_GET["startD"];
			$endD=$_GET["endD"];
			SearchD($startD,$endD);
		}
		break;
		// case "sortname":
		// sortname($_GET["sort"]);
		// break;
	}
}
// function sortname($sort)
// {
// 		require "../mySQL.php";
// 		if($_GET["sort"]=='true'){


// 			$stmt=$conn->prepare("SELECT * FROM sanpham  ORDER BY tensp DESC");
// 			$stmt->execute();
// 			$data=$stmt->fetchAll();

// 		    echo json_encode(array('sort'=>false,'data'=>$data));

// 		}else{
// 				$stmt=$conn->prepare("SELECT * FROM sanpham  ORDER BY tensp ASC");
// 			$stmt->execute();
// 			$data=$stmt->fetchAll();
// 			 echo json_encode(array('sort'=>true,'data'=>$data));
// 		}
// 	// echo 1;
// }
function SearchD($start,$end){
	$sI=DateI($start);
	$eI=DateI($end);
	echo $sI.":".$eI;
	require "../mySQL.php";
	$stmt=$conn->prepare("SELECT * FROM sanpham WHERE ngaynhap>=$sI AND ngaynhap<=$eI");
	$stmt->execute();
	$data=$stmt->fetchAll();
	$count=$stmt->rowCount();
	Load($data,0);
	if($count>0){
		Panigation($page,$count);
	}
}
function SuaSP(){
	// echo $_POST['id'];
	// echo $_POST['ten'];
	// echo $_POST['gc'];
	// echo $_POST['gm'];
	// echo $_POST['sl'];
	// echo DateI($_POST['nn']);
	// echo $_POST['tt'];
	// echo $_POST['status'];
	// echo $_POST['selectlsp'];

	require "../mySQL.php";
	$stmt=$conn->prepare('UPDATE sanpham SET tensp=:tensp, giacu=:giacu, giamoi=:giamoi, soluong=:soluong, ngaynhap=:ngaynhap, tinhtrang=:tinhtrang, trangthai=:trangthai, idloaisp=:idloaisp WHERE id=:id');
	$stmt->execute([
		'tensp'=>$_POST['ten'],
		'giacu'=>$_POST['gc'],
		'giamoi'=>$_POST['gm'],
		'soluong'=>$_POST['sl'],
		'ngaynhap'=>DateI($_POST['nn']),
		'tinhtrang'=>$_POST['tt'],
		'trangthai'=>(bool)$_POST['status'],
		'idloaisp'=>$_POST['selectlsp'],
		'id'=>$_POST['id']
	]);
	$count=$stmt->rowCount();
	echo $count;
}

function GetID(){
	$id=$_GET["id"];
	require "../mySQL.php";
	$stmt=$conn->prepare("SELECT * FROM sanpham WHERE id=$id");
	$stmt->execute();
	$rs=$stmt->fetch(PDO::FETCH_ASSOC);
	if($stmt->rowCount()>0){
		echo json_encode($rs);
	}
}
function ThemSP(){
	// echo $_POST['ten'];
	// echo $_POST['gc'];
	// echo $_POST['gm'];
	// echo $_POST['sl'];
	// echo $_POST['nn'];
	// echo $_POST['tt'];
	// echo $_POST['status'];
	// echo $_POST['selectlsp'];
	require "../mySQL.php";
	$stmt=$conn->prepare("INSERT INTO sanpham (tensp, giacu, giamoi, soluong, ngaynhap, tinhtrang, trangthai, idloaisp) VALUES (:ten,:gc,:gm,:sl,:nn,:tt,:status,:selectlsp)");
	$stmt->execute([
		'ten'=>$_POST['ten'],
		'gc'=>$_POST['gc'],
		'gm'=>$_POST['gm'],
		'sl'=>$_POST['sl'],
		'nn'=>DateI($_POST['nn']),
		'tt'=>$_POST['tt'],
		'status'=>(bool)$_POST['status'],
		'selectlsp'=>$_POST['selectlsp'],
	]);
	$count=$stmt->rowCount();
	echo $count;
}
function DateI($dateS){
	return (int)str_replace("-", "", $dateS);
}
function LoaiSanPham(){
	require "../mySQL.php";
	$stmt=$conn->prepare("SELECT * FROM loaisanpham");
	$stmt->execute();
	$data=$stmt->fetchAll();
	foreach ($data as $row) {
		echo '<option value="'.$row["id"].'">'.$row["tenloai"].'</option>';
	}
}
function SetTrangThai($idtt,$tt){
	require "../mySQL.php";
	$trangthai=($tt==1)?"true":"false";
	$stmt=$conn->prepare("UPDATE sanpham SET trangthai=$trangthai WHERE id=$idtt");
	$stmt->execute();
	$count=$stmt->rowCount();
	echo $count;
}
function Load($data,$pos){
	$p=$pos+1;
	foreach ($data as $row) {
		echo '<tr>';
		// echo '<td>'.$row["id"].'</td>';
		echo '<td>'.($p++).'</td>';
		echo '<td>'.$row["tensp"].'</td>';
		echo '<td>'.number_format($row["giacu"]).'</td>';
		echo '<td>'.number_format($row["giamoi"]).'</td>';
		echo '<td>'.$row["soluong"].'</td>';
		echo '<td>'.strDay($row["ngaynhap"]).'</td>';
		echo '<td>'.TinhTrang($row["tinhtrang"],$row["id"]).'</td>';
		echo '<td class="ui center aligned">
		<div class="inline field">
		<div class="ui toggle checkbox">
		<input type="checkbox" class="tt" data-idtt='.$row['id'].' tabindex="0" class="hidden" '.($row["trangthai"]==1?"checked":"").'>
		<label></label>
		</div>
		</div>
		</td>';

			// echo '<td>'.$row["trangthai"].'</td>';
		echo '<td>'.GetLoaiSP($row["idloaisp"]).'</td>';
		echo '<td class="ui center aligned">';
		echo '<button id="btnSua" data-id="'.$row["id"].'" class="ui button yellow">Sửa</button>';
		echo '<button id="btnXoa" data-id="'.$row["id"].'" class="ui button red">Xóa</button>';
		echo '</td>';
	}

}
function Panigation($page,$count=0){
	echo '<tr>';
	echo '<tr>';
	echo '<th colspan="10"><div class="ui right floated pagination menu">
	<a class="icon item prev">
	<i class="left chevron icon"></i>
	</a>';

	$rowData=CountRow();
	if($count!=0){
		$rowData=$count;
	}
	$numrow=5;
	$totalPage=ceil($rowData/$numrow);
	for ($i = 1; $i <= $totalPage; $i++) {
		if($page==$i){
			echo '<a class="item active page">'.$i.'</a>';
			continue;
		}
		echo '<a class="item page">'.$i.'</a>';
	}

	echo '<a class="icon item next">
	<i class="right chevron icon"></i>
	</a>
	</div></th>';
	echo '</tr>';
}
function Search($search){
	require "../mySQL.php";

	$stmt=$conn->prepare("SELECT * FROM sanpham WHERE tensp LIKE '%$search%' OR 
		giacu LIKE '%$search%' OR 
		giamoi LIKE '%$search%' OR 
		soluong LIKE '%$search%' OR 
		ngaynhap LIKE '%$search%' OR 
		tinhtrang LIKE '%".TimTinhTrang($search)."%' OR 
		trangthai LIKE '%$search%'");
	$stmt->execute();
	$data=$stmt->fetchAll();
	$count=$stmt->rowCount();
	Load($data,0);
	if($count>0){
		Panigation($page,$count);
	}
}
function TimTinhTrang($str){
	if($str=="default"){
		return 0;
	}else if($str=="new"){
		return 1;
	}else{
		return 2;
	}
}
function GetLoaiSP($id){
	require "../mySQL.php";
	$stmt=$conn->prepare("SELECT tenloai FROM loaisanpham WHERE loaisanpham.id=$id");
	$stmt->execute();
	$data=$stmt->fetchAll();
	return $data[0][0];
	// return $data[];
}
function strDay($intD){
	$strD=$intD+"";
	$y=substr($strD,0,4);
	$m=substr($strD,4,2);
	$d=substr($strD,6,2);
	return $d."/".$m."/".$y;
}
function TinhTrang($idtt,$id){
	if($idtt==0){
		return '<a class="ui tag label lb" data-idlb="'.$idtt.'" data-id="'.$id.'">Default</a>';
	}else if($idtt==1){
		return '<a class="ui teal tag label lb" data-idlb="'.$idtt.'" data-id="'.$id.'">New</a>';
	}else{
		return '<a class="ui red tag label lb" data-idlb="'.$idtt.'" data-id="'.$id.'">Hot</a>';
	}
}
function ChuyenNhan($idlb,$id){
	require "../mySQL.php";
	$SQL ="UPDATE sanpham SET tinhtrang=".$idlb." WHERE id=".$id;
	$stmt=$conn->prepare($SQL);
	$stmt->execute();
	$count=$stmt->rowCount();
}
function CountRow(){
	require "../mySQL.php";
	$stmt=$conn->prepare('SELECT * FROM sanpham');
	$stmt->execute();
	$count=$stmt->rowCount();
	return $count;
}
?>