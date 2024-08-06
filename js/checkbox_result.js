$(document).ready(function() {
    $('[data-ajax-handler]').change(function() {
        var element = $(this);
        var checked = element.is(':checked');
        var monId = element.data('monId');
        var monDat = element.data('monDat');
        var ajaxname = element.data('ajaxname');
        var serverScript = element.data('serverScript');

        // Проверка наличия значения dat и его преобразование
        var formattedDat = '';
        if (monDat) {
            var parts = monDat.split('-');
            if (parts.length >= 2) {
                formattedDat = parts[0] + '-' + parts[1];
            }
        }

        $.ajax({
            url: serverScript,
            type: 'POST',
            data: {
                monId: monId,
                ajaxname: checked ? 1 : 0
            },
            success: function(response) {
                console.log(response);
                if (ajaxname === 'stat' && checked) {
                    // Переход на корень сайта, если элемент с атрибутом data-ajaxname равным 'stat' включен (1).
                    window.location.href = '/index.php?date=' + formattedDat + '&status=success';
                } else {
                    // В противном случае выполнить перезагрузку страницы.
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
});
