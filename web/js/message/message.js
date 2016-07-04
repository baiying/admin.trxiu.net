/**
 * 群发消息
 */
$(".button-addAllMessage").click(function () {
    clearForm();
    $("#addMessage").find("h3").html('群发消息');
    $("#addMessage").modal('show');
});
/**
 * 选择性发送
 */
$(".button-addOptionalMessage").click(function () {
    $.ajax({
        url: "/message/ajax/?act=fansList",
        type: 'get',
        dataType: 'json',
        data: [],
        success: function (json) {
            if (json.status == 'success') {
                var fansList = json.data;
                var search_td = document.getElementById('search_td');
                $("#search_td").append(
                    "<ul id='search_td_all'></ul>"
                );
                $.each(fansList, function (key, val) {
                    $("#search_td_all").append(
                        "<li class='search_li' style='display: none'><input id='search_td_all_list'  class='check_user' type='checkbox' name='user_all' value='" + val.fans_id + "' data-wx_name='" + val.wx_name + "'/>" + val.wx_name + "</li><br>"
                    );
                });
                $('.check_user').on('click', function () {
                    var userCheckbok = this;
                    var text = $(this).attr("data-wx_name");
                    userCheck(userCheckbok, text);
                });
                clearForm();
                $("#addMessageMore").find("h3").html('选择用户发送');
                $("#addMessageMore").modal('show');
                return true;
            } else {
                $("#addMessage").find(".alert-error").find("span").html(json.message);
                $("#addMessage").find(".alert-error").show();
                btn.button('reset');
                return false;
            }
        }
    });
});
/**
 * 分组折叠
 */
$("#user_group").click(function () {
    var user_group = $(this).attr("data-user_group");
    var user = document.getElementsByClassName(user_group);
    $.each(user, function (key) {
        if (user[key].style.display == "none") {
            user[key].style.display = "block";
        } else {
            user[key].style.display = "none";
        }
    });
});
/**
 * 全选事件
 */
$("#search_td_group").click(function () {
    var list_name = this.value;
    var user_list = document.getElementsByClassName(list_name);
    var checked = this.checked;
    $.each(user_list, function (key, user) {
        var userCheckbok = user.childNodes[0];
        var text = user.childNodes[1].nodeValue;
        userCheckbok.checked = checked;
        userCheck(userCheckbok, text);
    });
});
$('.check_user').on('click', function () {
    console.log('haha');
});

/**
 * 选择触发事件
 * @param checkval
 * @param text
 */
function userCheck(checkval, text) {
    var value = checkval.value;
    if (checkval.checked == true) {
        if ($("#user_id_" + value).length <= 0) {
            $("#checked_user").append(
                "<li id='user_id_" + value + "'><input type='hidden' name='checked_user_list' value='" + value + "'><label>" + text + "</label></li>"
            );
        }
    } else {
        $("#user_id_" + value).remove();
    }
}
/**
 * 浮层用户列表提交事件
 */
$(".button-user_list").click(function () {
    var btn = $(this);
    var user_list = document.getElementsByName('checked_user_list');
    var fans_id_list = "";
    $.each(user_list, function (key) {
        fans_id_list += user_list[key].value + ",";
    });
    var content = $(".message-content_more").val();
    if (fans_id_list == "") {
        $("#addMessageMore").find(".alert-error").find("span").html("请选中收件人");
        $("#addMessageMore").find(".alert-error").show();
        return false;
    }
    if (content == "") {
        $("#addMessageMore").find(".alert-error").find("span").html("内容不可为空");
        $("#addMessageMore").find(".alert-error").show();
        return false;
    }
    var message = {
        content: content,
        send_fans_id: 0,
        fans_id_list: fans_id_list
    };
    $.ajax({
        url: "/message/ajax/?act=addMessageMore",
        type: 'post',
        dataType: 'json',
        data: message,
        beforeSend: function () {
            btn.button('loading');
        },
        success: function (json) {
            if (json.status = 'success') {
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

/**
 * 浮层提交按钮点击事件
 */
$(".button-confirm").click(function () {
    var btn = $(this);
    var message = {
        send_fans_id: 0,
        content: $(".message-content").val()
    };
    var act = "addMessageAtAll";
    $.ajax({
        url: "/message/ajax/?act=" + act,
        type: 'get',
        dataType: 'json',
        data: message,
        beforeSend: function () {
            btn.button('loading');
        },
        success: function (json) {
            if (json.status == 'success') {
                location.reload(true);
                return true;
            } else {
                $("#addMessage").find(".alert-error").find("span").html(json.message);
                $("#addMessage").find(".alert-error").show();
                btn.button('reset');
                return false;
            }
        }
    });
});

function clearForm() {
    $(".message-content").val('');
}