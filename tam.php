<script type="text/javascript">
	document.getElementById('hello').innerHTML="Chào mừng "+sess+" tới trang chủ";

		$(document).ready( function () {
			var html='';
			document.getElementById('sanpham').onclick=function(){

			// $('#myTable').dataTable( {
			// 	"ajax":{
			// 		"url":"process/sanpham.php",
			// 		"dataSrc":""
			// 	},
			// 	"columns":[
			// 	{"data":"id"},
			// 	{"data":"username"},
			// 	{"data":"password"},
			// 	{"data":"role"},
			// 	]});
			$.ajax({
				url:'process/sanpham.php',
				type:'get',
				dataType:'JSON',
				success:function(data){
					$('#table').text("Bảng sản phẩm");
					
					var html=`<thead><tr><th>ID</th><th>TÊN SP</th><th>GIÁ CŨ</th><th>GIÁ MỚI</th><th>SỐ LƯỢNG</th><th>NGÀY NHẬP</th><th>TÌNH TRẠNG</th><th>TRẠNG THÁI</th><th>LOẠI SP</th>
					<th class="ui center aligned">
					<button class="ui green button">Thêm</button>
					</th></tr></thead><tbody>`;
					$.each(data, function( index, item ) {
						html+='<tr>';
						html+='<td>'+item.id+'</td>';
						html+='<td>'+item.tensp+'</td>';
						html+='<td>'+item.giacu+'</td>';
						html+='<td>'+item.giamoi+'</td>';
						html+='<td>'+item.soluong+'</td>';
						html+='<td>'+item.ngaynhap+'</td>';
						html+='<td>'+item.tinhtrang+'</td>';
						html+='<td>'+item.trangthai+'</td>';
						html+='<td>'+item.idloaisp+'</td>';
						html+='<td class="ui center aligned">';
						html+='<a href="sanpham.php?id='+item.id+'&t=a" class="ui violet button">Sửa</a>';
						html+='<a href="sanpham.php?id='+item.id+'&t=e" class="ui red button">Xóa</a>';
						html+='</td>';
						html+='</tr>';
					});
					html+='</tbody>';
					
					$("#myTable").html(html);
					$('#myTable').DataTable();
					// table.destroy();
					

				}
			});
			document.getElementById('nguoidung').onclick=function(){

				var html='';
				$.ajax({
					url:'process/nguoidung.php',
					type:'get',
					dataType:'JSON',
					success:function(data){
						var html=`<thead><tr><th>ID</th><th>USER NAME</th><th>PASSWORD</th><th>ROLE</th>
						<th class="ui center aligned">
						<button class="ui green button">Thêm</button>
						</th></tr></thead><tbody>`;
						$('#table').text("Bảng người dùng");


						$.each(data,function(index,item){
							html+="<tbody><tr>";
							html+="<td>"+item.id+"</td>";
							html+="<td>"+item.username+"</td>";
							html+="<td>"+item.password+"</td>";
							html+="<td>"+item.role+"</td>";
							html+='<td class="ui center aligned">';
							html+='<a href="sanpham.php?id='+item.id+'&t=a" class="ui violet button">Sửa</a>';
							html+='<a href="sanpham.php?id='+item.id+'&t=e" class="ui red button">Xóa</a>';
							html+='</td>';
							html+="</tr>";
						});
						html+='</tbody>';

						$("#myTable").html(html);
						$('#myTable').DataTable();
					// table.destroy();
					
				}
			});
			}
			document.getElementById('loaisanpham').onclick=function(){

				var html='';
			// $.ajax({
			// 	url:'process/loaisanpham.php',
			// 	type:'get',
			// 	dataType:'json',
			// 	success:function(data){
			// 		var html=`<thead><tr><th>ID</th><th>TÊN LOẠI SẢN PHẨM</th><th class="ui center aligned">
			// 		<button class="ui green button">Thêm</button>
			// 		</th></tr></thead>`;
			// 		$('#table').text("Bảng loại sản phẩm");
			// 		html+="<tbody>";
			// 		$.each(data,function(index,item){
			// 			html+="<tbody><tr>";
			// 			html+="<td>"+item.id+"</td>";
			// 			html+="<td>"+item.tenloai+"</td>";
			// 			html+='<td class="ui center aligned">';
			// 			html+='<a href="sanpham.php?id='+item.id+'&t=a" class="ui violet button">Sửa</a>';
			// 			html+='<a href="sanpham.php?id='+item.id+'&t=e" class="ui red button">Xóa</a>';
			// 			html+='</td>';
			// 			html+="</tr>";
			// 		});
			// 		html+="</tbody>";

			// 		$("#myTable").html(html);
			// 		$('#myTable').DataTable();

			// 	}
			// });
			$.ajax({
				url:'process/loaisanpham.php',
				type:'get',
				dataType:'json',
				success:function(data){
					console.log(data);
					$('#myTable').DataTable({
						columns: [
						{ data: 'id' },
						{ data: 'tenloai' },
						]
					});
				}
			});

		}
		$('#hienmodal').click(function(){
			// $('.small.modal').modal('show');
			$('.coupled.modal').modal({allowMultiple: false});
			$('.first.modal').modal('show');
			$('.second.modal').modal('attach events', '.first.modal .them');
			$('.third.modal').modal('attach events', '.first.modal .dong');

		});
</script>