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
    return aside.offsetWidth !== '0';
  }

  document.querySelector('.menu-btn').addEventListener('click', function () {
    if (open) {
      panel.style.gridTemplateColumns = '0 1fr';
    } else {
      panel.style.gridTemplateColumns = `${targetSize}px 1fr`;
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
