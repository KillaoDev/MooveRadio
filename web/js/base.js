$(function(){
    // Open a new window with the player foreach each .player-open elements
    $(document).on('click', '.player-open', function(){
        window.open(Routing.generate('player', {_locale: CONSTANTS.LANG}),'','width=255,height=315');
    });

    // Transform the menu into navbar when we scroll.
    var $navbar = $('.navbar');
    var positionElementInPage = $navbar.offset().top;
    var margin = parseInt($navbar[0].offsetHeight) + parseInt($navbar.css('margin-bottom'));
    $(window).on('scroll', function() {
        if ($(window).scrollTop() >= positionElementInPage)
        {
            $('.navbar').addClass("navbar-fixed-top");
            $('body>.container>header:first').css('margin-bottom', margin);
        }
        else
        {
            $('.navbar').removeClass("navbar-fixed-top");
            $('body>.container>header:first').css('margin-bottom', 0);
        }
    });
});