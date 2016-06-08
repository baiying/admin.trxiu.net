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
	$("#managerid").val($(this).attr("data-manager-id"));
	$("#editModal").find("h3").html('编辑管理员信息');
	$("#editModal").modal('show');
});

function clearForm() {
	$(".username").val('');
	$(".password").val('');
	$("#managerid").val('0');
}