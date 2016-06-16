/**
 * 编辑管理员信息
 */
$(".button-edit").click(function() {
    clearForm();
    $(".anchor-name").val($(this).attr("data-anchor_name"));
    $(".anchor-thumb").val($(this).attr("data-thumb"));
    $(".anchor-backimage").val($(this).attr("data-backimage"));
    $(".anchor-qrcode").val($(this).attr("data-qrcode"));
    $(".anchor-platform").val($(this).attr("data-platform"));
    $(".anchor-broadcast").val($(this).attr("data-broadcast"));
    $(".anchor-description").val($(this).attr("data-description"));
    $("#anchor_id").val($(this).attr("data-anchor_id"));
    $("#editModal").find("h3").html('修改主播信息');
    $("#editModal").modal('show');
});
/**
 * 浮层提交按钮点击事件
 */
$(".button-confirm").click(function() {
    var btn = $(this);
    var anchor = {
        anchor_id : $("#anchor_id").val(),
        anchor_name : $(".anchor-name").val(),
        thumb : $(".anchor-thumb").val(),
        backimage : $(".anchor-backimage").val(),
        qrcode : $(".anchor-qrcode").val(),
        platform : $(".anchor-platform").val(),
        broadcast : $(".anchor-broadcast").val(),
        description : $(".anchor-description").val()
    }

    if(anchor.anchor_name == "") {
        $("#editModal").find(".alert-error").find("span").html("主播名不可为空");
        $("#editModal").find(".alert-error").show();
        return false;
    }
    $.ajax({
        url: "/anchor/ajax/?act=editAnchor",
        type: 'get',
        dataType: 'json',
        data: anchor,
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
        $(".anchor-name").val('');
        $(".anchor-thumb").val('');
        $(".anchor-backimage").val('');
        $(".anchor-qrcode").val('');
        $(".anchor-platform").val('');
        $(".anchor-broadcast").val('');
        $(".anchor-description").val('');
}