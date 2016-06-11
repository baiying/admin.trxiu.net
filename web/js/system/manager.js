/**
 * 账号管理页面JS脚本
 */
/**
 * 添加管理员按钮
 */
$(".button-add").click(function() {
	clearForm();
	$("#editModal").find("h3").html('添加管理员');
	$("#editModal").modal('show');
});
/**
 * 编辑管理员信息
 */
$(".button-edit").click(function() {
	clearForm();
	$(".username").val($(this).attr("data-username"));
	$(".mobile").val($(this).attr("data-mobile"));
	$(".realname").val($(this).attr("data-realname"));
	$(".password").attr("placeholder", "如果不修改密码，则此处不要填写内容");
	$("#managerid").val($(this).attr("data-manager-id"));
	$("#editModal").find("h3").html('编辑管理员信息');
	$("#editModal").modal('show');
});

$(".button-confirm").click(function() {
	var btn = $(this);
	var username = $(".username").val();
	var password = $(".password").val();
	var managerid = $("#managerid").val();
	var act = managerid > 0 ? 'edit' : 'create';
	$.ajax({
		url: "/system/ajax/?act="+act,
		type: 'post',
		dataType: 'json',
		data: {username:username, password:password, managerid:managerid},
		beforeSend: function() {
			btn.button('loading');
		},
		success: function(json) {
			if(json.status = 'success') {
				location.reload(true);
				return true;
			} else {
				$("#editModal").find(".alert-error").find("span").html(json.message);
				$("#editModal").find(".alert-error").show();
				btn.button('reset');
				return false;
			}
		}
	});
});

function clearForm() {
	$(".username").val('');
	$(".password").val('');
	$(".password").attr("placeholder", "");
	$(".mobile").val('');
	$(".realname").val('');
	$("#managerid").val('0');
}