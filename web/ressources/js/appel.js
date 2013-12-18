$(function() {	

	// Cette fonction permet de changer la couleur et la presence d'un eleve au clic

	// alert("J'ai fait quelques changments. A vérifier donc")
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

	state_class = [
		'retard',
		'away',
		'present'
	]

	$('.in-list')
	.click( function() {

		var option = $(this).find(inputAppel);

		$(this).removeClass(state_class[ option.val() ] );
		option.val( (option.val()+1) % 3 );
		$(this).addClass(state_class[option.val()] );
	}).each(function(){
		$(this).addClass(state_class[$(this).find(inputAppel).val()] );
	});
});
