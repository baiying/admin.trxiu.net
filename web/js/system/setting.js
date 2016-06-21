var Setting = function() {
	var handleWysihtml5 = function () {
	    if (!jQuery().wysihtml5) {
	        return;
	    }

	    if ($('.wysihtml5').size() > 0) {
	        $('.wysihtml5').wysihtml5({
	            "stylesheets": ["assets/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
	        });
	    }
	}

	var resetWysihtml5 = function () {
	    if (!jQuery().wysihtml5) {
	        return;
	    }

	    if ($('.wysihtml5').size() > 0) {
	        $('.wysihtml5').wysihtml5({
	            "stylesheets": ["assets/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
	        });
	    }
	}
	return {
		init: function() {
			handleWysihtml5();
			
			App.addResponsiveHandler(function(){
                resetWysihtml5();
            })
		}
	};
}();

$(".button-edit-vote").click(function() {
	$("#voteModal").modal('show');
});
$(".button-confirm-vote").click(function() {
	var ruleVote = $(".rule-vote").val();
	$.ajax({
		url: "/system/ajax/?act=editSetting",
		type: 'post',
		dataType: 'json',
		data: {rule_vote: ruleVote},
		success: function(json) {
			if(json.status == 'success') {
				location.reload(true);
			} else {
				alert(json.message);
				return false;
			}
		}
	});
});

$(".button-edit-red").click(function() {
	$("#redModal").modal('show');
});
$(".button-confirm-red").click(function() {
	var ruleRed = $(".rule-red").val();
	$.ajax({
		url: "/system/ajax/?act=editSetting",
		type: 'post',
		dataType: 'json',
		data: {rule_red: ruleRed},
		success: function(json) {
			if(json.status == 'success') {
				location.reload(true);
			} else {
				alert(json.message);
				return false;
			}
		}
	});
});

$(".button-edit-fee").click(function() {
	$("#feeModal").modal('show');
});
$(".button-confirm-fee").click(function() {
	var fee = $(".fee").val();
	$.ajax({
		url: "/system/ajax/?act=editSetting",
		type: 'post',
		dataType: 'json',
		data: {fee: fee},
		success: function(json) {
			if(json.status == 'success') {
				location.reload(true);
			} else {
				alert(json.message + ": " + json.data);
				return false;
			}
		}
	});
});


