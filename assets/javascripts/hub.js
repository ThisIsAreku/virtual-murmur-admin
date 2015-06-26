$(function () {
    $('#add-config-submit').click(function (e) {
        var $newInput = $('<input />', {
            type: 'text',
            name: $('#form-new-config').data('key')+'['+$('#add-config-key').val()+']',
            value: $('#add-config-value').val()
        });
        $('#form-new-config').append($newInput);
        console.log($newInput);
    });
})
