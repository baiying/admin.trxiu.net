
/**
 * 关联主播按钮
 */
$(".button-add").click(function() {
    $.ajax({
        url: "/ballot/ajax/?act=getAnchorList",
        type: 'get',
        dataType: 'json',
        data: {},
        success: function(json) {
            if(json.status = 'success') {
                var anchorList = json.data;
                $("#editModal").find("h3").html('添加活动');
                $("#editModal").modal('show');
                var obj = document.getElementById("anchorSelect");
                obj.options.length = 0;
                obj.add(new Option("--下拉选择主播--",0));

                $.each(anchorList, function(id,anchor){
                    obj.add(new Option("主播名："+anchor.anchor_name+"--("+anchor.platform+")",anchor.anchor_id));
                });
            } else {
                alert(json.message);
                return false;
            }
        }
    });
});
/**
 * 浮层提交按钮点击事件
 */
$(".button-confirm").click(function() {
    var btn = $(this);
    var anchor = {
        anchor_id : $("#anchorSelect").val(),
        ballot_id : $(this).attr('data-ballot_id')
    };
    if(anchor.anchor_id == "0") {
        $("#editModal").find(".alert-error").find("span").html("请选择主播");
        $("#editModal").find(".alert-error").show();
        return false;
    }
    $.ajax({
        url: "/ballot/ajax/?act=addAnchor",
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
