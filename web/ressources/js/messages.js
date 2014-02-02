$(function() {

	var $sender = $('.sender');
	var $senderH3 = $('.sender h3');

	if($senderH3.text().length > 20)
	{
		var firstSender = $senderH3.first().text();
		var firstSenderDotted = $senderH3.first().text() + ", ...";

		for (var i = $senderH3.length - 1; i >= 0; i--) {
			var sender = $senderH3[i];

			var senderText = ", " + $(sender).text();

			$(sender).text(senderText);
		};

		$senderH3.first().text(firstSenderDotted);

		$sender.hide();
		$sender.first().show();

		$sender.first().mouseenter( function() {
			$senderH3.first().text(firstSender);
			$sender.show();
		});

		$sender.mouseleave( function() {
			$senderH3.first().text(firstSenderDotted);
			$sender.hide();
			$sender.first().show();
		});
	}

});