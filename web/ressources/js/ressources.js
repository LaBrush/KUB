$(function() {

	// Fonctions de tri

	var ressources = new Array;
	var toHide = new Array;

	$('.ressource').each(function(){

		ressources.push( 
			{
				$: $(this),
				name: true,
				matiere: true
			}
		)

	});

	$('.options-tri>li').click( function() {

		$(this).toggleClass('unchecked');
		$(this).toggleClass('checked');


		var option = $(this).attr('id');

		$('.ressource').show();


		if ($(this).hasClass('unchecked'))
		{
			toHide.push(option);
		}
		else
		{
			for (var i = toHide.length - 1; i >= 0; i--) {		
				if (toHide[i] == option)
				{
					delete toHide[i];
				}
			}
		}

		for (var i = toHide.length - 1; i >= 0; i--) {
			
			for (var j = $('.ressource').length - 1; j >= 0; j--) {
				if ($('.ressource').eq(j).hasClass(toHide[i]))
				{
					$('.ressource').eq(j).hide();
				}
			}
		}
	})

	$('#matiere')
	.change(function(e) {

		var required = $(this).val();

		if(required)
		{
			for (var i = 0; i < ressources.length; i++) {
				if(ressources[i].$.hasClass(required))
				{
					ressources[i].matiere = true ;
				}
				else
				{
					ressources[i].matiere = false ;
				}
			};
		}
		else
		{
			for (var i = 0; i < ressources.length; i++) {
				ressources[i].matiere = true ;
			};	
		}
		
		refreshHide(ressources);

	});

	function refreshHide(param)
	{
		for (var i = 0; i < param.length; i++) {
			param[i].$.show();

			for(arg in param[i]) {
				if(!param[i][arg]){ 
					param[i].$.hide(); 
					console.log("bip");
				}
			};
		};
	}
});