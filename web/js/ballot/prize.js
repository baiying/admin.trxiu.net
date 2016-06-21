/**
 * 清空弹出层表单方法
 */
function clearForm() {
	$(".data-level").val("");
	$(".data-title").val("");
	$(".data-sort").val("");
	$(".data-logo").val("");
	$(".review_logo").attr("src", "");
	$(".review_logo").hide();
	$(".data-image").val("");
	$(".review_image").attr("src", "");
	$(".review_image").hide();
	$("#prize_id").val("");
}
/**
 * 呼出添加奖项浮层
 */
$(".button-add").click(function() {
	clearForm();
	$("#editModal").find("h3").html("添加奖项设置");
	$("#editModal").modal('show');
});
/**
 * 浮层中确认按钮事件
 */
$(".button-confirm").click(function() {
	var ballotId = $("#ballot_id").val();
	var prizeId = $("#prize_id").val();
	var err = false;
	var data = {};
	var btn = $(this);
	$(".required").each(function() {
		if($(this).val() == "") {
			$(this).next("span").html("此项必须填写");
			err = true;
		} else {
			data[$(this).attr("data-args")] = $(this).val();
		}
	});
	if(err) return false;
	
	data['ballot_id'] = ballotId;
	if(prizeId != "") {
		data['prize_id'] = prizeId;
	}
	var ajaxUrl = prizeId == "" ? "/ballot/ajax/?act=createPrize" : "/ballot/ajax/?act=updatePrize";
	$.ajax({
		url: ajaxUrl,
		type: 'post',
		dataType: 'json',
		data: data,
		beforeSend: function() {
			btn.button('loading');
		},
		success: function(json) {
			btn.button('reset');
			if(json.status == 'success') {
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
 * 奖项编辑按钮点击事件
 */
$(".button-edit").click(function() {
	var prizeId = $(this).attr("data-prize-id");
	var level = $(this).attr("data-level");
	var title = $(this).attr("data-title");
	var sort = $(this).attr("data-sort");
	var logo = $(this).attr("data-logo");
	var image = $(this).attr("data-image");
	
	$("#editModal").find("h3").html("编辑奖项设置");
	$(".data-level").val(level);
	$(".data-title").val(title);
	$(".data-sort").val(sort);
	$(".data-logo").val(logo);
	$(".review_logo").attr("src", logo);
	$(".review_logo").show();
	$(".data-image").val(image);
	$(".review_image").attr("src", image);
	$(".review_image").show();
	$("#prize_id").val(prizeId);
	$("#editModal").modal('show');
	
});

$(".button-delete").click(function() {
	if(!confirm('确定要删除该奖品吗？')) return false;
	var prizeId = $(this).attr('data-prize-id');
	$.ajax({
		url: "/ballot/ajax/?act=deletePrize",
		type: 'post',
		dataType: 'json',
		data: {prize_id: prizeId},
		success: function(json) {
			if(json.status == 'success') {
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
 * 上传图片
 */
$(function() {
    var logo_uploader = Qiniu.uploader({
        runtimes: 'html5',
        browse_button: 'btn_logo',
        container: 'logo_container',
        drop_element: 'logo_container',
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
                $("#btn_logo").button("loading");
                $(".data-logo").val("");
            },
            // 上传结束后触发事件
            'FileUploaded': function(up, file, info) {
            	$("#btn_logo").button("reset");
            	var res = $.parseJSON(info);
            	var domain = up.getOption('domain');
                var imgurl = domain + encodeURI(res.key);
                $(".review_logo").attr("src", imgurl);
                $(".review_logo").show();
                $(".data-logo").val(imgurl);
            },
            // 异常事件
            'Error': function(up, err, errTip) {
            	$("#btn_logo").button("reset");
            }
        }
    });
    var QiniuImage = new QiniuJsSDK();
    var image_uploader = QiniuImage.uploader({
        runtimes: 'html5',
        browse_button: 'btn_image',
        container: 'image_container',
        drop_element: 'image_container',
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
                $("#btn_image").button("loading");
                $(".data-image").val("");
            },
            // 上传结束后触发事件
            'FileUploaded': function(up, file, info) {
            	$("#btn_image").button("reset");
            	var res = $.parseJSON(info);
            	var domain = up.getOption('domain');
                var imgurl = domain + encodeURI(res.key);
                $(".review_image").attr("src", imgurl);
                $(".data-image").val(imgurl);
                $(".review_image").show();
            },
            // 异常事件
            'Error': function(up, err, errTip) {
            	$("#btn_image").button("reset");
            }
        }
    });
    
});