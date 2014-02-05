$(function(horairesMinutes) {

	$('.debut-fin-cours :first-child').change(function(){

		var that = $(this);
		var next = that.next().children(), acceptedValues = horairesMinutes[$(this).val()];

		for (var i = 0, c = next.length ; i < c; i++) {
			if($.inArray(parseInt(next[i].value), acceptedValues) > -1)
			{
				$(next[i]).removeAttr('disabled');	
			}
			else
			{
				$(next[i]).attr('disabled','disabled');
			}
		};

		next = that.next();
		next.children('option[disabled!=disabled]').first().attr("selected", "selected");

	}).trigger('change');

}(horairesMinutes));