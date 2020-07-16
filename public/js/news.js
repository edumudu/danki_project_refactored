(function(){
  const select = document.querySelector('select[name=categoria]');

  select.addEventListener('change', function() {
    location.href = `/news/${this.value}`;
  });
})()
