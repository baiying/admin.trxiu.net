/**
 * 账号管理页面JS脚本
 */

$(".button-status").click(function() {
    var status = $(this).attr('data-status');
    var managerId = $(this).attr('data-manager-id');
    if(status == "2") {
        if(!confirm("确定要停止活动？")) {
            return false;
        }
    } else {
        if(!confirm("确定要解冻该账号？")) {
            return false;
        }
    }

    $.ajax({
        url: "/system/ajax/?act=changeStatus",
        type: 'post',
        dataType: 'json',
        data: {managerid:managerId, status:status},
        success: function(json) {
            if(json.status = 'success') {
                location.reload(true);
                return true;
            } else {
                alert(json.message);
                return false;
            }
        }
    });
});
/**
 * 添加管理员按钮
 */
$(".button-add").click(function() {
    clearForm();
    $("#editModal").find("h3").html('添加活动');
    $("#editModal").modal('show');
});
/**
 * 编辑管理员信息
 */
$(".button-edit").click(function() {
    clearForm();
    $(".ballot-ballot_name").val($(this).attr("data-ballot_name"));
    $(".ballot-description").val($(this).attr("data-description"));
    $("#ballot_id").val($(this).attr("data-ballot_id"));
    $("#editModal").find("h3").html('编辑活动信息');
    $("#editModal").modal('show');
});
/**
 * 浮层提交按钮点击事件
 */
$(".button-confirm").click(function() {
    var btn = $(this);
    var user = {
        username : $(".manager-username").val(),
        password : $(".manager-password").val(),
        mobile : $(".manager-mobile").val(),
        real_name : $(".manager-realname").val(),
        managerid : $("#managerid").val()
    }
    var act = user.managerid > 0 ? 'editManager' : 'createManager';

    if(user.username == "") {
        $("#editModal").find(".alert-error").find("span").html("账号不能为空");
        $("#editModal").find(".alert-error").show();
        return false;
    }
    if(act == 'createManager' && user.password == "") {
        $("#editModal").find(".alert-error").find("span").html("密码不能为空");
        $("#editModal").find(".alert-error").show();
        return false;
    }
    $.ajax({
        url: "/system/ajax/?act="+act,
        type: 'post',
        dataType: 'json',
        data: user,
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
    $(".manager-username").val('');
    $(".manager-password").val('');
    $(".manager-password").attr("placeholder", "");
    $(".manager-mobile").val('');
    $(".manager-realname").val('');
    $("#managerid").val('0');
}