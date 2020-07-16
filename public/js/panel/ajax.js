(function () {
  Array.from(document.querySelectorAll('form.ajax'), form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      this.style.opacity = 0.7;
      this.querySelector('[type=submit]').setAttribute('disabled', true);

      const alertMessage = document.createElement('div');
      alertMessage.classList.add('float');

      fetch(form.getAttribute('action'), {
        method: form.getAttribute('method'),
        body: JSON.stringify(new FormData(form))
      })
        .then(({ data }) => {
          alertMessage.classList.add('success');
          alertMessage.innerHTML = data.message;

          form.reset();
        })
        .catch(({ data }) => {
          alertMessage.innerHTML = data.message;
          alertMessage.classList.add('error');
        })
        .finally(() => {
          document.prepend(alertMessage);
          setTimeout(() => alertMessage.remove(), 5000);

          this.style.opacity = 1;
          this.querySelector('[type=submit]').setAttribute('disabled', false);
        })
    })
  })
})()
