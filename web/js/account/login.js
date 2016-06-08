/**
 * 登录页JS脚本
 * @bai
 */
/**
 * 登录按钮点击事件
 */
$(".button-login").click(function() {
	var btn = $(this);
	var username = $("input[name=username]").val();
	var password = $("input[name=password]").val();
	var remember = $("input[name=remember]").prop("checked");
	var data = {username:username, password:password};
	if(remember) {
		data['remember'] = 1;
	}
	$.ajax({
		url: '/account/ajax/?act=login',
		type: 'post',
		dataType: 'json',
		data: data,
		beforeSend: function() {
			btn.attr("disabled", true);
		},
		success: function(json) {
			if(json.status == 'success') {
				location.href = "/site/index/";
				return true;
			} else {
				btn.attr("disabled", false);
				$(".alert").find("span").html(json.message);
				$(".alert").show();
			}
		}
	});
});