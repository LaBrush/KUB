$(function() {

	$('.comments').hide();

	$('.show-comments').click( function() {

		$(this).next().show();
		$(this).hide();
	});
});
