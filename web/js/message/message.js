
/**
 * 添加活动
 */
$(".button-add").click(function() {
    clearForm();
    $("#addMessage").find("h3").html('添加活动');
    $("#addMessage").modal('show');
});
/**
 * 浮层提交按钮点击事件
 */
$(".button-confirm").click(function() {
    var btn = $(this);
    var message = {
        send_fans_id : 0,
        content : $(".message-content").val()
    };
    var act = "addMessageAtAll";
    $.ajax({
        url: "/message/ajax/?act="+act,
        type: 'get',
        dataType: 'json',
        data: message,
        beforeSend: function() {
            btn.button('loading');
        },
        success: function(json) {
            if(json.status == 'success') {
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