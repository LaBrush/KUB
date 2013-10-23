$(function() {

	var loginBox = $('#login-box');

	// Cette fonction permet l'ouverture de la boite de login au clic sur le bouton .bouton-login

	$('.button-login').click( function() {

		if (loginBox.hasClass('login-box-open'))
		{
			loginBox
			.removeClass('login-box-open')
			.addClass('login-box-closed');
		}
		else
		{
			loginBox
			.removeClass('login-box-closed')
			.addClass('login-box-open');
		}
	});
});