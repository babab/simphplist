$(document).ready(function() {
    // Show hidden divs
    $('.words-show').click(function (){
        $(this).hide('slow');
        $('.words-hidden').show('slow');
    });
    $('.chars-show').click(function (){
        $(this).hide('slow');
        $('.chars-hidden').show('slow');
    });
    $('.text-toggle').click(function (){
        $('.text-hidden').toggle('slow');
    });

    // Bacon Ipsum API call
    $("#paras").change(function() {
        var paras = parseInt($('#paras').val());

        if (paras >= 1 && paras <= 100) {
            $.getJSON(
                'http://baconipsum.com/api/?callback=?',
                {'type':'meat-and-filler', 'paras': paras},
                function(bacon) {
                    var text = '';
                    if (bacon && bacon.length > 0) {
                        for (var i = 0; i < bacon.length; i++)
                            text += bacon[i] + "\n\n";
                        $('#text').val(text);
                    }
            });
        }
    });
});
