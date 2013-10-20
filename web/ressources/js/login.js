$(function() {

	// Cette fonction permet l'ouverture de la boite de login au clic sur le bouton .bouton-login

	$('.button-login').click( function() {

		if ($('#login-box').hasClass('login-box-open'))
		{
			$('#login-box')
			.removeClass('login-box-open')
			.addClass('login-box-closed');
		}
		else
		{
			$('#login-box')
			.removeClass('login-box-closed')
			.addClass('login-box-open');
		}
	});
});