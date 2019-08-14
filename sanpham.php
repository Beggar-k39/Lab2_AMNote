<script type="text/javascript">
	var sess=sessionStorage.getItem('key');
	// alert(sess);
	if(sess==null){
		window.location="login.php";
	}
</script>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Trang sản phẩm</title>
	<?php require "source/style.php" ?>
</head>
<body>
	<div class="ui sidebar inverted vertical menu">
		<a class="item" href="trangchu.php">
			<i class="icon blind"></i>
			Người dùng
		</a>
		<a class="item" href="sanpham.php">
			<i class="icon dropbox"></i>
			Sản phẩm
		</a>
		<a class="item">
			<i class="icon dropbox microsoft"></i>
			Thể loại sản phẩm
		</a>
	</div>
	<button class="ui black button" id="menu">
		<i class="icon list"></i>
	</button>
	<div class="ui fluid container">
		<div class="pusher">
			<h3 id="hello"></h3>
			<h2 id="table"></h2>
			<div class="ui fluid form">
				<div class="inline field">
					<input type="text" placeholder="Nhập thông tin cần tìm" id="search">
				</div>
			</div>

			<div class="ui fluid form">
				<div class="inline field">
					<input type="date" placeholder="Nhập ngày bắt đầu" id="startD">
					<i class="arrows alternate horizontal icon"></i>
					<input type="date" placeholder="Nhập ngày kết thúc" id="endD">
					<button id="searchD" class="ui green button">Tìm kiếm theo ngày</button>
				</div>
			</div>

			<div id="content">
				<table class="ui celled padded table" id="myTable">
					<thead>
						<tr class="ui center aligned">
							<th value="0" data-def="id">ID<i class="sort icon sr"></i></th>
							<!-- <th><a  href="process/sanpham.php?type=sortname&sort=true">Tên SP <span id="sortname"></span></th> -->
								<th value="0" data-def="tensp">Tên SP<i class="sort icon sr"></i></th>
								<th value="0" data-def="giacu">Giá cũ( VND)<i class="sort icon sr"></i></th>
								<th value="0" data-def="giamoi">Giá mới (VND<i class="sort icon sr"></i></th>
								<th value="0" data-def="soluong">Số lượng (cái)<i class="sort icon sr"></i></th>
								<th value="0" data-def="ngaynhap">Ngày nhập<i class="sort icon sr"></i></th>
								<th value="0" data-def="tinhtrang">Tình trạng<i class="sort icon sr"></i></th>
								<th value="0" data-def="trangthai">Trạng thái<i class="sort icon sr"></i></th>
								<th value="0" data-def="idloaisp">Loại SP<i class="sort icon sr"></i></th>
								<td><button class="ui green button" id="btnThem">Thêm</button></td>
							</tr>
						</thead>
						<tbody id="data">
						</tbody>
						<tfoot id="page">
<!-- 						<tr><th colspan="5">
							<div class="ui right floated pagination menu"></div>
						</th>
					</tr> -->
				</tfoot>
			</table>
		</div>
	</div>
</div>
<?php require "modal/sanphammodal.php" ?>
</body>
<?php require "source/script.php" ?>
<script type="text/javascript">

	$(document).ready(function(){
		// $('a').on('click',function(e){
		// 	e.preventDefault();
		// 	var url = $(this).attr('href');
		// 	// alert();
		// 	$.ajax({
		// 		url:url,
		// 		type:'get',
		// 		dataType:'JSON',
		// 		// contentType: false,
		//  		// processData: false,
		// 		success:function(data){
		// 			 console.log(data);
		// 			if(data.sort==true){
		// 				$("#sortname").html('<i class="sort alphabet down icon"></i>');
		// 				$('a').attr('href','process/sanpham.php?type=sortname&sort='+data.sort);
		// 			    // alert();
		// 			}else{
		// 				$("#sortname").html('<i class="sort alphabet up icon"></i>');
		// 				$('a').attr('href','process/sanpham.php?type=sortname&sort='+data.sort);
		// 			}
		// 			// $('#data').html(data);
		// 		}
		// 	})
		// })

		$('th').click(function(){
			var status=$(this).attr("value");
			var def =$(this).data('def');

			var balance='<i class="sort icon sr"></i>';
			$('thead th').attr("value",0);
			$('thead th').find('i').remove();
			$('thead th').append(balance);
			$(this).find('i').remove();
			if(status==0){ // Sắp xếp tăng
				$(this).append('<i class="sort amount down icon red"></i>');
				status++;
			}else if(status==1){ // Sắp xếp giảm
				$(this).append('<i class="sort amount up icon red"></i>');
				status++;
			}else{
				$(this).append('<i class="sort icon sr"></i>');
				status=0; // Không sắp xếp
			}
			$(this).attr("value",status);
			console.log(status+def);
			$.ajax({
				url:'process/sanpham.php',
				type:'get',
				data:{type:"load",status:status,def:def},
				success:function(data){
					$('#data').html(data);
				}
			})
		})
		// Phân trang mặc đinh là 1
		var page =1;
		var numpage=0;
		var idlb;
		$('#hello').text("Xin chào "+sess);
		$('#menu').click(function(){
			$('.ui.sidebar').sidebar('toggle');
		})
		function Load(){
			$('th').css("cursor","pointer");
			$.ajax({
				url:'process/sanpham.php',
				type:'get',
				data:{type:'load',page:page},
				success:function(data){
					// alert(data);
					$('#data').html(data);
				}
			})
			$.ajax({
				url:'process/sanpham.php',
				type:'get',
				data:{type:'count'},
				success:function(data){
					numpage=data;
					// alert(countTotal);
				}
			})
		}
		Load();
		// Tìm kiếm
		$('#search').keyup(function(){
			var search=$('#search').val();
			if(search==""){
				Load();
			}
			else{
				$.ajax({
					url:'process/sanpham.php',
					type:'get',
					data:{type:'tim',search:search},
					success:function(data){
					// console.log(data);
					$('#data').html(data);
					// Load();
				}
			})
			}

		})
		// Phân trang
		$(document).on('click','.page',function(){
			var p =$(this).text();
			page =p;
			Load();
		})
		$(document).on('click','.prev',function(){
			page--;
			if(page<1){
				page=1;
			}
			// event.preventDefault();
			// page=page>1?page-1:page;
			Load();
		})
		$(document).on('click','.next',function(){
			page++;
			if(page>numpage){
				page=numpage;
			}
			// page=page<numpage?page+1:page;
			Load();
		})
		// Nút gạt trạng thái
		$(document).on('click','.tt',function(){
			if($(this)[0].hasAttribute("checked")){
				$(this).removeAttr("checked");
				var tt=0;
			}else{
				$(this).attr("checked","checked");
				var tt=1;
			}
			var id = $(this).data('idtt');
			// alert(id);
			$.ajax({
				url:"process/sanpham.php",
				type:"get",
				data:{type:"trangthai",idtt:id,tt:tt},
				success:function(data){

				}
			})
		})

		 // Chuyển đổi nhãn
		 $(document).on('click','.lb',function(){
		 	idlb=parseInt($(this).data('idlb'));
		 	id=parseInt($(this).data('id'));
		 	if(idlb>=2){
		 		idlb=0;
		 	}else{
		 		idlb++;
		 	}
		 	$.ajax({
		 		url:'process/sanpham.php',
		 		type:'get',
		 		data:{type:"tinhtrang",idlb:idlb,id:id},
		 		success:function(data){
		 			Load();
		 		}
		 	})
		 })
		 // Load loại sản phẩm ngay từ lúc đầu khi vừa load dữ liệu lên
		 $.ajax({
		 	url:'process/sanpham.php',
		 	type:'get',
		 	data:{type:"loaisanpham"},
		 	success: function(data){
		 		$('#selectlsp').html(data);
		 	}
		 })
		 // Nút đóng modal
		 $('.dong').click(function(){
		 	$('.first.modal').modal('hide');
		 	Load();
		 })
		 // Nút thêm để hiện modal
		 $('#btnThem').click(function(){
		 	// $('.first.modal').modal("show");
		 	$('.coupled.modal').modal({allowMultiple: false});
		 	$('.first.modal').modal('setting', 'closable', false).modal('show');
		 	$('.sua').hide();
		 	$('.them').show();
		 	$('.divid').hide();
		 	$('#formsp')[0].reset();
		 	// $('input[name="status"][value="1"]').removeAttr('checked', 'true');
		 	$('input[name="status"][value="0"]').attr('checked', 'true');

		 })
		 // Nút thêm trong modal Thêm
		 $('.them').click(function(){
		 	var formData = new FormData($('form#formsp')[0]);
		 	// console.log(formData.get("ten"));
		 	// console.log(formData.get("gc"));
		 	// console.log(formData.get("gm"));
		 	// console.log(formData.get("sl"));
		 	// console.log(formData.get("nn"));
		 	// console.log(formData.get("tt"));
		 	// console.log(formData.get("status"));
		 	// console.log(formData.get("selectlsp"));
		 	$.ajax({
		 		url:'process/sanpham.php?type=them',
		 		type:'post',
		 		data:formData,
		 		contentType: false,
		 		processData: false,
		 		success:function(data){
		 			$('.first.modal').modal('hide');
		 			Load();
		 		}
		 	})

		 })
		 // Nút sửa để hiện modal
		 $(document).on('click','#btnSua',function(){
		 	// $('.first.modal').modal("show");
		 	var id =$(this).data('id');
		 	$('.coupled.modal').modal({allowMultiple: false});
		 	$('.first.modal').modal('setting', 'closable', false).modal('show');
		 	$('.sua').show();
		 	$('.them').hide();
		 	$('.divid').show();
		 	// alert(id);
		 	$.ajax({
		 		url:"process/sanpham.php",
		 		type:"get",
		 		data:{type:'getid',id:id},
		 		success:function(data){
		 			data=JSON.parse(data);
		 			$('#id').val(data["id"]);
		 			$('#ten').val(data["tensp"]);
		 			$('#gc').val(data["giacu"]);
		 			$('#gm').val(data["giamoi"]);
		 			$('#sl').val(data["soluong"]);
		 			$('#nn').val(DateStr(data["ngaynhap"]));

		 			$('#tt').val(data["tinhtrang"]);
		 			if(data["trangthai"]==0){
		 				$('input[name="status"][value="1"]').removeAttr('checked', 'true');
		 				$('input[name="status"][value="0"]').attr('checked', 'true');
		 			}else{	
		 				$('input[name="status"][value="0"]').removeAttr('checked', 'true');
		 				$('input[name="status"][value="1"]').attr('checked', 'true');
		 			}
		 			// $('#status').val(data["trangthai"]);
		 			$('#selectlsp').val(data["idloaisp"]);
		 		}
		 	})
		 })
		 // Ấn nút sửa trong modal gửi dữ liệu sửa lên server 
		 $('.sua').click(function(){
		 	// var id =$(this).data('id');
		 	// alert(id);
		 	var formData=new FormData($('form#formsp')[0]);
		 	formData.append("id",$('#id').val());
		 	$.ajax({
		 		url:'process/sanpham.php?type=sua',
		 		type:'post',
		 		data:formData,
		 		contentType:false,
		 		processData:false,
		 		success:function(data){
		 			// alert(data);
		 			$('.first.modal').modal('hide');
		 			Load();
		 		}
		 	})
		 })
		 $(document).on('click','#btnXoa',function(event){
		 	var id =$(this).data('id');
		 	$('#idxoa').text(id);
		 	$('.del.modal').modal('show');
		 })
		 function DateStr($dateI){
		 	var dateStr=$dateI+"";
		 	var nam = dateStr.substr(0,4);
		 	var thang=dateStr.substr(4,2);
		 	var ngay=dateStr.substr(6,2);
		 	return nam+"-"+thang+"-"+ngay;
		 }
		 $('#searchD').click(function(){
		 	var startD=$('#startD').val();
		 	var endD=$('#endD').val();
		 	// if($startD=="" || $endD==""){
		 	// 	Load();
		 	// }
		 	$.ajax({
		 		url:'process/sanpham.php',
		 		type:'get',
		 		data:{type:"searchDate",startD:startD,endD:endD},
		 		success:function(data){
		 			$('#data').html(data);
		 		}
		 	})
		 })
		 // alert(DateStr(20190801));
		})
	</script>
	</html>