$(function() {

	// Fonctions de tri

	var toHide = new Array;

	$('.options-tri>li').click( function() {

		$(this).toggleClass('unchecked');
		$(this).toggleClass('checked');


		var option = $(this).attr('id');


		if ($(this).hasClass('unchecked'))
		{
			toHide.push(option);

			$('.ressource').show();
		}
		else
		{
			for (var i = toHide.length - 1; i >= 0; i--) {		
				if (toHide[i] == option)
				{
					delete toHide[i];
				}
			}

			$('.' + option).show();
		}

		for (var i = toHide.length - 1; i >= 0; i--) {
			
			for (var j = $('.ressource').length - 1; j >= 0; j--) {
				if ($('.ressource').eq(j).hasClass(toHide[i]))
				{
					$('.ressource').eq(j).hide();
				}
			}
		}
	})

	$('#matiere')
	.select2({
	    placeholder: "Choisir une matière",
	    allowClear: true
	})
	.on("select2-selecting", function(e) {

		if ($(this).val() == null)
		{
			$('.ressource').addClass('ressource-hidden').removeClass('ressource');
		}

	 	$('.' + e.val).addClass('ressource').removeClass('ressource-hidden').removeAttr('style');

	 	for (var i = toHide.length - 1; i >= 0; i--) {
			
			for (var j = $('.ressource').length - 1; j >= 0; j--) {
				if ($('.ressource').eq(j).hasClass(toHide[i]))
				{
					$('.ressource').eq(j).hide();
				}
			}
		}
	})
	.on("select2-removing", function(e) {

		if ($(this).val() == null)
		{
			$('.ressource-hidden').addClass('ressource').removeClass('ressource-hidden');
		} 
		else
		{
			$('.' + e.val).addClass('ressource-hidden').removeClass('ressource');
		}

		for (var i = toHide.length - 1; i >= 0; i--) {
			
			for (var j = $('.ressource').length - 1; j >= 0; j--) {
				if ($('.ressource').eq(j).hasClass(toHide[i]))
				{
					$('.ressource').eq(j).hide();
				}
			}
		}
	});
});