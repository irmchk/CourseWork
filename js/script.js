$(document).ready(function(){
	// $active = false;
	var active_table = false;

	$('.alert-info').hide();

	$(document).on('click', '.cbox', function() {
		
		if($(".cbox").is(':checked'))
			$('#btn-delete').removeClass('disabled');
		else
			$('#btn-delete').addClass('disabled');
	});


	if($('ul.nav-tabs li').not(".active"))
	{
		$first = $('ul.nav-tabs li').first();
		$first.addClass("active");
		$.post('get_table.php', 'tname=' + $first.text(), function (response) {
    		$('.dbtable').html(response);
		});
		// $active = $(this).text();
		active_table = $.param($('li.active').map(function() {
		    return {
		        name: $(this).attr('name'),
		        value: $(this).text().trim()
		    };
		}));
	}

	$('ul.nav-tabs').children().click(function(e) {
		if($(this).is('.active'))
			return e;
		$('ul.nav-tabs li').removeClass("active");
		$(this).addClass("active");
		$.post('get_table.php', 'tname=' + $(this).text(), function (response) {
    		$('.dbtable').html(response);
		});
		if($('#btn-delete').not('.disabled'))
			$('#btn-delete').addClass('disabled');
		if($('.alert-info').is(':visible'))
			$('.alert-info').hide();
		$('.alert-text').html('');
		// $active = $(this).text();
		active_table = $.param($('li.active').map(function() {
		    return {
		        name: $(this).attr('name'),
		        value: $(this).text().trim()
		    };
		}));
	});

	$('#btn-delete').click(function() {
		var result = confirm("Ви точно хочете видалити відмічену інформацію?");
		if(result)
		{
			var tablename = $.param($('.dbtable input.cbox:checked').map(function() {
			    return {
			        name: $(this).attr('name'),
			        value: $(this).val().trim()
			    };
			}));
			var info = tablename + '&' + active_table;
			$.post('row_delete.php', info, function (response) {
				$.post('get_table.php', 'tname=' + $first.text(), function (data) {
    				$('.dbtable').html(data);
				});
	        	$('.alert-text').html(response);
	        	$('.alert-info').show();

	        });
	        if($('#btn-delete').not('.disabled'))
				$('#btn-delete').addClass('disabled');
		}
	});

	$(document).on('click', 'button.close', function() {
		$('.alert-info').hide();
	});

	$(document).on('click', 'button#btn-submit', function() {

		// var pkey = $.param($('th.pkey').map(function() {
		//     return {
		//         name: 'pkey',
		//         value: $(this).text().trim()
		//     };
		// }));
		// var fkey = $.param($('th.fkey').map(function() {
		//     return {
		//         name: 'fkey[]',
		//         value: $(this).text().trim()
		//     };
		// }));
		// var fkey_col = $.param($('th.fkey').map(function() {
		//     return {
		//         name: 'fkeycol[]',
		//         value: $(this).attr('data-col')
		//     };
		// }));
		// var fkey_table = $.param($('th.fkey').map(function() {
		//     return {
		//         name: 'fkeytable[]',
		//         value: $(this).attr('data-table')
		//     };
		// }));

		var colnames = $.param($('th.fname').map(function() {
		    return {
		        name: $(this).attr('name'),
		        value: $(this).text().trim()
		    };
		}));
		var addvals = $.param($('.addfield input, .addfield select').map(function() {
		    return {
		        name: $(this).attr('name'),
		        value: $(this).val().trim()
		    };
		}));
		
		var info = active_table + '&' + colnames + '&' + addvals;
		
		$.post('row_add.php', info, function (response) {
			$.post('get_table.php', 'tname=' + $first.text(), function (data) {
				$('.dbtable').html(data);
			});
        	$('.alert-text').html(response);
        	$('.alert-info').show();
        });
		$('#insertRow').modal('hide');
	});
});