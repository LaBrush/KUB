$(function() {	

	// Cette fonction permet de changer la couleur et la presence d'un eleve au clic

	var inputAppel = $('.input-appel');
	
	inputAppel.hide();
	
	for (var i = inputAppel.length - 1; i >= 0; i--) {

		var this = $('.input-appel');

		console.log(this);
		// if (this.val() == '0')
		// {
			
		// }
		// else
		// {

		// }
	};

	$('.in-list')
	.click( function() {

		if ($(this).hasClass('away'))
		{
			$(this).addClass('retard')
			.removeClass('away');

			$(this)
			.find(inputAppel)
			.val("2");
		}
		else if ($(this).hasClass('retard'))
		{
			$(this).removeClass('retard');

			$(this)
			.find(inputAppel)
			.val("0");
		}
		else
		{
			$(this).addClass('away');

			$(this)
			.find(inputAppel)
			.val("1");
		}
	});
});
