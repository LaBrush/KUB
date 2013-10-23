$(function() {

	var optionBox = $('#options-box');

	// Cette fonction permet l'ouverture de la boite d'options au clic sur le bouton .bouton-login

	$('#button-options').click( function() {

		if (optionBox.hasClass('options-box-open'))
		{
			optionBox
			.removeClass('options-box-open')
			.addClass('options-box-closed');
		}
		else
		{
			optionBox
			.removeClass('options-box-closed')
			.addClass('options-box-open');
		}
	});
});