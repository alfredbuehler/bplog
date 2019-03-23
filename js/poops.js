$(function () {
	$('a.log-edit').click(function(e) {

		var id = $(e.target).data('id');
		$('#upd_id').val(id);
		$('#upd_idd').val(id);

		var td = $(e.target).closest('td').next();

		$('#upd_date').val(td.text());
		td = $(td).next();
		$('#upd_systole').val(td.text());
		td = $(td).next();
		$('#upd_diastole').val(td.text());
		td = $(td).next();
		$('#upd_pulse').val(td.text());

		OC.Apps.showAppSidebar(this.$el);
		e.preventDefault();
	});

	$('a.close').click(function(e) {
		OC.Apps.hideAppSidebar(this.$el);
		e.preventDefault();
	});

	function isValidDate(d) {
	  return d instanceof Date && !isNaN(d);
	}

	$('form#upd').submit(function(e){

		e.preventDefault();

		var ts = new Date($('#upd_date').val());

		if (isValidDate(ts)) {
			$('#upd_date').removeClass("invalid");
		} else {
			$('#upd_date').addClass("invalid");
			OC.Notification.showTemporary(t('bplog', 'Invalid date'));
			return;
		}

		var url = OC.generateUrl('/apps/bplog/bplog/update')
			+ '?id=' + $('#upd_id').val()
			+ '&created=' + ts.getTime() / 1000
			+ '&systole=' + $('#upd_systole').val()
			+ '&diastole=' + $('#upd_diastole').val()
			+ '&pulse=' + $('#upd_pulse').val();

		$.post(url).success(function (response) {
			if(response.success) {
				OC.Notification.showTemporary(t('bplog', 'Record updated'));
				$('a.close').click();
			} else {
				OC.Notification.showTemporary(t('bplog', 'Record update failed.'));
			}

			$('form#upd').trigger('reset');
			refreshPage();
		});
	});
});


// function settings(obj) {
//     obj.change(function(e) {
//         var url = OC.generateUrl('/apps/bplog/config?key='
//             + obj.attr('id') + '&value=')
// 			+ (e.target.checked ? '1' : '0');
//         $.post(url).success(function (response) {
//             refreshPage();
// 		});
//     });
// }

//
// $('form#upd').submit(function(e){
//
// 	e.preventDefault();
//
// 	var ts = new Date($('input#upd_date').val());
//
// 	if (isValidDate(ts)) {
// 		$('input#upd_date').removeClass("invalid");
// 	} else {
// 		$('input#upd_date').addClass("invalid");
// 		OC.Notification.showTemporary(t('bplog', 'Invalid date'));
// 		return;
// 	}
//
// 	var url = OC.generateUrl('/apps/bplog/bplog/update')
// 		+ '?id=' + $('input#upd_id').val()
// 		+ '&created=' + ts.getTime() / 1000
// 		+ '&systole=' + $('input#upd_sys').val()
// 		+ '&diastole=' + $('input#upd_dia').val()
// 		+ '&pulse=' + $('input#upd_pul').val();
//
// 	$.post(url).success(function (response) {
// 		if(response.success) {
// 			OC.Notification.showTemporary(t('bplog', 'Record updated'));
// 			$('a.close').click();
// 		} else {
// 			OC.Notification.showTemporary(t('bplog', 'Record update failed.'));
// 		}
//
// 		$('form#upd').trigger('reset');
// 		refreshPage();
// 	});
// });



// ['name' => 'notes#create', 'url' => '/notes', 'verb' => 'POST'],
// ['name' => 'notes#update', 'url' => '/notes/{id}', 'verb' => 'PUT'],

// create(content);
// update(id, content);
// $.ajax({
// 	url: '/echo/html/',
// 	type: 'PUT',
// 	data: "name=John&location=Boston",
// 	success: function(data) {
// 		// alert('Load was performed.');
// 	}
// });
