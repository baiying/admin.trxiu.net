/**
 * 呼出发布动态浮层
 */
$(".button-add").click(function() {
	clearForm();
	$("#editModal").find("h3").html("发布主播动态");
	$("#editModal").modal('show');
});
/**
 * 发布动态
 */
$(".button-publish").click(function() {
	var btn = $(this);
	var content = $(".news-content").val();
	var newsId = $("#news_id").val();
	if(content.length == 0) {
		alert('请填写内容');
		return false;
	}
	var images = new Array();
	if($("#editModal").find(".blog-images").find("li").length > 0) {
		$("#editModal").find(".blog-images").find("li").each(function() {
			images.push($(this).find("img").attr("src"));
		});
	}
	var ajaxUrl = newsId == "" ? "/anchor/ajax/?act=publishNews" : "/anchor/ajax/?act=editNews";
	$.ajax({
		url: ajaxUrl,
		type: 'post',
		dataType: 'json',
		data: {content: content, images: images.join(","), anchor_id: $("#anchor_id").val(), news_id: newsId},
		beforeSend: function() {
			btn.button("loading");
		},
		success: function(json) {
			btn.button("reset");
			if(json.status == 'success') {
				alert('主播动态发布成功，本页面将刷新');
				location.reload(true);
			} else {
				alert(json.message);
				return false;
			}
		}
	});
});
/**
 * 修改动态
 */
$(".button-edit").click(function() {
	clearForm();
	var newsId = $(this).attr("data-news-id");
	var container = $("#news_"+newsId);
	var content = container.find(".content").html();
	if(container.find(".blog-images").find("li").length > 0) {
		container.find(".blog-images").find("li").each(function() {
			var src = $(this).find("img").attr("src");
			var image = '<li onclick="removeImage($(this))"><a href="javascript:;" target="_blank" title="点击删除图片"><img src="'+ src +'" alt="" /></a></li>';
			$("#editModal").find(".blog-images").append($(image));
		});
	}
	$("#editModal").find("h3").html("修改动态内容");
	$(".news-content").val(content);
	$("#news_id").val(newsId);
	$("#editModal").modal('show');
});
/**
 * 上传图片
 */
$(function() {
	var uploader = Qiniu.uploader({
        runtimes: 'html5',
        browse_button: 'button-upload',
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
        log_level: 1,
        init: {
            // 添加文件时的触发事件
            'FilesAdded': function(up, files) {
        		$("#button-upload").button("loading");
            },
            // 上传结束后触发事件
            'FileUploaded': function(up, file, info) {
                $("#button-upload").button("reset");
                var res = $.parseJSON(info);
                var domain = up.getOption('domain');
                var imgurl = domain + encodeURI(res.key);
                var image = '<li onclick="removeImage($(this))"><a href="javascript:;" target="_blank" title="点击删除图片"><img src="'+ imgurl +'" alt="" /></a></li>';
                $(image).appendTo($("#editModal").find(".blog-images"));
            },
            // 异常事件
            'Error': function(up, err, errTip) {
                $("#button-upload").button("reset");
            }
        }
    });
});
/**
 * 清空发布动态表单
 */
function clearForm() {
	var container = $("#editModal");
	container.find(".blog-images").html("");
	container.find(".news-content").val("");
	$("#news_id").val("");
}

function removeImage(imger) {
	if(confirm("确定要删除图片？")){
		imger.remove();
	}
}
/**
 * 计算已上传图片数量
 * @returns {Boolean}
 */
function checkImageCount() {
	var limit = 9;
	var exist = $("#editModal").find(".blog-images").find("li").length;
	if(exist >= limit) {
		return false;
	}
	return true;
}

/**
 * 删除主播动态
 */
$(".button-del").click(function() {
	if(confirm('确认删除该动态并删除相关评论么?'))
	{
		var btn = $(this);
		$.ajax({
			url: "/anchor/ajax/?act=delNews",
			type: 'post',
			dataType: 'json',
			data: {anchor_id: $(this).attr("data-anchor_id"), news_id: $(this).attr("data-news_id")},
			beforeSend: function() {
				btn.button("loading");
			},
			success: function(json) {
				btn.button("reset");
				if(json.status == 'success') {
					alert(json.message);
					location.reload(true);
				} else {
					alert(json.message);
					return false;
				}
			}
		});
		return true;
	}
});



/**
 * 删除主播动态
 */
$(".button-comment_del").click(function() {
	if(confirm('确认删除评论么?删除后无法恢复！'))
	{
		var btn = $(this);
		$.ajax({
			url: "/anchor/ajax/?act=denNewsComment",
			type: 'post',
			dataType: 'json',
			data: {comment_id: $(this).attr("data-comment_id"), fans_id: $(this).attr("data-fans_id")},
			beforeSend: function() {
				btn.button("loading");
			},
			success: function(json) {
				btn.button("reset");
				if(json.status == 'success') {
					alert(json.message);
					location.reload(true);
				} else {
					alert(json.message);
					return false;
				}
			}
		});
		return true;
	}
});