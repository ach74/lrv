
// URL PAGINA WEB
var url = "http://proyecto-laravel-fotos.com.devel/";

window.addEventListener('load', function () {

    $('.btn-like').css('cursor', 'pointer');

    $('.btn-dislike').css('cursor', 'pointer');

    //Boton de like
    function like() {
        $('.btn-like').unbind('click').click(function () {
            console.log("Like");
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', url + 'img/hearts-red.png');
            $.ajax({
                url: url + '/like/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    if (response.like) {
                        console.log('Has dado like a la publicacion ');
                    } else {
                        console.log('Error al dar like');
                    }
                }
            });
            dislike();
        });
    }
    like();

    function dislike() {
        $('.btn-dislike').unbind('click').click(function () {
            console.log("Dislike");
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', url + 'img/hearts-black.png');
            like();
            $.ajax({
                url: url + '/dislike/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    if (response.like) {
                        console.log('Has dado dislike a la publicacion');
                    } else {
                        console.log('Error al dar dislike');
                    }
                }
            });
        });
    }
    dislike();


    // Buscador

    $('#buscador').submit(function(e){
        $(this).attr('action', url + 'gente/' + $('#buscador #search').val())
    });
});