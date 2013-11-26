$(function() {

	// Cette fonction redimmensionner les boites des moyennes

	for (var i = $('.graph-hidden>td>div').get().length - 1; i >= 0; i--)
	{
		var reg = new RegExp("(jauge-)", "g");

		var matiere = $('.graph-hidden>td>div').get(i).className.replace(reg, "") ;
		var moyenneMatiere = $('.moyenne-' + matiere).text();
		var tailleJauge = moyenneMatiere * 4 + 'px' ;

		$('.jauge-' + matiere).css('height', tailleJauge);
	}

	// Cette fonction lance l'animation des notes au lancement

	$('.graph-hidden')
	.addClass('graph')
	.removeClass('graph-hidden');
});