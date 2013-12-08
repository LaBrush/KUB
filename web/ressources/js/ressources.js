$(function() {

	var toShow = new Array;

	$('.options-tri').hide();

	$('.trier').click( function() {
		$('.trier').remove();
		$('.options-tri').show();
		$('.li-list').hide();
	})

	$('.niveau>li').click( function() {

		$(this).toggleClass('unchecked');

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