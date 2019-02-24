
(function ($, OC) {

    function refreshPage() {
        window.location = OC.generateUrl('/apps/bplog/');
    }

    function handleCheckbox(obj) {
        obj.change(function(e) {
            var url = OC.generateUrl('/apps/bplog/config?key='
                + obj.attr('id') + '&value=')
				+ (e.target.checked ? '1' : '0');
            $.post(url).success(function (response) {
                refreshPage();
			});
        });
    }

	$(document).ready(function() {
		$('#newontop').prop('checked', $('#newontopcurr').val() === '1');
		$('#stats').prop('checked', $('#statscurr').val() === '1');
	});

    $(function () {
        handleCheckbox($('#newontop'));
        handleCheckbox($('#stats'));
    });

	$(function () {
		$('button#log-export').click(function() {
			window.location = $(this).attr('href');
		});
	});

	$(function () {
		$('a.log-delete').click(function(e) {

			var id = $(e.target).data('id');
			var url = OC.generateUrl('/apps/bplog/bplog/' + id);
			var container = $(e.target).closest('tr');

			$.post(url).success(function (response) {
				if(response.success) {
					container.remove();
					OC.Notification.showTemporary(t('bplog', 'Record deleted'));
				} else {
					OC.Notification.showTemporary(t('bplog', 'Record not deleted. Please try again.'));
				}

                if ($('#stats').prop('checked')) {
                    refreshPage();
                }
			});
		});
	});

})(jQuery, OC);
