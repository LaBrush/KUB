$(function() {

	// Cette fonction permet l'ouverture de la boite d'options au clic sur le bouton .bouton-login

	$('.button-options').click( function() {

		if ($('#options-box').hasClass('options-box-open'))
		{
			$('#options-box')
			.removeClass('options-box-open')
			.addClass('options-box-closed');
		}
		else
		{
			$('#options-box')
			.removeClass('options-box-closed')
			.addClass('options-box-open');
		}
	});
});