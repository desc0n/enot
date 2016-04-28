$(function() {
    $('#side-menu').metisMenu();
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function () {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function () {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }

    $('#newPhone').keyup(function () {
        if ($(this).val().length != 10) {
            $(this).parent().parent().attr('class', 'col-lg-6 has-error');
            $('#newPhoneError').attr('class', 'control-label');

            return false;
        }

        $(this).parent().parent().attr('class', 'col-lg-6');
        $('#newPhoneError').attr('class', 'control-label hide');
    });

    $('#newName').keyup(function () {
        $(this).parent().attr('class', 'col-lg-6');
        $('#newNameError').attr('class', 'control-label hide');
    });

    $('#addNewCustomer').click(function () {
        if ($('#newPhone').val().length != 10) {
            var errorText = '<div class="alert alert-danger"><strong>Количество цифр телефона не равно 10!</strong> ' +
                'Проверьте правильность ввода номера телефона.</div>';
            $('#newPhone').parent().parent().attr('class', 'col-lg-6 has-error');
            $('#newPhoneError').attr('class', 'control-label');
            $('#errorModalBody').html(errorText);
            $('#errorModal').modal();

            return false;
        }

        if ($('#newName').val().length == 0) {
            var errorText = '<div class="alert alert-danger"><strong>Не указано наименование!</strong> ' +
                'Проверьте зополненность поля наименование.</div>';
            $('#newName').parent().attr('class', 'col-lg-6 has-error');
            $('#newNameError').attr('class', 'control-label');
            $('#errorModalBody').html(errorText);
            $('#errorModal').modal();

            return false;
        }

        $.ajax({
            type: 'POST', url: '/ajax/check_user_phone', async: true, data: {
                phone: $('#newPhone').val()
            },
            success: function (data) {
                if (data == 1) {
                    var errorText = '<div class="alert alert-danger"><strong>Клиент с таким номером телефона есть в базе!</strong> ' +
                        'Проверьте правильность ввода номера телефона.</div>'
                    $('#errorModalBody').html(errorText);
                    $('#errorModal').modal();

                    return false;
                }

                addCustomerForm.submit();
            }
        });
    });

    $('#redactNewCustomer').click(function () {
        if ($('#redactName').val().length == 0) {
            var errorText = '<div class="alert alert-danger"><strong>Не указано наименование!</strong> ' +
                'Проверьте зополненность поля наименование.</div>';
            $('#redactName').parent().attr('class', 'col-lg-6 has-error');
            $('#redactNameError').attr('class', 'control-label');
            $('#errorModalBody').html(errorText);
            $('#errorModal').modal();

            return false;
        }

        redactCustomerForm.submit();
    });

    $('#newProductCode').typeahead({
        source: function (item, process) {
            return $.get('/ajax/find_product_by_item', {
                item: item
            }, function (response) {
                var data = [];
                var parseResponse = JSON.parse(response);

                for (var i in parseResponse) {
                    data.push(parseResponse[i].item_id + '#' + parseResponse[i].full_size + ' ' + parseResponse[i].model);
                }

                return process(data);
            });
        },
        highlighter: function (item) {
            var parts = item.split('#');
            var html = '<div class="typeahead">' +
                '<div class="pull-left margin-small">' +
                '<div class="text-left"><strong>' + parts[0] + '</strong></div>' +
                '</div>' +
                '<div class="clearfix"></div>' +
                '</div>';

            return html;
        },
        updater: function (item) {
            var parts = item.split('#');
            $('#newProductName').val(parts[1]);

            return parts[0];
        }
    });

    $('#newProductName').typeahead({
        source: function (name, process) {
            return $.get('/ajax/find_product_by_name', {
                name: name
            }, function (response) {
                var data = [];
                var parseResponse = JSON.parse(response);

                for (var i in parseResponse) {
                    data.push(parseResponse[i].item_id + '#' + parseResponse[i].full_size + ' ' + parseResponse[i].model);
                }

                return process(data);
            });
        },
        highlighter: function (name) {
            var parts = name.split('#');
            var html = '<div class="typeahead">' +
                '<div class="pull-left margin-small">' +
                '<div class="text-left"><strong>' + parts[1] + '</strong></div>' +
                '</div>' +
                '<div class="clearfix"></div>' +
                '</div>';

            return html;
        },
        updater: function (name) {
            var parts = name.split('#');
            $('#newProductCode').val(parts[0]);

            return parts[1];
        }
    });

    $('#dataTables-sales').dataTable();




    $('#addSaleProductRow').click(function(){
        var rowCount = $('.newSaleProductRow').length;
        var newRowCount = rowCount + 1;

        var html = '<p id="row-' + newRowCount + '" class="newSaleProductRow">' +
            '<input type="hidden" id="newSaleProductCode' + newRowCount + '" name="newSaleProductCode[]">' +
            '<input class="col-lg-12-important form-control newSaleProductName" id="newSaleProductName' + newRowCount + '"' +
            'data-row="' + newRowCount + '"' +
            'name="newSaleProductName[]" placeholder="Название товара" autocomplete="off">' +
            '</p>' +
            '<script>' +
            '$("#newSaleProductName' + newRowCount +'").typeahead({' +
                'source: function (item, process) {' +
                    'return $.get("/ajax/find_product_by_item", {' +
                        'item: item' +
                    '}, function (response) {' +
                        'var data = [];' +
                        'var parseResponse = JSON.parse(response);' +
                        'for (var i in parseResponse) {' +
                            'data.push(parseResponse[i].item_id + "#" + parseResponse[i].full_size + " " + parseResponse[i].model);' +
                        '}' +
                        'return process(data);' +
                    '});' +
                '},' +
                'highlighter: function (item) {' +
                    'var parts = item.split("#");' +
                    'var html = "<div class=\'typeahead\'>" +' +
                        '"<div class=\'pull-left margin-small\'>" +' +
                        '"<div class=\'text-left\'><strong>" + parts[0] + "#" + parts[1] + "</strong></div>" +' +
                        '"</div>" +' +
                        '"<div class=\'clearfix\'></div>" +' +
                        '"</div>";' +
                    'return html;' +
                '},' +
                'updater: function (item) {' +
                    'var parts = item.split("#");' +
                    '$("#newSaleProductCode' + newRowCount +'").val(parts[0]);' +
                    'return parts[1];' +
                '}' +
            '});' +
        '</script>';

        $('#newSaleProductList').append(html);
    });
});

function initTypeahead($newSaleProductName) {
    $newSaleProductName.typeahead({
        source: function (item, process) {
            return $.get('/ajax/find_product_by_item', {
                item: item
            }, function (response) {
                var data = [];
                var parseResponse = JSON.parse(response);

                for (var i in parseResponse) {
                    data.push(parseResponse[i].item_id + '#' + parseResponse[i].full_size + ' ' + parseResponse[i].model);
                }

                return process(data);
            });
        }
    });

    return false;
}

function initChange($newSaleProductName) {
    var current = $newSaleProductName.typeahead("getActive");
    var parts = current.split('#');
    var rowId = $newSaleProductName.data('row');

    $('#newSaleProductCode' + rowId).val(parts[0]);
    $newSaleProductName.val(parts[1]);
}
