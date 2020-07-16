$(function(){
    $('select[name=categoria]').change(function(){
        location.href = `/news/${$(this).val()}`;
    })
})