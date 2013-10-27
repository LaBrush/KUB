$(function() {

	// Cette ligne retire l'attribut style du body ajouté par jquery
	
	var body = $("body");
	var nav = $('nav');
	var chevronHaut = $('#chevron-haut');
	var chevronBas = $('#chevron-bas');

	body.removeAttr('style');

	// Cette fonction permet l'ouverture du menu au clic sur le bouton #bouton-menu

	$('#button-menu').click( function() {

		if(nav.hasClass('nav-open'))
		{
			chevronHaut.hide();
			chevronBas.show();

			nav
			.removeClass('nav-open')
			.addClass('unscrollable');
			
			body.removeClass('unscrollable');
		}
		else
		{
			chevronHaut.show();
			chevronBas.hide();

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
