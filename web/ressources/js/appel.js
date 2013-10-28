$(function() {

	// Cette fonction permet de changer la couleur d'un eleve au clic

	$('.person').click( function() {

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
