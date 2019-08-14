<div class="ui small first coupled modal">
	<i class="close icon"></i>
	<div class="header">Thêm người dùng</div>
	<div class="content">
		<div class="ui form">
			<form id="formsp">
				<div class="field required">
					<div class="divid">
					<label class="id" >ID</label>
					<input type="number" class="id" id="id" placeholder="ID" readonly="readonly">
					</div>
					<label>Tên sản phẩm</label>
					<input type="text" id="ten" name="ten" placeholder="Tên sản phẩm">
					<label>Giá cũ</label>
					<input type="number" id="gc" name="gc"  placeholder="Giá cũ">
					<label>Giá mới</label>
					<input type="number" id="gm" name="gm"  placeholder="Giá mới">
					<label>Số lượng</label>
					<input type="number" id="sl" name="sl"  placeholder="Số lượng">
					<label>Ngày nhập</label>
					<input type="date" id="nn" name="nn"  placeholder="Ngày nhập">
					<label>Tình trạng</label>
					<div class="field">
						<select id="tt" name="tt">
							<option value="0">Default</option>
							<option value="1">New</option>
							<option value="2">Hot</option>
						</select>
					</div>
					<label>Trạng thái</label>
					<div class="grouped fields">
						<div class="field">
							<div class="ui radio checkbox">
								<input type="radio" name="status" value="0" checked="true">
								<label>Ẩn</label>
							</div>
						</div>
						<div class="field">
							<div class="ui radio checkbox">
								<input type="radio" name="status" value="1" >
								<label>Hiện</label>
							</div>
						</div>
					</div>
					<label>Loại sản phẩm</label>
					<div class="ui form combo">
						<div class="field">
							<select class="select" id="selectlsp" name="selectlsp">
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

