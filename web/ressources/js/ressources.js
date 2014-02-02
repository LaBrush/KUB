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
			
			for (var j = ressources.length - 1; j >= 0; j--) {
				if (ressources[j].$.is('[data-bool~=' + toHide[i] + ']' ))
				{
					ressources[j]['categories'+i] = false ;
				}
				else
				{
					ressources[j]['categories'+i] = true ;
				}
			}
		}

		refreshHide(ressources);
	})

	$('#matiere')
	.change(function(e) {

		var required = $(this).val();

		if(required)
		{
			for (var i = 0; i < ressources.length; i++) {
				if(ressources[i].$.attr('data-matiere') == required)
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

	$('#auteur')
	.change(function(e) {

		var required = $(this).val();

		if(required)
		{
			for (var i = 0; i < ressources.length; i++) {
				if(ressources[i].$.attr('data-auteur') == required)
				{
					ressources[i].auteur = true ;
				}
				else
				{
					ressources[i].auteur = false ;
				}
			};
		}
		else
		{
			for (var i = 0; i < ressources.length; i++) {
				ressources[i].auteur = true ;
			};	
		}
		
		refreshHide(ressources);
	}).select2();

	/*--------------------------------*/
	// Fuzzy search

	var items = new Array();
	var i = 0;

	$('.in-list').each(function() {
		items.push({
			id: i,
			name: $(this).text()
		})

		i++;
	});


	// On applique la recherche sur items

	$('#search-in-list').keyup(function() {
		var search = $(this).val();

		if (search)
		{
			// Recherche en fuzzy
			var options = {keys: ['name']};
			var fuse = new Fuse(items, options);
			var resultats = fuse.search(search);

			// Override de la fonction "contains" pour permettre une recherche case-insensitive
		   	jQuery.extend(
				jQuery.expr[':'], { 
					Contains : "jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase())>=0" 
					}
			);

			// Affichage des resultats uniquement
			resultats.forEach(function(resultats) {
				for (var i = 0; i < ressources.length; i++) {
					ressources[i].$.is(':contains("' + resultats.name + '")') ? ressources[i].name = true : ressources[i].name = false 
				};
			});
		}

		else
		{
			for (var i = 0; i < ressources.length; i++) {
				ressources[i].name = true ; 
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
				}
			};
		};
	}
});


$(function(){

	$('.file').hide();
	$('input:file').removeAttr('required');

	$('input:radio').click(function() {
		if ($('input:radio')[0].checked)
		{
			$('.file').hide();
			$('input:file').removeAttr('required');
			$('.url').show();
			$('input:url').attr('required', 'required');
		}
		else
		{
			$('.file').show();
			$('input:file').attr('required', 'required');
			$('.url').hide();
			$('input:url').removeAttr('required');
		}
})

})
