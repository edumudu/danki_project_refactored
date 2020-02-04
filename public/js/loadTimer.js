$(function(){
    let el = $('.box-especialidade'),
        current = 0,
        max = el.length,
        timer,
        animationDelay = 1;

    init();
    function animateExecute(){
        if(current == max) clearInterval(timer);
        else el.eq(current).fadeIn()
        current++
    }

    function init(){
        el.hide();
        timer = setInterval(animateExecute, animationDelay*1000)
    }

})