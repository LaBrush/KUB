$(function() {

	// Cette fonction retire le second titre

	$('.section-title:contains("Mes notes")').unwrap().html('');
	$('.notes-by-matieres').unwrap().html('');
	$('.wrap-details').unwrap();


});