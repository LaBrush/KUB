$(function() {

	// Cette ligne retire l'attribut style du body ajouté par jquery

	$('body').removeAttr('style');


	// Cette fonction permet l'ouverture du menu au clic sur le bouton #bouton-menu

	$('#button-menu').click( function() {

		if($('#chevron').hasClass('icon-chevron-sign-up') == true)
		{
			$('#chevron')
			.removeClass('icon-chevron-sign-up')
			.addClass('icon-chevron-sign-down');
		}
		else
		{
			$('#chevron')
			.removeClass('icon-chevron-sign-down')
			.addClass('icon-chevron-sign-up');
		};

		if ($('nav').hasClass('nav-open'))
		{
			$('nav').removeClass('nav-open');
		}
		else
		{
			$('nav').addClass('nav-open');
		}
	});


	// On affiche le sous-menu dans lequel on se trouve

	var actualPage = '.submenu:contains("' + $('.section-title').text() + '")';

	$(actualPage)
	.addClass('submenu-actual')
	.removeClass('submenu');



	// Cette fonction bloque la section lors du scroll du menu 

	$('nav').mouseenter( function() {

		var actualScroll = window.scrollY;
		var top = '-' + actualScroll + 'px';

		$('section').css('position', 'fixed');
		$('section').css('top', top);

		$('nav').mouseleave( function() {

			$('section').removeAttr('style');
			window.scrollTo(0, actualScroll);
		});
	});

});
