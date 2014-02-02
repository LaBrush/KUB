$(function(){

	$('.file').hide();
	$('input:file').removeAttr('required');

	$('input:radio').click(function() {
		if ($('input:radio')[0].checked)
		{
			$('.file').hide();
			$('input:file').removeAttr('required');
			$('.url').show();
			$('.input-url').attr('required', 'required');
		}
		else
		{
			$('.file').show();
			$('input:file').attr('required', 'required');
			$('.url').hide();
			$('.input-url').removeAttr('required');
		}
	})
});