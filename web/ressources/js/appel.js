$(function() {	

	// Cette fonction permet de changer la couleur et la presence d'un eleve au clic

	alert("J'ai fait quelques changments. A vérifier donc")
	var inputAppel = $('.input-appel');
	
	inputAppel.hide();
	
	// for (var i = inputAppel.length - 1; i >= 0; i--) {

	// 	var this = $('.input-appel');

	// 	// console.log(this);
	// 	// if (this.val() == '0')
	// 	// {
			
	// 	// }
	// 	// else
	// 	// {

	// 	// }
	// };

	function check(eleve)
	{
		state_class = [
			'retard',
			'absence',
			'present'
		]

		eleve.class( eleve.find(inputAppel).value());
	}

	$('.in-list')
	.click( function() {

		if ($(this).hasClass('away'))
		{
			$(this).addClass('retard')
			.removeClass('away');

			check($(this));			
		}
		else if ($(this).hasClass('retard'))
		{
			$(this).removeClass('retard');

			$(this)
			.find(inputAppel)
			.val("0");
			check($(this));			
		}
		else
		{
			$(this).addClass('away');

			$(this)
			.find(inputAppel)
			.val("1");
			check($(this));
		}
	});
});
