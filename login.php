<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Đăng nhập</title>
	<?php require "source/style.php" ?>
</head>
<body>
	<div class="ui container segment">
		<form class="ui form">
			<div class="ui red message" id="error" style="display: none">Sai tên đăng nhập hoặc mật khẩu!</div>
			<div class="field">
				<label>Username</label>
				<div class="ui left icon input">
					<input type="text" placeholder="Username" id="un">
					<i class="user icon"></i>
				</div>
			</div>
			<div class="field">
				<label>Passsword</label>
				<div class="ui left icon input">
					<input type="password" placeholder="Password" id="pw">
					<i class="lock icon"></i>
				</div>
			</div>
			<span class="positive fluid ui button" id="login">Login</span>
		</form>
	</div>

	<!-- <h1>Chào mừng đến với Semantice UI</h1> -->

</body>
<?php require "source/script.php" ?>
<script type="text/javascript">
	sessionStorage.clear();
	$(document).ready(function(){
		$(document).on('keyup', function (e) {
			if (e.keyCode == 13) {
				$('#login').click();
			}
		});
		// $('#error').hide();
		$('#login').click(function(){
			var un=$('#un').val();
			var pw=$('#pw').val();
			if(un==""||pw==""){
				alert("Vui lòng nhập đủ thông tin");
			}
			$.ajax({
				url:"loginpro.php",
				type:"POST",
				data:{un:un,pw:pw},
				success:function(data){
					if(data=="1"){
						// alert("Đúng");
						sessionStorage.setItem('key', un);
						window.location="trangchu.php";
					}
					else{
						// alert("Sai");
						// $('#error').css("display","block");
						$('#error').show();
					}
				}
			});
		});
	});
</script>
</html>