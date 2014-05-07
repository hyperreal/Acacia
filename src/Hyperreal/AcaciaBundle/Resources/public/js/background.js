$(window).scroll(function(e){
    parallax();
});

function parallax(){
    var scrolled = $(window).scrollTop();
    $('.bg').css('bottom',-(scrolled*0.1)+'px');
}
