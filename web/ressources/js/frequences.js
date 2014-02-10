$(function() {	

	$('input:checkbox').hide();

	$('td').click(function() {
		var $this = $(this);
		$this.toggleClass('checked').find('input:checkbox').prop('checked', $this.hasClass('checked'));
	});

	$('input:checkbox').each(function(){
	
		if($(this).prop('checked'))
		{
			$(this).parent().addClass('checked');
		}

	});

	$('.semaine1').appendTo($('.line1'));

	$('.semaine2').appendTo($('.line2'));

	$('.semaine3').appendTo($('.line3'));

	$('.semaine4').appendTo($('.line4'));

	$('.semaine5').appendTo($('.line5'));

	$('.semaine6').appendTo($('.line6'));

	$('.semaine7').appendTo($('.line7'));

	$('.semaine8').appendTo($('.line8'));
});
