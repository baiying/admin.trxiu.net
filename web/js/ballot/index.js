/**
 * 账号管理页面JS脚本
 */
// 初始化页面中的datetimepicker组件
var handleDatetimePicker = function () {        
	$(".form_datetime").datetimepicker({
		format: "yyyy-mm-dd hh:ii",
		autoClose: true,
		pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left")
	});
}
handleDatetimePicker();

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
 * 添加活动
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
    $(".ballot-begin_time").val($(this).attr("data-begin_time"));
    $(".ballot-end_time").val($(this).attr("data-end_time"));
    $(".ballot-status").val($(this).attr("data-status"));
    $("#ballot_id").val($(this).attr("data-ballot_id"));
    $("#editModal").find("h3").html('编辑活动信息');
    $("#editModal").modal('show');
});
/**
 * 浮层提交按钮点击事件
 */
$(".button-confirm").click(function() {
    var btn = $(this);
    var ballot = {
        ballot_id : $("#ballot_id").val(),
        ballot_name : $(".ballot-ballot_name").val(),
        description : $(".ballot-description").val(),
        begin_time : $(".ballot-begin_time").val(),
        end_time : $(".ballot-end_time").val(),
        status : $(".ballot-status").val()
    };
    var act = ballot.ballot_id > 0 ? 'editBallot' : 'createBallot';

    if(ballot.ballot_name == "") {
        $("#editModal").find(".alert-error").find("span").html("活动名不能为空");
        $("#editModal").find(".alert-error").show();
        return false;
    }
    if(ballot.description == "") {
        $("#editModal").find(".alert-error").find("span").html("描述不可为空");
        $("#editModal").find(".alert-error").show();
        return false;
    }
    $.ajax({
        url: "/ballot/ajax/?act="+act,
        type: 'get',
        dataType: 'json',
        data: ballot,
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
    $(".ballot-ballot_name").val('');
    $(".ballot-description").val('');
    $(".ballot-begin_time").val('');
    $(".ballot-end_time").val('');
    $(".ballot-status").val('1');
    $("#ballot_id").val('0');
}