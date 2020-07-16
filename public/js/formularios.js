(function () {
  Array.from(document.querySelectorAll('form.ajax-form'), form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      const loader = document.querySelector('#ajax-loader');

      loader.style.display = 'flex';

      fetch('/ajax/formularios.php', {
        method: 'post',
        body: JSON.stringify(new FormData(form))
      })
        .then(() => {
          const success = document.querySelector('.success');

          success.style.display = 'block';
          form.reset();

          setTimeout(function () {
            success.style.display = 'none';
          }, 3000)
        })
        .catch(() => {
          const success = document.querySelector('.fail');
          success.style.display = 'block';

          setTimeout(function () {
            success.style.display = 'none';
          }, 3000)
        })
        .finally(() => loader.style.display = 'none')
    });
  });
})()
