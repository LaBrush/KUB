// garde une trace du nombre de champs tuteurs qui ont été affichés
var tuteurCount = '{{ form.tuteurs | length }}';

$(document).ready(function() {
    $('.add-another-tuteurs').click(function() {
        var tuteurList = $('#kub_userbundle_eleve_tuteursAdd');

        var newWidget = tuteurList.attr('data-prototype');
        newWidget = newWidget.replace(/__name__/g, tuteurCount);
        tuteurCount++;

        var newLi = $('<p></p>').html(newWidget);
        newLi.appendTo(tuteurList);

        return false;
    });
})