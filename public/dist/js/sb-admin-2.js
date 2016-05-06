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

    $('#dataTables-sales').dataTable();
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

function removeContent(id){
    var den = confirm('Подтверждаете удаление контента?');
    
    if (!den) {
        return false;
    }
    
    $.ajax({type: 'POST', url: '/ajax/remove_content', async: true, data:{id: id},
        success: function(data) {
            $('#rowContent' + id).remove();
        }
    });
}

function hideContent(id){
    $.ajax({type: 'POST', url: '/ajax/hide_content', async: true, data:{id: id},
        success: function() {
            var html =
                '<button class="btn btn-success" onclick="showContent(' + id + ');">' +
                '<span class="glyphicon glyphicon-eye-open"></span> Показать' +
                '</button>';

            $('#rowContent' + id + ' .rowBtn1').html(html);
        }
    });
}

function showContent(id){
    $.ajax({type: 'POST', url: '/ajax/show_content', async: true, data:{id: id},
        success: function() {
            var html =
                '<button class="btn btn-warning" onclick="hideContent(' + id + ');">' +
                '<span class="glyphicon glyphicon-eye-close"></span> Скрыть' +
                '</button>';

            $('#rowContent' + id + ' .rowBtn1').html(html);
        }
    });
}
