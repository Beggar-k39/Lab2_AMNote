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
	<title>Admin</title>
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
	<div class="ui container">
		<div class="pusher">

			<!-- Site content !-->
			<!-- <div class="ui container"> -->
				<h3 id="hello"></h3>
				<h2 id="table"></h2>
				<div class="ui fluid form">
					<div class="inline field">
						<input type="text" placeholder="Nhập thông tin cần tìm" id="search">
					</div>
				</div>
				<div id="content">
					<table class="ui celled fixed padded table" id="myTable">
						<thead>
							<tr class="ui center aligned">
								<th>ID</th>
								<th>Username</th>
								<th>Password</th>
								<th>Role</th>
								<th><button class="ui green button" id="btnThem">Thêm</button></th>
							</tr>
						</thead>
						<tbody id="data">
						</tbody>
						<tfoot>
							<tr><th colspan="5">
								<div class="ui right floated pagination menu"></div>
							</th>
						</tr>
					</tfoot>
				</table>
			</div>
			<!-- </div> -->
		</div>
	</div>
	<!-- Modal -->
	<?php require "modal/nguoidungmodal.php" ?>
</body>
<?php require "source/script.php" ?>
<script type="text/javascript">
	$(document).ready(function(){
		var them=false;
		var verify="0";
		var page=1;
		$('#hello').text("Welcome "+sess);
		$('#table').text("BẢNG NGƯỜI DÙNG");
		$('#menu').click(function(){
			$('.ui.sidebar').sidebar('toggle');
		});
			// Show modal khi bấm nút thêm
			$('#btnThem').click(function(){
				$(".header").text("Thêm người dùng");
				$(".id").hide();
				them=true;
				verify="0";
				$('.modal').find('form').trigger('reset');
				$('#verify').text('');
				$('.them').show();
				$('.sua').hide();
				$('.coupled.modal').modal({allowMultiple: false});
				$('.first.modal').modal('setting', 'closable', false).modal('show');
				// SelectCV();
				// if else
				// $('.second.modal').modal('attach events', '.first.modal .them');
				// $('.third.modal').modal('attach events', '.first.modal .dong');
			});
			// Kiểm tra giá trị username khi nhập
			$('#un').blur(function(){
				if(them){
					var un=$('#un').val();
					if(un!=""){
						$.ajax({
							url:'process/nguoidung.php',
							type:'get',
							data:{type:'verify',un:un},
							success:function(data){
								if(data=="1"){
									$('#verify').text("Tên đăng nhập đã tồn tại").css("color","red");
									verify="0";
								}else{
									$('#verify').text("Tên này có thể sử dụng được!").css("color","green");
									verify="1";
								}
							}
						});
					}
				}
			});
			// Bấm nút thêm trong modal Thêm
			$(".them").click(function(){
				// alert('click');
				var un=$('#un').val();
				var pw=$('#pw').val();
				if(un!=""&&pw!=""&&verify=="1"){
					var role=$("#select option:selected").val();
					alert(un+pw+role);
					$.ajax({
						url:'process/nguoidung.php',
						type:'get',
						data:{type:"them",page:page,un:un,pw:pw,role:role},
						success:function(data){
							$('#data').html(data);
							$(".msg-m").text("Thêm thành công!");
							$('.modal').modal('hide');
							$('.second.modal').modal('show');
							them=false;
						}
					});
				}else{
					$('#trong').text("Vui lòng nhập đầy đủ thông tin!").css("color","red");
				}
			});
			
			// Load table when user login
			$.ajax({
				url:'process/nguoidung.php',
				type:'get',
				data:{type:"load",page:page},
				success:function(data){
					$('#data').html(data);
				}
			});
			// Hàm Load 
			function Load(){
				$.ajax({
					url:'process/nguoidung.php',
					type:'get',
					data:{type:"load",page:page},
					success:function(data){
						$('#data').html(data);
					}
				});
			}
			// Đóng modal 
			$('.dong').click(function(){
				$('.modal').modal('hide');
			});
			// Event Delegate
			// Khi bấm nút sửa hiện modal sửa
			$("#data").on('click', '.btnSua', function() {
				them=false;
				$(".header").text("Sửa người dùng");
				$('#verify').text("");
				$('#trong').text("");
				$('.sua').show();
				$('.them').hide();
				$(".id").show();
				var id=$(this).data('id');
				$.ajax({
					url:'process/nguoidung.php',
					type:'get',
					data:{type:'getid',id:id},
					success:function(data){
						data = JSON.parse(data);
						$('.coupled.modal').modal({allowMultiple: false});
						$('.first.modal').modal('setting', 'closable', false).modal('show');

						$('#id').val(data["id"]);
						$('#un').val(data["username"]);
						$('#pw').val(data["password"]);
						// $('#cv').val(data["role"]);					
						$("#select option[value='"+data["role"]+"']").attr('selected', 'selected');
					}
				});
			});
			// Khi bấm nút sửa trong modal Sửa
			$('.sua').click(function(){
				$(".id").show();
				var id=$('#id').val();
				var un=$('#un').val();
				var pw=$('#pw').val();
				var role=$('#select').val();
				// alert(un+pw+role+id);
				$.ajax({
					url:'process/nguoidung.php',
					type:'get',
					data:{type:"sua",id:id,un:un,pw:pw,role},
					success:function(data){
						$('#data').html(data);
						$(".msg-m").text("Sửa thành công!");
						$('.modal').modal('hide');
						$('.second.modal').modal('show');
					}

				});
			});
			// Event Delegate
			// Khi bấm nút xóa hiện modal xóa
			$(document).on('click', '.btnXoa', function() {
				var id=$(this).data('id');
				$('#idxoa').text(id).hide();
				$(".header").text("Xác nhận xóa");
				$('.mini.modal').modal('show');
			});
			// Bấm nút xóa trong modal xóa
			$('.xoa').click(function(){
				// var id=$(this).data('id');
				id=$('#idxoa').text();
				$.ajax({
					url:'process/nguoidung.php',
					type:'get',
					data:{type:"xoa",id:id},
					success:function(data){
						// alert(id);
						$('#data').html(data);
						$(".msg-m").text("Xóa thành công!");
						$('.mini.modal').modal('hide');
						$('.second.modal').modal('show');
						// Load();
						// PhanTrang();
					}
				});
			});
			// Lấy số dòng data trong bảng
			$.ajax({
				url:'process/nguoidung.php',
				type:'get',
				data:{type:"count"},
				success:function(data){
					html='';
					html+=`<a class="icon item">
					<i class="left chevron icon"></i>
					</a>`;
					var i=2;
					html+=`<a class="item active page" data-page=1>1</a>`;
					for (i; i <= data ; i++) { 
						html+=`<a class="item page" data-page=`+i+`>`+i+`</a>`;
					}
					html+=`
					<a class="icon item">
					<i class="right chevron icon"></i>
					</a>`;
					$('.pagination').html(html);
				}
			});
			// Phân trang paninagation
			$(document).on('click','.page',function(){
				$('.page').removeClass("active");
				$(this).addClass("active");
				page=$(this).data('page');
				$.ajax({
					url:'process/nguoidung.php',
					type:'get',
					data:{type:"load",page:page},
					success:function(data){
						$('#data').html(data);
					}
				});
			});
			// Hàm phân trang
			function PhanTrang(){
				$('.page').removeClass("active");
				$(this).addClass("active");
				page=$(this).data('page');
				$.ajax({
					url:'process/nguoidung.php',
					type:'get',
					data:{type:"load",page:page},
					success:function(data){
						$('#data').html(data);
					}
				});
			}
			// Load select Chức vụ
			function SelectCV(){
				// Select Chuc Vu
				$.ajax({
					url:"process/nguoidung.php",
					type:"get",
					data:{type:"getcv"},
					success:function(data){
						console.log(data);
						$('#select').html(data);
					}
				});
			}
			SelectCV();
			$('#search').keyup(function(){
				var search= $('#search').val();
				if(search==""){
					Load();
				}
				console.log(search);
				$.ajax({
					url:'process/nguoidung.php',
					type:'get',
					data:{type:"search",search:search},
					success:function(data){
						$('#data').html(data);
					}
				});
			});
		});
	</script>
	</html>