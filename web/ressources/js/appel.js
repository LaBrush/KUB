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


	// Cette fonction permet de n'afficher que les élèves dont le nom est mentionné dans la barre de recherche
	$('#search').keyup(function() {

		var personContains = '.person-hidden:contains("' + $(this).val() + '")';

		$('.person').addClass('person-hidden').removeClass('person');

		$(personContains).removeClass('person-hidden').addClass('person');

	});


});
