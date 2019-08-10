
(function ($, OC) {

    var refreshPage = function() {
        window.location = OC.generateUrl('/apps/bplog/');
    }

	var handleStatsView = function() {
		if ($('#stats').prop('checked')) {
			$('#stats-container').show();
		} else {
			$('#stats-container').hide();
		}
	}

	var isValidDate = function(ts) {
		return ts instanceof Date && !isNaN(ts);
	}

	var validateTimestamp = function(ts) {
		if (isValidDate(ts)) {
			$('#created').removeClass('invalid');
			return true;
		} else {
			$('#created').addClass('invalid');
			OC.Notification.showTemporary(t('bplog', 'Invalid date'));
			return false;
		}
	}

	var getTimeStamp = function() {
		var d = new Date();
		d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
		var str = d.toISOString();
		return str.slice(0, 10) + ' ' + str.slice(11, 19);
	}

	var modeAdd = function() {
		$('#id').val(0);
		$('#created').removeClass('invalid');
		$('#created').attr('disabled', true);
		$('#auto').attr('disabled', false);
		$('#auto').prop('checked', true);
		$('#exec').text('Add');
		$('#cancel').hide();
	}

	var modeEdit = function(id) {
		$('#id').val(id);
		$('#created').removeClass('invalid');
		$('#created').attr('disabled', false);
		$('#auto').attr('disabled', true);
		$('#auto').prop('checked', false);
		$('#exec').text('Update');
		$('#cancel').show();
	}

	var handleMark = function(id) {

		var mark = '#' + id;
		var idx = $('#inp-' + id).val();

		$(mark).removeClass('ht0 ht1 ht2 ht3');
		$(mark).addClass(`ht${idx}`);
	}

	$(function() {

		// Init

		$('#checkpoint').trigger('reset');
		modeAdd();

		$('#newontop').prop('checked', $('#newontopcurr').val() === '1');
		$('#stats').prop('checked', $('#statscurr').val() === '1');
 		handleStatsView();

		handleMark('q-avg');
		handleMark('q-min');
		handleMark('q-max');

		// Settings

		$('.settings-fieldset .setting').change(function(e) {
			var url = OC.generateUrl('/apps/bplog/config?key='
				+ $(this).attr('id') + '&value=')
				+ (e.target.checked ? '1' : '0');
			$.post(url).success(function (response) {
				refreshPage();
			});
		});

		$('#log-export').click(function() {
			window.location = $(this).attr('href');
		});

		// add/update

		$('#exec').click(function(e) {

			e.preventDefault();

			var url;
			var method;
			var id = $('#id').val();
			var ts;

			if (id !== '0'){
				// update
				url = OC.generateUrl('/apps/bplog/bplog/' + id);
				method = 'PUT';
				ts = new Date($('#created').val());
				if (!validateTimestamp(ts))	{
					return;
				}
			} else {
				// add
				url = OC.generateUrl('/apps/bplog/bplog');
				method = 'POST';
				if ($('#auto').prop('checked')) {
					ts = new Date();
				} else {
					ts = new Date($('#created').val());
					if (!validateTimestamp(ts)) {
						return;
					}
				}
			}

			var params =  'created=' + (ts.getTime() / 1000).toFixed(0)
						+ '&systole=' + $('#systole').val()
						+ '&diastole=' + $('#diastole').val()
						+ '&pulse=' + $('#pulse').val();

			$.ajax({
				url: url,
				type: method,
				data: params,
				success: function(data) {
					OC.Notification.showTemporary(t('bplog', 'Action succeeded'));
					refreshPage();
				},
				error:  function(data) {
					OC.Notification.showTemporary(t('bplog', 'Action failed'));
					refreshPage();
				},
			});
		});

		$('#cancel').click(function() {
			modeAdd();
			$(this).hide();
		});

		$('a.log-edit').click(function(e) {

			var target = $(e.target);
			var td = target.closest('td').next();

			modeEdit(target.closest('tr').data('id'));

			$('#created').val(td.text());
			td = $(td).next();
			$('#systole').val(td.text());
			td = $(td).next();
			$('#diastole').val(td.text());
			td = $(td).next();
			$('#pulse').val(td.text());

			$('#cancel').show();
		});

		// Delete

		$('a.log-delete').click(function(e) {
			var container = $(e.target).closest('tr');
			var id = container.data('id');
			var url = OC.generateUrl('/apps/bplog/bplog/' + id);
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

		$('#auto').change(function(e) {
			var checked;
			$('#created').removeClass('invalid');
			$('#created').attr('disabled', checked = e.target.checked);
			$('#created').val(checked ? '' : getTimeStamp());
		});

		$('#log-import').click(function(){
			$('#bp-import').click();
		});

		$('#bp-import').change(function(){

			var url = OC.generateUrl('/apps/bplog/import');
			var cbxClear = $('#bp-clear');

			url += '?clear=' + (cbxClear.prop('checked') ? 1 : 0);
 			cbxClear.prop('checked', false);

			$.ajax({
				url: url,
				type: 'post',
				data: new FormData($('form#upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					if (data.success) {
						OC.Notification.showTemporary(t('bplog', 'Import successful'));
						refreshPage();
					} else {
						OC.Notification.showTemporary(t('bplog', 'Import failed: ' + data.error));
					}
				},
				error:  function(data) {
					OC.Notification.showTemporary(t('bplog', 'Request failed'));
				},
			});
		});
	});

})(jQuery, OC);
