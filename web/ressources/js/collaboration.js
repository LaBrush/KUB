$(function() {

	$('.input-newliste').removeAttr('required');
	$('.newListe').hide();

	$('.button-liste').click(function() {
		$('.listeTaches').remove();
		$(this).remove();
		$('.input-newliste').attr('required', 'required');
		$('.newListe').show();
	});
});