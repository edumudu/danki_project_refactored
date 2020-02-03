$(function(){
    let curSlide = 0,
        delay = 3,
        maxSlide = $('.slider') !== undefined ? $('.slider .slide-img').length - 1: 0,
        imgs;

    initSlider();

    let intervalSlide = setInterval(function(){
        changeSlide()
    }, delay * 1000);

    $('.slider').on('click','.bullets span', function(){
        changeBullet($(this).index());
        curSlide = $(this).index();
        clearInterval(intervalSlide);
        changeSlide(true)
        intervalSlide = setInterval(function(){
            changeSlide();
        }, delay * 1000)    
    })

    function initSlider(){
        imgs = $('.slider .slide-img');
        imgs.hide();
        imgs.eq(0).show();
        initBullets();
    }

    function changeSlide(click=false){
        imgs.fadeOut();
        if(!click)
            curSlide = curSlide >= maxSlide ? 0 : curSlide + 1;
        imgs.eq(curSlide).fadeIn();
        changeBullet(curSlide);
    }

    function initBullets(){
        let el = $('.slider .bullets') !== undefined ? $('.slider .bullets') : undefined;
        for(let i = 0; i <= maxSlide; i++){
            el.append("<span></span>");
        }
        el.find('span').eq(curSlide).addClass('active');
    }

    function changeBullet(i){
        $('.slider .bullets span').removeClass('active');
        $('.slider .bullets span').eq(i).addClass('active');
    }
})