(function () {
  const aside = document.querySelector('aside');
  const panel = document.querySelector('.panel-top');

  let open = asideIsVisible(),
    targetSize = getSize();

  window.onresize = function () {
    targetSize = getSize();
    open = asideIsVisible();
  }

  function getSize() {
    return window.innerWidth <= 400 ? 200 : 300;
  }

  function asideIsVisible() {
    return aside.style.width !== '0px';
  }

  document.querySelector('.menu-btn').addEventListener('click', function () {
    if (open) {
      aside.style.width = 0;
      panel.style.paddingLeft = 0;
    } else {
      aside.style.width = `${targetSize}px`;
      panel.style.paddingLeft = `${targetSize}px`;
    }

    open = !open;
  });

  Array.from(document.querySelectorAll('.btn-delete'), button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();

      if (confirm("Você realmente deseja excluir este item?")) {
        const id = this.getAttribute('id-ref');

        fetch(`${location.href}?excluir=${id}`, {
          method: 'delete',
        }).then(() => location.reload());
      }
    });
  });

  Array.from(document.querySelectorAll('.order'), button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();

      const formData = new FormData();

      formData.append('order', this.getAttribute('order'));
      formData.append('id', this.parentElement.getAttribute('id'));

      fetch(`${location.href}/order`, {
        method: 'post',
        body: formData
      }).then(() => location.reload());
    })
  });
})()
