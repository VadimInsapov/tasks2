$('.open-popup').click(function(e) {
    $(this).next().fadeIn(800);
    $('html').addClass('no-scroll');
});

$('.close-popup').click(function() {
    $('.popup-bg').fadeOut(800);
    $('html').removeClass('no-scroll');
});

$('.edit-task-button').click(function(e) {
    $(this).parent().parent().next().fadeIn(800);
    $('html').addClass('no-scroll');
});