$(function() {

	// Cette fonction permet de changer la couleur d'un eleve au clic

	$('.in-list').click( function() {

		if (!$(this).hasClass('away'))
		{
			$(this).addClass('away');
		}
		else
		{
			$(this).removeClass('away');
		}
	});
});
