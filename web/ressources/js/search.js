$(function() {


	// Ce script permet de n'afficher que les elements dont le nom est mentionné dans la barre de recherche

	// On créée un array items qui contient tout les elements
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
			$('.in-list').hide();
			resultats.forEach(function(resultats) {
				$('.in-list:contains("' + resultats.name + '")').show();
			});  
		}

		else
		{
			$('.in-list').show();
		}	
	});
});