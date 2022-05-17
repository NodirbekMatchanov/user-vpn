$(document).ready(function () {

    var URLToArray = function(url){
        function parse_mdim(name, val, data){
            let params = name.match(/(\[\])|(\[.+?\])/g);
            if(!params)params = new Array();
            let tg_id = name.split('[')[0];


            if(!(tg_id in data)) data[tg_id] = [];
            var prev_data = data[tg_id];

            for(var i=0;i<params.length;i++){
                if(params[i]!='[]'){
                    let tparam = params[i].match(/\[(.+)\]/i)[1];
                    if(!(tparam in prev_data)) prev_data[tparam] = [];
                    prev_data = prev_data[tparam];
                }else{
                    prev_data.push([]);
                    prev_data = prev_data[prev_data.length-1];
                }

            }
            prev_data.push(val);

        }

        var request = {};
        var arr = [];
        var pairs = url.substring(url.indexOf('?') + 1).split('&');

        for (var i = 0; i < pairs.length; i++) {
            var pair = pairs[i].split('=');
            if(decodeURIComponent(pair[0]).indexOf('[')!=-1)
                parse_mdim(decodeURIComponent(pair[0]), decodeURIComponent(pair[1]), request);
            else
                request[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
        }

        //To-do here check array and simplifity it: if parameter end with one index in array replace it by value [0]

        return request;
    }

    var getParams = URLToArray(window.location.href);

    if(getParams.hasOwnProperty("promocode")) {
        setCookie('promocode', getParams.promocode, {secure: true, 'max-age': 3600 *24*30});
        console.log(getCookie('promocode'))
    }
    if(getParams.hasOwnProperty("ref")) {
        setCookie('promocode', getParams.ref, {secure: true, 'max-age': 3600 *24*30});
        console.log(getCookie('promocode'))
    }


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

    function setCookie(name, value, options = {}) {

        options = {
            path: '/',
        };

        if (options.expires instanceof Date) {
            options.expires = options.expires.toUTCString();
        }

        let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

        for (let optionKey in options) {
            updatedCookie += "; " + optionKey;
            let optionValue = options[optionKey];
            if (optionValue !== true) {
                updatedCookie += "=" + optionValue;
            }
        }

        document.cookie = updatedCookie;
    }

    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
})