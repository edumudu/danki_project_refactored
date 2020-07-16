(function(){
  document.querySelector('nav.mobile i').addEventListener('click', function () {
    const menu = document.querySelector('nav.mobile ul');
    const icon = this;

    if (menu.style.display === 'none' || !menu.style.display) {
      icon.classList.remove('fa-bars');
      icon.classList.add('fa-times');
      menu.style.display = 'block';
    } else {
      icon.classList.remove('fa-times');
      icon.classList.add('fa-bars');
      menu.style.display = 'none';
    }
  });
})()
