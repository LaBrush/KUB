$(function() {

	// Fonctions de tri

	var toHide = new Array;

	$('.options-tri>li').click( function() {

		$(this).toggleClass('unchecked');
		$(this).toggleClass('checked');


		var option = $(this).attr('id');

		$('.ressource').show();


		if ($(this).hasClass('unchecked'))
		{
			toHide.push(option);
		}
		else
		{
			for (var i = toHide.length - 1; i >= 0; i--) {		
				if (toHide[i] == option)
				{
					delete toHide[i];
				}
			}
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
			$('.ressource').hide();
		}
		
		$('.' + e.val).show();

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
			$('.ressource').show();
		} 
		else
		{
			$('.' + e.val).hide();
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