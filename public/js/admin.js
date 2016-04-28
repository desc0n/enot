function searchAction(val){
    $('#typeahead').html('');
    $.ajax({type: 'POST', url: '/ajax/get_typeahead_admin', async: true, data:{searchText: val},
        success: function(data) {
            $('#typeahead').html(data);
        }
    });
}
$(document).ready(function(){
    $('#searchField').keyup(function(){
        searchAction($(this).val());
    });
    $('#searchAction').click(function(){
        var val = $('#searchField').val();
        searchAction(val);
    });
    $('body').click(function(){
        $('#typeahead .typeahead').css('display', 'none');
    });
});


function changePassword()
{
    $('#infoModal .modal-body').html('');
    $.ajax({type: 'POST', url: '/ajax/change_password', async: true,
        success: function(data) {
            $('#infoModal .modal-body').html('<div class="alert alert-success"><strong>Пароль успешно изменен!</strong> Новый пароль отправлен на почту.</div>');
            $('#infoModal').modal('toggle');
        }
    });
}