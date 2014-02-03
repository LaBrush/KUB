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
});
