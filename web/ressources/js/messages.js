$(function() {

	var firstSender = $('.sender h3').first().text();
	var firstSenderDotted = $('.sender h3').first().text() + ", ...";

	for (var i = $('.sender h3').length - 1; i >= 0; i--) {
		var sender = $('.sender h3')[i];

		var senderText = ", " + $(sender).text();

		$(sender).text(senderText);
	};

	$('.sender h3').first().text(firstSenderDotted);

	$('.sender').hide();
	$('.sender').first().show();

	$('.sender').first().mouseenter( function() {
		$('.sender h3').first().text(firstSender);
		$('.sender').show();
	});

	$('.sender').mouseleave( function() {
		$('.sender h3').first().text(firstSenderDotted);
		$('.sender').hide();
		$('.sender').first().show();
	});


});