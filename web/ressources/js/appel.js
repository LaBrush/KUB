$(function() {

	$('.input-appel').hide();

	// Cette fonction permet de changer la couleur et la presence d'un eleve au clic

	var inputAppel = $('.input-appel');

	$('.in-list')
	.click( function() {

		if ($(this).hasClass('away'))
		{
			$(this).addClass('retard')
			.removeClass('away');

			$(this)
			.find(inputAppel)
			.val("2");
		}
		else if ($(this).hasClass('retard'))
		{
			$(this).removeClass('retard');

			$(this)
			.find(inputAppel)
			.val("0");
		}
		else
		{
			$(this).addClass('away');

			$(this)
			.find(inputAppel)
			.val("1");
		}
	});
});
