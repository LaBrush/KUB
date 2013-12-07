$(function() {

	$('.options-tri').hide();

	$('.trier').click( function() {
		$('.trier').remove();
		$('.options-tri').show();
		$('.li-list').hide();
	})

	$('.niveau>li').click( function() {
		$(this).toggleClass('unchecked');

		var niveau = $(this).attr('class');

		$('.niveau-' + niveau).toggle();
	})

	$('.type>li').click( function() {
		$(this).toggleClass('unchecked');

		var type = $(this).attr('class');

		$('.type-' + niveau).toggle();
	})

	$('#matiere')
	.select2({
	    placeholder: "Choisir une matière",
	    allowClear: true
	})
	.on("change", function(e) {
		for (var i = e.val.length - 1; i >= 0; i--) {
		 	$('.matiere-' + e.val[i]).toggle();
		}; 

	});
});