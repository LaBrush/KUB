$(function() {

	// Cette ligne retire l'attribut style du body ajouté par jquery
	
	var body = $("body");
	var nav = $('nav');
	var chevronHaut = $('#chevron-haut');
	var chevronBas = $('#chevron-bas');

	body.removeAttr('style');
	nav.css('overflow', 'hidden');

	// Cette fonction permet l'ouverture du menu au clic sur le bouton #bouton-menu

	$('#button-menu').click( function() {

		if(nav.hasClass('nav-open'))
		{
			chevronHaut.hide();
			chevronBas.show();

			nav
			.removeClass('nav-open')
			.css('overflow', 'hidden');
			
			body.removeAttr('style');
		}
		else
		{
			chevronHaut.show();
			chevronBas.hide();

			nav
			.addClass('nav-open')
			.removeAttr('style');

			body.css('overflow', 'hidden');
		};
	});



	// Cette fonction bloque la section lors du scroll du menu 
	
	nav.mouseenter( function() {
			$(this).removeAttr('style');
			body.css('overflow', 'hidden');
		})
		.mouseleave( function() {
			$(this).css('overflow', 'hidden');
			body.removeAttr('style');
		})
		.css('overflow', 'hidden');

});
