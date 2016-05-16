function checkContactSendForm() {
    var email = jQuery('#email').val();
    var subject = jQuery('#subject').val();
    var message = jQuery('#message').val();
    var checkCode = jQuery('#check_code').val();
    
    if (email == '') {
        alert('Укажите свой email!');
        
        return false;
    }
    
    if (subject == '') {
        alert('Укажите тему письма!');
        
        return false;
    }
    
    if (message == '') {
        alert('Укажите текст письма!');
        
        return false;
    }
    
    jQuery.ajax({type: 'POST', url: '/ajax/check_code', async: true, data:{code: checkCode},
        success: function(data) {
            var result = JSON.decode(data);
            
            if (result == 'success') {
                jQuery('#contactsSendForm').submit();
            } else {
                alert('Некорректно указан проверочный код!');

                return false;
            }
        }
    });
}
