$(function() {	

	// Cette fonction permet de changer la couleur et la presence d'un eleve au clic
	var inputAppel = $('.input-appel').hide();

	state_class = [
		'present',
		'away',
		'retard'
	]

	$('.in-list')
	.click( function() {

		var option = $(this).find(inputAppel);

		$(this).removeClass(state_class[ option.val() ] );
		
		option.val( (option.val()+1) % 3 );
		
		$(this).addClass(state_class[option.val()] );
	
	})
	.each(function(){
		
		$(this).addClass(state_class[$(this).find(inputAppel).val()] );

	});
});
