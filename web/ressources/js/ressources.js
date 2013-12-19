$(function() {

	// Fonctions de l'appercu

	$('.ressource-selectionnee').hide();

	$('.in-list').click( function() {
		var index = $('.in-list').index(this);

		$('.preview').attr("src", "about:blank");

		$('.ressource-selectionnee').hide();

		$('html, body').animate({scrollTop:0}, 'slow');

		$('.ressource-selectionnee').eq(index).show();

		$('.url').hide();

		$('.preview').attr("src", $('.url').eq(index).text());
	})

	// Fonctions de tri

	var toShow = new Array;

	$('.niveau>li').click( function() {

		$(this).toggleClass('unchecked');
		$(this).toggleClass('checked');


		var niveau = $(this).attr('id');

		if (!$(this).hasClass('unchecked'))
		{
			toShow.push(niveau);
			$('.' + niveau).show();
		}
		else
		{
			$('.' + niveau).hide();

			for (var i = toShow.length - 1; i >= 0; i--) {
				if (toShow[i] == niveau)
				{
					delete toShow[i];
				}

				else if ($('.' + niveau).hasClass(toShow[i]))
				{
					$('.' + niveau).show();
				}
			}
		}
	})

	$('.type>li').click( function() {

		$(this).toggleClass('unchecked');
		$(this).toggleClass('checked');


		var type = $(this).attr('id');

		if (!$(this).hasClass('unchecked'))
		{
			toShow.push(type);
			$('.' + type).show();
		}
		else
		{
			$('.' + type).hide();
			
			for (var i = toShow.length - 1; i >= 0; i--) {
				if (toShow[i] == type)
				{
					delete toShow[i];
				}
				else if ($('.' + type).hasClass(toShow[i]))
				{
					$('.' + type).show();
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

		toShow.push(e.val);
	 	$('.' + e.val).show();
	})
	.on("select2-removing", function(e) {
	 	
	 	$('.' + e.val).hide();

	 	for (var i = toShow.length - 1; i >= 0; i--) {
			if (toShow[i] == e.val)
			{
				delete toShow[i];
			}
			else if ($('.' + e.val).hasClass(toShow[i]))
			{
				$('.' + type).show();
			}
		}
	});
});