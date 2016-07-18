
/**
 * 查找用户
 */
$(".button-search").click(function () {
    window.location.href="/fans/index/?name="+$('#search_name').val();
});
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
    $("#addAnchor").find("h3").html('补充主播信息');
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
    $(".bgimg").attr("src", "");
    $(".bgimg").hide();
    $(".anchor-qrcode").val('');
    $(".qrcode").attr("src", "");
    $(".qrcode").hide();
    $(".anchor-platform").val('');
    $(".anchor-broadcast").val('');
    $(".anchor-description").val('');
}
/**
 * 上传图片
 */
$(function() {
    var bg_uploader = Qiniu.uploader({
        runtimes: 'html5',
        browse_button: 'pickfiles',
        container: 'container',
        drop_element: 'container',
        max_file_size: '2mb',
        flash_swf_url: '/media/Moxie.swf',
        dragdrop: true,
        chunk_size: '4mb',
        multi_selection: true,
        uptoken_url: '/qiniu/ajax/?act=token',
//        uptoken: $("#uptoken").val(),
        domain: 'http://o8syigvwe.bkt.clouddn.com/',
        get_new_uptoken: false,
        unique_names: true,
        auto_start: true,
        log_level: 5,
        init: {
        	// 添加文件时的触发事件
            'FilesAdded': function(up, files) {
                $("#pickfiles").button("loading");
                $(".anchor-backimage").val("");
            },
            // 上传结束后触发事件
            'FileUploaded': function(up, file, info) {
            	$("#pickfiles").button("reset");
            	var res = $.parseJSON(info);
            	var domain = up.getOption('domain');
                var imgurl = domain + encodeURI(res.key);
                $(".bgimg").attr("src", imgurl);
                $(".bgimg").show();
                $(".anchor-backimage").val(imgurl);
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
                $(".qrcode").attr("src", imgurl);
                $(".anchor-qrcode").val(imgurl);
                $(".qrcode").show();
            },
            // 异常事件
            'Error': function(up, err, errTip) {
            	$("#btn_qrcode").button("reset");
            }
        }
    });
    
});
