(function () {
  let curSlide = 0,
    delay = 3,
    maxSlide,
    imgs,
    bullets,
    intervalSlide;

  initSlider();
  startInterval();

  function startInterval() {
    intervalSlide = setInterval(function () {
      changeSlide(maxSlide > curSlide ? curSlide + 1 : 0);
    }, delay * 1000)
  }

  function initSlider() {
    imgs = document.querySelectorAll('.slider .slide-img');
    maxSlide = imgs.length - 1;
    hideAll();
    imgs[0].style.display = 'block';

    initBullets();
  }

  function initBullets() {
    const bullet = document.createElement('span');
    const bulletsWrapper = document.querySelector('.slider .bullets');

    imgs.forEach(img => bulletsWrapper.appendChild(bullet.cloneNode()));

    bulletsWrapper.children[curSlide].classList.add('active');
    bullets = bulletsWrapper.children;

    Array.from(bullets, (bullet, index) => {
      bullet.addEventListener('click', function () {
        changeSlide(index);
        clearInterval(intervalSlide);

        startInterval();
      });
    })
  }

  function hideAll() {
    Array.from(imgs, img => img.style.display = 'none');
  }

  function changeSlide(index) {
    hideAll();

    curSlide = index;
    imgs[index].style.display = 'block';
    changeBullet(index);
  }

  function changeBullet(i) {
    Array.from(bullets, bullet => bullet.classList.remove('active'));
    bullets[i].classList.add('active');
  }
})()
