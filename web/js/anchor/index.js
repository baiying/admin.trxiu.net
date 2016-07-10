/**
 * 编辑主播信息
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
    $(".thumb").attr("src", $(this).attr("data-thumb"));
    $(".thumb").show();
    $(".backimage").attr("src", $(this).attr("data-backimage"));
    $(".backimage").show();
    $(".qrcode").attr("src", $(this).attr("data-qrcode"));
    $(".qrcode").show();
});
/**
 * 撤销主播权限
 */
$(".delAnchor").click(function () {
    console.log($(this).attr('data-anchor_id'));
    var anchor_id = $(this).attr('data-anchor_id');
    if(!confirm("确定要撤销该主播资格？该操作会影响主播在活动中的得票数!")) {
        return false;
    }

    $.ajax({
        url: "/anchor/ajax/?act=delAnchor",
        type: 'post',
        dataType: 'json',
        data: {
            anchor_id:anchor_id
        },
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
 * 查找用户
 */
$(".button-search").click(function () {
    window.location.href="/anchor/index/?name="+$('#search_name').val();
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


/**
 * 上传图片
 */
$(function() {
    var backimage_uploader = Qiniu.uploader({
        runtimes: 'html5',
        browse_button: 'btn_backimage',
        container: 'container_backimage',
        drop_element: 'container_backimage',
        max_file_size: '2mb',
        flash_swf_url: 'bower_components/plupload/js/Moxie.swf',
        dragdrop: true,
        chunk_size: '4mb',
        multi_selection: true,
        uptoken_url: '/qiniu/ajax/?act=token',
        domain: 'http://o8syigvwe.bkt.clouddn.com/',
        get_new_uptoken: false,
        unique_names: true,
        auto_start: true,
        log_level: 5,
        init: {
            // 添加文件时的触发事件
            'FilesAdded': function(up, files) {
                $("#btn_backimage").button("loading");
                $(".anchor-backimage").val("");
            },
            // 上传结束后触发事件
            'FileUploaded': function(up, file, info) {
                $("#btn_backimage").button("reset");
                var res = $.parseJSON(info);
                var domain = up.getOption('domain');
                var imgurl = domain + encodeURI(res.key);
                $(".backimage").attr("src", imgurl);
                $(".backimage").show();
                $(".anchor-backimage").val(imgurl);
            },
            // 异常事件
            'Error': function(up, err, errTip) {
                $("#pickfiles").button("reset");
            }
        }
    });
    var thumb_uploader = Qiniu.uploader({
        runtimes: 'html5',
        browse_button: 'btn_thumb',
        container: 'container_thumb',
        drop_element: 'container_thumb',
        max_file_size: '2mb',
        flash_swf_url: 'bower_components/plupload/js/Moxie.swf',
        dragdrop: true,
        chunk_size: '4mb',
        multi_selection: true,
        uptoken_url: '/qiniu/ajax/?act=token',
        domain: 'http://o8syigvwe.bkt.clouddn.com/',
        get_new_uptoken: false,
        unique_names: true,
        auto_start: true,
        log_level: 5,
        init: {
            // 添加文件时的触发事件
            'FilesAdded': function(up, files) {
                $("#pickfiles").button("loading");
                $(".anchor-thumb").val("");
            },
            // 上传结束后触发事件
            'FileUploaded': function(up, file, info) {
                $("#btn_thumb").button("reset");
                var res = $.parseJSON(info);
                var domain = up.getOption('domain');
                var imgurl = domain + encodeURI(res.key);
                $(".thumb").attr("src", imgurl);
                $(".thumb").show();
                $(".anchor-thumb").val(imgurl);
            },
            // 异常事件
            'Error': function(up, err, errTip) {
                $("#pickfiles").button("reset");
            }
        }
    });
    var QiniuQr = new QiniuJsSDK();
    var qr_uploader = QiniuQr.uploader({
        runtimes: 'html5',
        browse_button: 'btn_qrcode',
        container: 'container_qrcode',
        drop_element: 'container_qrcode',
        max_file_size: '2mb',
        flash_swf_url: 'bower_components/plupload/js/Moxie.swf',
        dragdrop: true,
        chunk_size: '4mb',
        multi_selection: true,
        uptoken_url: '/qiniu/ajax/?act=token',
        domain: 'http://o8syigvwe.bkt.clouddn.com/',
        get_new_uptoken: false,
        unique_names: true,
        auto_start: true,
        log_level: 5,
        init: {
            // 添加文件时的触发事件
            'FilesAdded': function(up, files) {
                $("#btn_qrcode").button("loading");
                $(".anchor-qrcode").val("");
            },
            // 上传结束后触发事件
            'FileUploaded': function(up, file, info) {
                $("#btn_qrcode").button("reset");
                var res = $.parseJSON(info);
                var domain = up.getOption('domain');
                var imgurl = domain + encodeURI(res.key);
                $(".anchor-qrcode").val(imgurl);
                $(".qrcode").attr("src", imgurl);
                $(".qrcode").show();
            },
            // 异常事件
            'Error': function(up, err, errTip) {
                $("#btn_qrcode").button("reset");
            }
        }
    });

});