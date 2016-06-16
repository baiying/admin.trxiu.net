/**
 * 账号管理页面JS脚本
 */

$(".button-status").click(function() {
    var status = $(this).attr('data-status');
    var ballot_id = $(this).attr('data-ballot_id');
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
        url: "/ballot/ajax/?act=changeStatus",
        type: 'get',
        dataType: 'json',
        data: {ballot_id:ballot_id, status:status},
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
 * 会员晋升管理员
 */
$(".addAnchor").click(function() {
    var anchor_id = $(this).attr("data-anchor_id");
    if(anchor_id>0){
        alert('该会员已经是主播，请编辑相关主播信息，主播ID为'+anchor_id);
        return false;
    }
    clearForm();
    $(".anchor-fans_id").val($(this).attr("data-fans_id"));
    $(".anchor-wx_name").val($(this).attr("data-wx_name"));
    $("#addAnchor").find("h3").html('编辑活动信息');
    $("#addAnchor").modal('show');
});
/**
 * 浮层提交按钮点击事件
 */
$(".button-confirm").click(function() {
    var btn = $(this);
    var anchor = {
        fans_id : $(".anchor-fans_id").val(),
        backimage : $(".anchor-backimage") .val(),
        qrcode : $(".anchor-qrcode").val(),
        platform : $(".anchor-platform").val(),
        broadcast : $(".anchor-broadcast").val(),
        description : $(".anchor-description").val()
    };
    $.ajax({
        url: "/fans/ajax/?act=addAnchor",
        type: 'get',
        dataType: 'json',
        data: anchor,
        beforeSend: function() {
            btn.button('loading');
        },
        success: function(json) {
            if(json.status == 'success') {
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
    $(".anchor-fans_id").val('');
    $(".anchor-wx_name").val('');
    $(".anchor-backimage").val('');
    $(".anchor-qrcode").val('');
    $(".anchor-platform").val('');
    $(".anchor-broadcast").val('');
    $(".anchor-description").val('');
}