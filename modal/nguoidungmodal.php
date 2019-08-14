	
<div class="ui small first coupled modal">
	<i class="close icon"></i>
	<div class="header">Thêm người dùng</div>
	<div class="content">
		<div class="ui form">
			<form>
				<div class="field required">
					<label class="id" >ID</label>
					<input type="text" class="id" id="id" placeholder="ID" readonly="readonly">
					<label>Username</label>
					<input type="text" id="un" placeholder="Username">
					<p id="verify"></p>
					<p id="trong"></p>
					<label>Password</label>
					<input type="text" id="pw"  placeholder="Password">
					<label>Chức vụ</label>
					<!-- <input type="reset" value="Reset"> -->
					<div class="ui form combo">
						<div class="field">
							<select class="select" id="select">]
						<!-- 		<option value="1">Member</option>
							<option value="2">Admin</option> -->
						</select>
					</div>
				</div>

			</div>
			<div class="actions">
				<div class="ui green button them">Thêm</div>
				<div class="ui yellow button sua">Sửa</div>
				<div class="ui red button dong">Thoát</div>
			</div>
		</form>
	</div>
</div>
</div>
<div class="ui small second modal tc">
	<i class="close icon"></i>
	<div class="ui green message header">Thành công</div>
	<div class="content">
		<div class="ui green message msg-m">
			Thêm dữ liệu thành công!
		</div>
	</div>
</div>
<div class="ui small third modal tb">
	<i class="close icon"></i>
	<div class="ui red message header">Thất bại</div>
	<div class="content">
		<div class="ui red message">
			Thêm dữ liệu thất bại!
		</div>
	</div>
</div>
<div class="ui mini del modal">
	<i class="close icon"></i>
	<div class="ui header">Xác nhận xóa</div>
	<div class="content">
		<span id="idxoa"></span>
		Bạn có muốn xóa dữ liệu này không?
	</div>
	<div class="actions">
		<div class="ui red button xoa">Xóa</div>
		<div class="ui cancel button huy">Hủy bỏ</div>
	</div>
</div>

