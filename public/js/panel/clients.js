(function () {
  Array.from(document.querySelectorAll('.box-action .btn-delete'), button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();

      const box = this.parentElement.parentElement.parentElement;

      fetch(`${location.href}/panel/ajax/crud.php`, {
        method: 'delete',
        body: {
          tb: 'tb_admin.clientes',
          id: box.getAttribute('item_id'),
          img: 'img'
        }
      })
        .then(() => box.remove());
    })
  })
})()
