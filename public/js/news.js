$(function(){
    $('select[name=categoria]').change(function(){
        location.href = `${location.href.split('news')[0]}news/${$(this).val()}`;
    })
})