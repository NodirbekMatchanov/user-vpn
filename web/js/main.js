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

    if(getParams.hasOwnProperty("promocode") && getCookie('promocode') === undefined) {
        setCookie('promocode', getParams.promocode, {secure: true, 'max-age': 3600 *24*30});
        setPromo(getParams.promocode)
        console.log(getCookie('promocode'))
    }
    if(getParams.hasOwnProperty("ref") && getCookie('promocode') === undefined) {
        setCookie('promocode', getParams.ref, {secure: true, 'max-age': 3600 *24*30});
        setPromo(getParams.ref)
        console.log(getCookie('promocode'))
    }

    function setPromo(promocode) {
        $.ajax({
            url: "/used-promocodes/visit-save",
            method: "GET",
            data: {
                visit: true,
                promocode: promocode
            }
        })
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

    $(document).on('focusout', '[name="register-form[promocode]"]', function () {
        $('.valid-promocode').text('');
        $('.field-register-form-promocode').removeClass('has-error');
        $.ajax({
            url: "/promocodes/validation",
            method: "POST",
            data: {code: $('[name="register-form[promocode]"]').val()}
        }).done(function (data) {
            data = JSON.parse(data);
            if(data.result == 'success'){
                $('.valid-promocode').html("<i>"+data.description+"</i>");
            }
            if(data.result == 'error'){
               setTimeout(function (){
                   $('.field-register-form-promocode').addClass('has-error');
               },500)
                $('.valid-promocode').text(data.error);
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

    $(document).on("click",'.auto-signup',function (){
        let element = $('[name="email"]')[0];
        $('[name="email"]').removeClass('validate-email');
        $('.error-email').remove();
        if(ValidateEmail(element)){
            let password = Password.generate(8);
            $.ajax({
                url: "/user/registration/auto-register",
                method: "GET",
                data: {password: password, password_repeat: password, email: element.value}
            }).done(function (data) {
                    if(data) {
                        alert('registrated')
                    }
            }).fail(function () {
                alert('ошибка регистрации')
            })
        } else {
            $('[name="email"]').addClass('validate-email');
            $('[name="email"]').after("<span class='error-email' style='color: red'>не валидный email</span>")
        }
    })

    /* email validate */
    function ValidateEmail(input) {

        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        if (input.value.match(validRegex)) {


            return true;

        } else {

            return false;

        }

    }

    /* generatePassword */

    var Password = {

        _pattern : /[a-zA-Z0-9_\-\+\.]/,


        _getRandomByte : function()
        {
            // http://caniuse.com/#feat=getrandomvalues
            if(window.crypto && window.crypto.getRandomValues)
            {
                var result = new Uint8Array(1);
                window.crypto.getRandomValues(result);
                return result[0];
            }
            else if(window.msCrypto && window.msCrypto.getRandomValues)
            {
                var result = new Uint8Array(1);
                window.msCrypto.getRandomValues(result);
                return result[0];
            }
            else
            {
                return Math.floor(Math.random() * 256);
            }
        },

        generate : function(length)
        {
            return Array.apply(null, {'length': length})
                .map(function()
                {
                    var result;
                    while(true)
                    {
                        result = String.fromCharCode(this._getRandomByte());
                        if(this._pattern.test(result))
                        {
                            return result;
                        }
                    }
                }, this)
                .join('');
        }

    };

    $('.prices-item').on('click',function () {
        if($('.prices-form').hasClass('hidden')) {
            $('.prices-form').removeClass('hidden');
        }
    })
})