$(document).ready(function () {
    if ($('#kt_repeater_1').length) {
        $('#kt_repeater_1').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    }
    $(document).on('click', '#usePromocode', function () {
        $.ajax({
            url: "/promocodes/use-code",
            method: "POST",
            data: {code: $('[name="promocode"]').val()}
        }).done(function (data) {
            data =  JSON.parse(data)
            if(data.result == 'error'){
                alert(data.error);
                return false;
            } else {
                alert(data.result);
                $('#usePromocode').addClass('hidden');
                $('#cancelPromocode').removeClass('hidden')
            }

        })
    })
    $(document).on('click', '#cancelPromocode', function () {
        $.ajax({
            url: "/promocodes/cancel-code",
            method: "POST",
            data: {code: $('[name="promocode"]').val()}
        }).done(function (data) {
            data =  JSON.parse(data)
            if(data.result == 'error'){
                alert(data.error);
                return false;
            } else {
                alert(data.result);
                $('#usePromocode').removeClass('hidden');
                $('#cancelPromocode').addClass('hidden')
            }

        })
    })
})