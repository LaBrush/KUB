$(function() {

	// Cette ligne retire l'attribut style du body ajouté par jquery
	
	var body = $("body");
	var nav = $('nav');
	var chevron = $('#chevron');

	body.removeAttr('style');

	// Cette fonction permet l'ouverture du menu au clic sur le bouton #bouton-menu

	$('#button-menu').click( function() {

		if(nav.hasClass('nav-open'))
		{
			chevron
			.removeClass('icon-chevron-sign-up')
			.addClass('icon-chevron-sign-down');

			nav
			.removeClass('nav-open')
			.addClass('unscrollable');
			
			body.removeClass('unscrollable');
			;
		}
		else
		{
			chevron
			.removeClass('icon-chevron-sign-down')
			.addClass('icon-chevron-sign-up');

			nav
			.addClass('nav-open')
			.removeClass('unscrollable');

			body.addClass('unscrollable')
		};
	});



	// Cette fonction bloque la section lors du scroll du menu 
	
	nav.mouseenter( function() {
			$(this).removeClass('unscrollable');
			body.addClass('unscrollable');
		})
		.mouseleave( function() {
			$(this).addClass('unscrollable');
			body.removeClass('unscrollable');
		})
		.addClass('unscrollable');

});
